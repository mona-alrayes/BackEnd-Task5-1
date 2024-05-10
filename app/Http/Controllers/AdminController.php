<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function Dashboard()
    {
        return view('admin.Dashboard');
    }

    public function logout(request $request)
    {
        Auth::logout();
        return view('welcome');
    }
}
