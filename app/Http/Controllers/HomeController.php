<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        return view('index', compact('slides'));
    }
}
