<?php

namespace App\Http\Controllers\User\V1;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
}
