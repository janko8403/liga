<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\DuelEditionRequest;
use App\Http\Resources\DuelEditionResource;
use App\Models\Duel;
use App\Models\DuelEdition;
use App\Models\UserPermission;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DuelsEditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(DuelEditionResource::collection(DuelEdition::with('permissions')->get()->toArray()));
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
        $now = Carbon::now()->addMonth();
        $startDate = $now->startOfMonth('Y-m-d');
        $endDate = $now->endOfMonth()->format('Y-m-d');

        if (DuelEdition::create([
            'activity_id' => '1',
            'name' => 'Nowa kategoria pojedynków',
            'status' => 0,
            'category' => 'Brak',
            'active_from' => $startDate,
            'active_to' => $endDate,
        ])) {
            return response('Zapisano', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DuelEdition  $duelEdition
     * @return \Illuminate\Http\Response
     */
    public function show($duelEdition)
    {
        return DuelEdition::where('id','=',$duelEdition)
            ->with('header')
            ->with('permissions')
            ->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DuelEdition  $duelEdition
     * @return \Illuminate\Http\Response
     */
    public function edit(DuelEdition $duelEdition)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DuelEdition  $duelEdition
     * @return \Illuminate\Http\Response
     */
    public function update(DuelEditionRequest $request)
    {
        $request->validated();
        $duelEdition = DuelEdition::where('id','=',$request["id"])->first();
        UserPermission::where('activity_id','=',$duelEdition->id)->where('permission_type','=','duelEdition')->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $duelEdition->id,
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'duelEdition',
                ]);
                $newPermission->save();
            }
        }

        $duelEdition->name = $request["name"];
        $duelEdition->activity_id = 1;
        $duelEdition->status = $request["status"];
        $duelEdition->category = $request["category"];

        $duelEdition->active_from = date('Y-m-d',strtotime($request["active_from"]));
        $duelEdition->active_to = date('Y-m-d',strtotime($request["active_to"]));
        $duelEdition->save();
        return response(new DuelEditionResource($duelEdition), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DuelEdition  $duelEdition
     * @return \Illuminate\Http\Response
     */
    public function destroy(DuelEdition $duelEdition)
    {
        //
    }
}
