<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('owner.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->role === 'owner') {
            return redirect()->route('owner.dashboard');
        }

        return back()->withErrors(['email' => '認証に失敗しました']);
    }
}

