<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function terms()
    {
        return view('front.terms');
    }
}
