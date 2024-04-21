<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function forgot_password()
    {
        return view('auth/forgot-password');
    }

    public function register()
    {
        return view('auth.register');
    }
}
