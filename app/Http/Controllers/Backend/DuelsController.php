<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DuelRequest;
use App\Models\Duel;
use App\Models\DuelData;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DuelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $duel = new Duel();
        $duel->edition_id = $request[0];
        $duel->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function show(Duel $duel)
    {
        return Duel::where('id',$duel->id)->with('permissions')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function edit(Duel $duel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function update(DuelRequest $request, Duel $duel)
    {
        if ($request->validated()) {

            UserPermission::where('activity_id','=',$request['id'])->where('permission_type','=','duel')->delete();
            if ($request["permissions"]) {
                foreach ($request["permissions"] as $permission) {
                    $newPermission = UserPermission::create([
                        'activity_id' => $request['id'],
                        'user_permission_id' => $permission['id'],
                        'permission_type' => 'duel',
                    ]);
                    $newPermission->save();

                }
            }

            $first_msk = $request["first_nepu"];
            $second_msk = $request["second_nepu"];

            $duel->first_nepu = is_string($first_msk)||is_null($first_msk)?$first_msk:$first_msk["nepu_msk"];
            $duel->second_nepu = is_string($second_msk)||is_null($second_msk)?$second_msk:$second_msk["nepu_msk"];
            $duel->status = $request["status"];
            $duel->active_from = date('Y-m-d',strtotime($request["active_from"]));
            $duel->active_to = date('Y-m-d',strtotime($request["active_to"]));
            $duel->type = $request["type"];
            $duel->award = $request["award"];
            $duel->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Duel $duel)
    {
        $duel->delete();
    }

    public function getEditionDuels($edition_id)
    {
        return Duel::where('edition_id','=',$edition_id)
            ->with('firstContender')
            ->with('secondContender')
            ->get();
    }

    public function getMSKTeams($edition_id,$nepu1='',$nepu2='')
    {
        return DuelData::select('id','msk','nepu_msk')
            ->whereNotIn('nepu_msk', DB::table('duels')
                    ->select('first_nepu')
                    ->where('edition_id','=',$edition_id)
                    ->where('first_nepu','!=',$nepu1)
                    ->where('second_nepu','!=',$nepu1)
                    ->where('first_nepu','!=',$nepu2)
                    ->where('second_nepu','!=',$nepu2)
                    ->whereNotNull('first_nepu')
            )
            ->whereNotIn('nepu_msk', DB::table('duels')
                ->select('second_nepu')
                ->where('edition_id','=',$edition_id)
                ->where('first_nepu','!=',$nepu1)
                ->where('second_nepu','!=',$nepu1)
                ->where('first_nepu','!=',$nepu2)
                ->where('second_nepu','!=',$nepu2)
                ->whereNotNull('second_nepu')
            )
            ->get()->toArray();
    }
}
