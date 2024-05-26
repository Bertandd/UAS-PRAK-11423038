<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function chekRole($role)
    {
        if (Auth::user()->role =='admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role =='user') {
            return redirect()->route('user.dashboard');
        } elseif (Auth::user()->role =='operator') {
            return redirect()->route('operator.dashboard');
        } else {
            return redirect()->route('login');
        }
    }
}
