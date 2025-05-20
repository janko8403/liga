<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Http\Requests\DuelConfigRequest;
use App\Http\Requests\DuelRequest;
use App\Http\Resources\DuelResource;
use App\Models\DuelConfig;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DuelsConfigController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
        return DuelResource::make(DuelConfig::with('permissions')
            ->with('editions')
            ->without('description')
            ->with('header')
            ->where('id', 1)
            ->first());
        //TODO jakby było potrzebnych wiecej edycji aktywnosci pojedynkow
        //->where('id', $duelConfig["id"])
    }

    public function update(DuelConfigRequest $request)
    {
        $request->validated();
        $duelConfig = DuelConfig::where('id',1)->first();
        UserPermission::where('activity_id','=',$duelConfig->id)->where('permission_type','=','duelsConfig')->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $duelConfig->id,
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'duelsConfig',
                ]);
                $newPermission->save();

            }
        }

        $duelConfig->name = $request["name"];
        $duelConfig->status = $request["status"];
        $duelConfig->active_from = $request["active_from"];
        $duelConfig->active_to = $request["active_to"];
        $duelConfig->save();
        return response(new DuelResource($duelConfig), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
