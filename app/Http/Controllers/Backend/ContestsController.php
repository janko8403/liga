<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContestRequest;
use App\Http\Resources\ContestResource;
use App\Models\Contest;
use App\Models\UserPermission;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ContestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Contest::all(),200);
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
        $contest = new Contest();
        $contest->name = 'Nowy konkurs';
        $contest->save();
        return response($contest,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        return response(ContestResource::make(Contest::with('permissions')
            ->with('header')
            ->where('id', $contest["id"])
            ->first()), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function update(ContestRequest $request, Contest $contest)
    {
        $request->validated();

        UserPermission::where('activity_id','=', $contest->id)->where('permission_type','=','contest')->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $contest->id,
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'contest',
                ]);
                $newPermission->save();
            }
        }

        $contest->name = $request["name"];
        #$contest->slug = $request["slug"];
        $contest->status = $request["status"];
        $contest->active_from = $request["active_from"];
        $contest->active_to = $request["active_to"];
        $contest->description_before = $request["description_before"];
        $contest->description_after = $request["description_after"];
        $contest->type = $request["type"];
        $contest->save();
        return response(new ContestResource($contest), Response::HTTP_OK);    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest)
    {
        $contest->with('answers')->delete();
        return(response('Deleted',204));
    }
}
