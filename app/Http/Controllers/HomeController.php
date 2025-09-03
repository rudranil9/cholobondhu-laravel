<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPackages = TourPackage::featured()->active()->take(6)->get();
        
        return view('home', compact('featuredPackages'));
    }

    public function about()
    {
        return view('about');
    }
}
