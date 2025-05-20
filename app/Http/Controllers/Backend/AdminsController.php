<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\AdminPermissionDict;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminsController extends Controller
{
    public function index()
    {
        return AdminResource::collection(Admin::all());
    }

    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->save();
        return new AdminResource($admin);
    }

    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $request->validated();
        $admin->name = $request["name"];
        $admin->lastname = $request["lastname"];
        $permissions= $request["permissions"];
        $admin->permissions = $permissions["id"];
        $admin->email = $request["email"];
        if ($request["password"]) { $admin->password = Hash::make($request["password"]);};
        $admin->save();
        return response(new AdminResource($admin), Response::HTTP_OK);
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->noContent();
    }

    public function getAllPermissions()
    {
        return(AdminPermissionDict::select('id','name')->get()->toArray());
    }
}
