<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMSMenuRequest;
use App\Http\Resources\CMSMenuResource;
use App\Models\CMSMenu;
use App\Models\UserPermission;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CMSMenuController extends Controller
{

    public function index()
    {
        return CMSMenu::get();
    }

    public function getMainMenu()
    {
        return CMSMenu::where('parent_id',"0")->get();
    }

    public function store(CMSMenuRequest $request)
    {
        $cmsMenu = CMSMenu::create($request->validated());
        $cmsMenu->save();
        return $cmsMenu->id;
    }

    public function show($id)
    {
        return CMSMenuResource::make(CMSMenu::with('permissions')
            ->where('id',$id)
            ->first());
    }

    public function update(CMSMenuRequest $request)
    {
        $request->validated();
        $cmsMenu = CMSMenu::where('id',$request["id"])->first();

        UserPermission::where('activity_id','=',$request['id'])->where('permission_type','=','cmsMenu')->delete();
        if ($request["permissions"]) {
            foreach ($request["permissions"] as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $request['id'],
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'cmsMenu',
                ]);
                $newPermission->save();

            }
        }

        $cmsMenu->name = $request["name"];
        $cmsMenu->published = $request["published"];
        $cmsMenu->description = $request["description"];
        $cmsMenu->parent_id = $request["parent_id"];
        $cmsMenu->save();
        return response(new CMSMenuResource($cmsMenu), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        #TODO soft delete
        $cmsMenu= CMSMenu::where('id',$id)->first();
        $cmsMenu->delete();

        return response()->noContent();
    }

    public function getMenu($menu_id)
    {
        if (is_numeric($menu_id)) {
            $result = array();
            $res =  array();
            $menuRaw = CMSMenu::with('children')
                ->where('parent_id',intval($menu_id))
                ->get()
                ->toArray();

            foreach ($menuRaw as $row) {
                $children = array();
                foreach ($row['children'] as $child) {
                    $children[] = array(
                        'id' => $child["id"],
                        'text' => $child["name"],
                        'parent_id' => $child["parent_id"],
                    );
                }
                $result[] = array(
                  'id' => $row["id"],
                  'text' => $row["name"],
                  'parent_id' => $row["parent_id"],
                  'children' => $children,
                );
            }
            $res[]["data"]=json_encode($result);
            return(json_encode($res));

            #only mysql/mariadb
            return DB::select(DB::raw("
                SELECT JSON_ARRAYAGG(result) data
                FROM (
                    SELECT
                        CASE WHEN submenu.parent_id IS NOT NULL THEN
                        JSON_OBJECT(
                        'id', menu.id,
                        'text', menu.name,
                        'parent_id', menu.parent_id,
                        'children', JSON_ARRAYAGG(
                            JSON_OBJECT(
                            'id', submenu.id,
                            'text', submenu.name,
                            'parent_id', submenu.parent_id
                            ) order by submenu.order_id
                        )) ELSE
                        JSON_OBJECT(
                        'id', menu.id,
                        'text', menu.name,
                        'parent_id', menu.parent_id
                        )
                        END
                        result
                    FROM cms_menu menu
                    LEFT JOIN cms_menu submenu ON menu.id = submenu.parent_id
                    WHERE menu.parent_id = '" . intval($menu_id) . "'
                    GROUP BY
                        menu.id,
                        menu.name,
                        menu.parent_id,
                        submenu.parent_id
                    ORDER BY
                        menu.order_id
                ) x;
            "));
        }
    }
}
