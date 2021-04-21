<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getAdmin()
    {
        return view('backend.index');
    }
    public function getLogin()
    {
        return view('auth.login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
