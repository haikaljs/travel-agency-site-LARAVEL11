<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(){
        return view('user.dashboard');
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Logout is successful!');    }
}
