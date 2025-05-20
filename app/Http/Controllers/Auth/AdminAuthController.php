<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('backend/');
        } else {
            return view('beauth.login');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $admin = auth()->guard('admin')->user();
            $accessToken = $admin->createToken("BEToken")->accessToken;
            session(['token' => $accessToken]);
            return redirect()->intended(url('/backend/'));
        } else {
            return redirect()->back()->withError('Niepoprawne dane logowania.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/backend/login');
    }
}
