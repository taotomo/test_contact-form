<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function registerView()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        return view('auth.login');
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        return view('admin');
    }
}
