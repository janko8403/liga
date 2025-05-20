<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\UserPermission;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Notification::with('permissions')->get(),200);
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
        $notification = new Notification();
        $notification->title = 'Nowe powiadomienie';
        $notification->save();
        return response($notification,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Notification::where('id',$id)->with('permissions')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        UserPermission::where('activity_id','=',$request['id'])->where('permission_type','=','notification')->delete();
        if ($request["permissions"]) {
            foreach ($request["permissions"] as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $request['id'],
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'notification',
                ]);
                $newPermission->save();

            }
        }
        $n = Notification::where('id',$request["id"])->first();
        $n->title = $request["title"];
        $n->content = $request["content"];
        $n->cta = $request["cta"];
        $n->status = $request["status"];
        $n->active_from = date('Y-m-d',strtotime($request["active_from"]));
        $n->active_to = date('Y-m-d',strtotime($request["active_to"]));
        $n->save();
        return($n);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($notification)
    {
        Notification::where('id',$notification)->delete();
    }
}
