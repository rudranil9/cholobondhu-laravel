<?php

namespace Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Sample data for Durga Puja packages (this could come from database)
        $durgaPujaPackages = [
            [
                'name' => 'Kolkata Durga Puja Pandal Hopping',
                'location' => 'Kolkata',
                'price' => 15000,
                'original_price' => 20000,
                'duration' => '4 Days 3 Nights',
                'package_type' => 'Durga Puja Special',
                'image' => 'assets/destinations/kolkata-puja.jpg',
                'description' => 'Experience the grandeur of Kolkata\'s famous Durga Puja celebrations with guided pandal hopping tours.',
                'highlights' => ['Famous Pandal Tours', 'Cultural Programs', 'Traditional Bengali Cuisine', 'Professional Guide'],
                'inclusions' => ['Accommodation', 'All Meals', 'Transportation', 'Guide'],
                'special_features' => ['Night Photography', 'Cultural Experience', 'Local Cuisine']
            ],
            [
                'name' => 'Kumortuli Artisan Experience',
                'location' => 'Kumortuli, Kolkata',
                'price' => 8000,
                'original_price' => 12000,
                'duration' => '2 Days 1 Night',
                'package_type' => 'Cultural Experience',
                'image' => 'assets/destinations/kumortuli.jpg',
                'description' => 'Witness the making of beautiful Durga idols by skilled artisans in the famous Kumortuli area.',
                'highlights' => ['Artisan Workshop Visit', 'Idol Making Process', 'Cultural Heritage', 'Photography Session'],
                'inclusions' => ['Accommodation', 'Breakfast', 'Guide', 'Workshop Entry'],
                'special_features' => ['Artisan Interaction', 'Photography', 'Cultural Learning']
            ]
        ];

        return view('welcome', compact('durgaPujaPackages'));
    }
}
