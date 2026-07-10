<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Merchant\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('merchant.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return back()
                ->withErrors([
                    'email' => 'Invalid login credentials',
                ])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->hasRole('merchant')) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Only merchant users can access this panel',
                ])
                ->withInput($request->only('email'));
        }

        if (!$user->merchant) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Merchant profile not found',
                ]);
        }

        if ($user->merchant->status !== 'approved') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Merchant account is not approved',
                ]);
        }

        return redirect()->intended(
            route('merchant.dashboard')
        );
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('merchant.login');
    }
}