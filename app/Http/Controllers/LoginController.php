<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            return redirect()->route('layouts/main');
        } else {
            return redirect()->route('login')->with('failed', 'Incorrect Email or Password');
        }
    }

    // public function forgot_password()
    // {
    //     return view('auth/forgot-password');
    // }
    
    public function register()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('layouts/main');
        } else {
            return redirect()->route('login')->with('failed', 'Incorrect Email or Password');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You Already Logout');
    }
}
