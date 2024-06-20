<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            switch (Auth::user()->role) {
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                case 'Supervisor':
                    return redirect()->route('supervisor.dashboard');
                case 'Gerente':
                    return redirect()->route('gerente.dashboard');
                case 'Trade':
                    return redirect()->route('trade.dashboard');
                default:
                    return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }   
}