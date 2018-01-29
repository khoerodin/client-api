<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Auth;

class LogoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
    }
}
