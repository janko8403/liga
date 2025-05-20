<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Requests\CMSSectionDataRequest;
use App\Http\Requests\CMSSectionRequest;
use App\Http\Resources\CMSComponentDataResource;
use App\Http\Resources\CMSComponentsResource;
use App\Http\Resources\CMSSectionResource;
use App\Models\CMSComponentData;
use App\Models\CMSComponents;
use App\Models\CMSSection;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;

class CMSSectionsController extends Controller
{
    public function index($menuid)
    {
        return CMSSectionResource::collection(
            CMSSection::with('component')
                ->with('data')
                ->with('page')
                ->where('menu_id',$menuid)
                ->orderBy('order_id','asc')
                ->get()->toArray());
    }

    public function store(CMSSectionRequest $request)
    {
        $cmsSection = CMSSection::create($request->validated());
        $cmsSection->order_id = CMSSection::where('menu_id',$cmsSection->menu_id)->max('order_id')+1;
        $cmsSection->save();
        return new CMSSectionResource($cmsSection);
    }

    public function show(CMSSection $cmsSection)
    {
        return new CMSSectionResource($cmsSection);
    }

    public function update(CMSSectionRequest $request, CMSSection $section)
    {
        $request->validated();
        $cmsSection = CMSSection::where('id',$section)->first();
        $cmsSection->title = $request["title"];
        $cmsSection->published = $request["published"];
        $cmsSection->description = $request["description"];
        $cmsSection->parent_id = $request["parent_id"];
        $cmsSection->save();
        return response(new CMSSectionResource($cmsSection), Response::HTTP_OK);
    }

    public function destroy($cmsSectionId)
    {
        $cmsSection = CMSSection::where('id',$cmsSectionId)->first();
        DB::raw('update cms_sections set order_id=order_id-1 where id>'.$cmsSection->id);
        $cmsSection->delete();
        return response()->noContent();
    }

    public function getSectionsDefinitions()
    {
        return CMSComponentsResource::collection(
            CMSComponents::all()->groupBy('category')->toArray()
        );
    }

    public function getSectionData($section_id, $component_id)
    {
        return CMSComponentDataResource::collection(
            CMSComponentData::where('section_id', $section_id)
                ->where('component_id', $component_id)
                ->get()
                ->toArray()
        );
    }

    public function updateSectionData(\Illuminate\Http\Request $request)
    {
        $componentDef = CMSComponents::where('id',$request["component_id"])->first();
        foreach($componentDef->parameters as $k => $v) {
            $row = CMSComponentData::firstOrCreate(array('component_id' => $request["component_id"],'section_id' => $request["section_id"],'name' => $k));
            $row->value = $request[$k];
            $row->save();
        }
        $section = CMSSection::where('id',$request["section_id"])->first();
        if ($section) {
            if ($request["columns"]>2 && $request["columns"]<13) {
                $section->columns = $request["columns"];
                $section->save();
            }
        }
    }

    public function moveSection($section_id,$direction)
    {
        $section = CMSSection::where('id',$section_id)->first();
        $columns = 0;
        $new_order = 0;

        switch($direction)  {
            case '1':
                $new_order = $section->order_id - 1;
                break;
            case '2':
                $new_order = $section->order_id + 1;
                break;
            case '3':
                $columns = $section->columns - 1;
                break;
            case '4':
                $columns = $section->columns + 1;
                break;
        }

        if ($new_order > 0) {
            $swapWith = CMSSection::where('menu_id', $section->menu_id)
                ->where('order_id',$new_order)
                ->first();
            if ($swapWith) {
                $swapWith->order_id = $section->order_id;
                $swapWith->save();
            }
            $section->order_id = $new_order;
            $section->save();
        }

        if ($columns > 2 && $columns < 13) {
            $section->columns = $columns;
            $section->save();
        }

    }

    public function getSectionsData($menu_id)
    {
        //return CMSComponentData::where('menu_id',$menu_id);
    }
}
