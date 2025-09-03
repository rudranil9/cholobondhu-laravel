<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourPackage;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Darjeeling Tea Garden Tour',
                'description' => 'Experience the mesmerizing beauty of Darjeeling with its world-famous tea gardens, toy train ride, and stunning Himalayan views.',
                'location' => 'Darjeeling, West Bengal',
                'image_url' => 'assets/destinations/darjeeling.jpg',
                'price' => 12999.00,
                'duration' => '4 Days / 3 Nights',
                'category' => 'Hill Stations',
                'features' => ['Tea Garden Visit', 'Toy Train Ride', 'Tiger Hill Sunrise', 'Local Cuisine'],
                'highlights' => ['Kanchenjunga Views', 'Buddhist Monasteries', 'Colonial Architecture'],
                'difficulty_level' => 'Easy',
                'max_travelers' => 15,
                'is_active' => true,
                'is_featured' => true,
                'mood_category' => 'Relaxing',
                'distance_from_city' => 550,
                'best_season' => 'October to March'
            ],
            [
                'name' => 'Sikkim Adventure Package',
                'description' => 'Explore the enchanting kingdom of Sikkim with its pristine lakes, snow-capped peaks, and vibrant Buddhist culture.',
                'location' => 'Gangtok, Sikkim',
                'image_url' => 'assets/destinations/gangtok.jpg',
                'price' => 18999.00,
                'duration' => '6 Days / 5 Nights',
                'category' => 'Adventure',
                'features' => ['Tsomgo Lake', 'Nathula Pass', 'Monastery Visits', 'Cable Car Ride'],
                'highlights' => ['Himalayan Views', 'Alpine Flora', 'Buddhist Culture'],
                'difficulty_level' => 'Moderate',
                'max_travelers' => 12,
                'is_active' => true,
                'is_featured' => true,
                'mood_category' => 'Adventurous',
                'distance_from_city' => 650,
                'best_season' => 'March to June, September to December'
            ],
            [
                'name' => 'Goa Beach Paradise',
                'description' => 'Relax on pristine beaches, enjoy water sports, explore Portuguese heritage, and experience the vibrant nightlife of Goa.',
                'location' => 'North & South Goa',
                'image_url' => 'assets/destinations/goa.jpg',
                'price' => 15999.00,
                'duration' => '5 Days / 4 Nights',
                'category' => 'Beach & Islands',
                'features' => ['Beach Activities', 'Water Sports', 'Heritage Tours', 'Local Cuisine'],
                'highlights' => ['Baga Beach', 'Basilica of Bom Jesus', 'Spice Plantations'],
                'difficulty_level' => 'Easy',
                'max_travelers' => 20,
                'is_active' => true,
                'is_featured' => true,
                'mood_category' => 'Relaxing',
                'distance_from_city' => 1450,
                'best_season' => 'November to February'
            ],
            [
                'name' => 'Kerala Backwaters Experience',
                'description' => 'Navigate through serene backwaters, stay in traditional houseboats, and explore the lush green landscapes of Gods Own Country.',
                'location' => 'Alleppey, Kerala',
                'image_url' => 'assets/destinations/kerala.jpg',
                'price' => 22999.00,
                'duration' => '7 Days / 6 Nights',
                'category' => 'Cultural Tours',
                'features' => ['Houseboat Stay', 'Backwater Cruise', 'Ayurvedic Spa', 'Spice Garden'],
                'highlights' => ['Alleppey Backwaters', 'Munnar Tea Gardens', 'Kochi Heritage'],
                'difficulty_level' => 'Easy',
                'max_travelers' => 16,
                'is_active' => true,
                'is_featured' => true,
                'mood_category' => 'Relaxing',
                'distance_from_city' => 1650,
                'best_season' => 'September to March'
            ],
            [
                'name' => 'Sundarbans Wildlife Safari',
                'description' => 'Embark on an exciting wildlife adventure in the worlds largest mangrove forest, home to the Royal Bengal Tiger.',
                'location' => 'Sundarbans, West Bengal',
                'image_url' => 'assets/destinations/sundarban.jpg',
                'price' => 8999.00,
                'duration' => '3 Days / 2 Nights',
                'category' => 'Wildlife',
                'features' => ['Tiger Safari', 'Boat Cruise', 'Bird Watching', 'Village Visit'],
                'highlights' => ['Royal Bengal Tiger', 'Crocodile Spotting', 'Mangrove Ecosystem'],
                'difficulty_level' => 'Moderate',
                'max_travelers' => 10,
                'is_active' => true,
                'is_featured' => false,
                'mood_category' => 'Adventurous',
                'distance_from_city' => 110,
                'best_season' => 'November to March'
            ]
        ];

        foreach ($packages as $package) {
            TourPackage::create($package);
        }
    }
}
