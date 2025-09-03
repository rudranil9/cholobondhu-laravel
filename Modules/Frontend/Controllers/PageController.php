<?php

namespace Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the about page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the terms page
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Display the privacy policy page
     */
    public function privacy()
    {
        return view('privacy');
    }
}
