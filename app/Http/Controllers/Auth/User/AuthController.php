<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function RegisterView()
    {
        return view('auth.user.register');
    }

     public function LoginView()
    {
        return view('auth.user.login');
    }
}
