<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;

class AdminController extends Controller {
    public function index()
    {
        return view('admin.index');
    }
}
