<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function index() {
        $newPhotoCount = User::has('new_photo')
            ->with('new_photo')
            ->count();
        return view('backend.backend')->with(['userUpdate' => $newPhotoCount]);
    }
}
