<?php

namespace App\Http\Controllers\User\V1;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
