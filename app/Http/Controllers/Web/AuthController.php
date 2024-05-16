<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function signin(LoginRequest $request)
    {
        if ($request->validated() && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        }

        return back()->withErrors(['store_failed' => 'Error to save'])->withInput();
    }

    public function store(RegisterRequest $request)
    {
        if ($request->validated()) {
            $user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password
                ]
            );

            Auth::login($user);

            return redirect()->route('home');
        }

        return back()->withErrors(['store_failed' => 'Error to save'])->withInput();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
