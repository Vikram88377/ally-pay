<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Web\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Invalid login details'
            ]);
        }

        if (!auth()->user()->hasRole('admin')) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Only admin can login'
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.login');
    }
}