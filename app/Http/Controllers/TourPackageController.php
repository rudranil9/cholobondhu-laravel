<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;

class TourPackageController extends Controller
{
    public function index()
    {
        // Get all active packages from database
        $packages = TourPackage::active()->get();
        $featuredPackages = TourPackage::featured()->active()->get();
        $categories = TourPackage::select('category')->distinct()->get();
        
        // Define Durga Puja Special Packages (complete data from Angular)
        $durgaPujaPackages = [
            [
                'id' => 1,
                'name' => 'Andaman',
                'location' => 'Andaman Islands',
                'duration' => '4 Nights / 5 Days',
                'price' => 35000,
                'original_price' => 45000,
                'description' => 'Experience the pristine beaches and crystal-clear waters of Andaman during Durga Puja.',
                'image' => 'assets/destinations/andaman.jpg',
                'highlights' => ['Port Blair', 'Havelock Island', 'Radhanagar Beach', 'Cellular Jail'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Internal transfers'],
                'package_type' => 'Extended Holiday Package',
                'special_features' => ['Kolkata to Kolkata', 'Beach Festival', 'Water Sports']
            ],
            [
                'id' => 2,
                'name' => 'Bangkok & Pattaya',
                'location' => 'Thailand',
                'duration' => '4 Nights / 5 Days',
                'price' => 40000,
                'original_price' => 55000,
                'description' => 'Celebrate Durga Puja in the vibrant cities of Bangkok and Pattaya.',
                'image' => 'assets/destinations/bangkok-pattaya.jpg',
                'highlights' => ['Grand Palace', 'Floating Market', 'Pattaya Beach', 'Coral Island'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Airport transfers'],
                'package_type' => 'International Package',
                'special_features' => ['2N Bangkok', '2N Pattaya', 'International']
            ],
            [
                'id' => 3,
                'name' => 'Ladakh',
                'location' => 'Jammu & Kashmir',
                'duration' => '8 Nights / 9 Days',
                'price' => 32000,
                'original_price' => 42000,
                'description' => 'Witness Durga Puja celebrations in the high-altitude desert of Ladakh.',
                'image' => 'assets/destinations/ladakh.jpg',
                'highlights' => ['Leh Palace', 'Pangong Lake', 'Nubra Valley', 'Diskit Monastery'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Permits'],
                'package_type' => 'Adventure Package',
                'special_features' => ['Srinagar to Leh', 'Flight excluded', 'High Altitude']
            ],
            [
                'id' => 4,
                'name' => 'Rajasthan',
                'location' => 'Royal Rajasthan',
                'duration' => '8 Nights / 9 Days',
                'price' => 24000,
                'original_price' => 32000,
                'description' => 'Royal Durga Puja celebration in the land of kings and palaces.',
                'image' => 'assets/destinations/rajasthan.jpg',
                'highlights' => ['Amber Fort', 'Lake Palace', 'Thar Desert', 'City Palace'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Cultural programs'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Jaipur to Jaipur', 'Royal Experience', 'Multi-city']
            ],
            [
                'id' => 5,
                'name' => 'Gangtok & North Sikkim',
                'location' => 'Sikkim',
                'duration' => '4 Nights / 5 Days',
                'price' => 11500,
                'original_price' => 15000,
                'description' => 'Celebrate Durga Puja amidst the Himalayan peaks of Sikkim.',
                'image' => 'assets/destinations/sikkim.jpg',
                'highlights' => ['Nathula Pass', 'Changu Lake', 'Yumthang Valley', 'Baba Mandir'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Permits'],
                'package_type' => 'Holiday Package',
                'special_features' => ['NJP to NJP', 'Mountain Views', 'Sacred Lakes']
            ],
            [
                'id' => 6,
                'name' => 'Kerala',
                'location' => 'Gods Own Country',
                'duration' => '7 Nights / 8 Days',
                'price' => 18000,
                'original_price' => 24000,
                'description' => 'Celebrate Durga Puja in the backwaters and spice gardens of Kerala.',
                'image' => 'assets/destinations/kerala.jpg',
                'highlights' => ['Munnar tea gardens', 'Alleppey backwaters', 'Cochin heritage', 'Thekkady spices'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Houseboat stay'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Cochin pickup', 'Trivandrum drop', 'Backwaters']
            ],
            [
                'id' => 7,
                'name' => 'Shimla Manali & Amritsar',
                'location' => 'Himachal & Punjab',
                'duration' => '6 Nights / 7 Days',
                'price' => 16000,
                'original_price' => 21000,
                'description' => 'Mountain beauty and spiritual experience during Durga Puja.',
                'image' => 'assets/destinations/shimla-manali.jpg',
                'highlights' => ['Mall Road Shimla', 'Rohtang Pass', 'Golden Temple', 'Solang Valley'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', 'Mountains + Spirituality', 'Train Travel']
            ],
            [
                'id' => 8,
                'name' => 'Goa',
                'location' => 'Beach Paradise',
                'duration' => '4 Nights / 5 Days',
                'price' => 12000,
                'original_price' => 16000,
                'description' => 'Beach celebration of Durga Puja in the party capital of India.',
                'image' => 'assets/destinations/goa.jpg',
                'highlights' => ['Baga Beach', 'Old Goa churches', 'Dudhsagar Falls', 'Cruise party'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Goa to Goa', 'Beach Festival', 'Water Sports']
            ],
            [
                'id' => 9,
                'name' => 'Darjeeling',
                'location' => 'Queen of Hills',
                'duration' => '3 Nights / 4 Days',
                'price' => 8000,
                'original_price' => 11000,
                'description' => 'Experience Durga Puja celebrations with mountain views and tea gardens.',
                'image' => 'assets/destinations/darjeeling.jpg',
                'highlights' => ['Tiger Hill sunrise', 'Tea gardens', 'Toy train', 'Himalayan views'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing'],
                'package_type' => 'Holiday Package',
                'special_features' => ['NJP to NJP', 'Mountain Festival', 'Tea Culture']
            ],
            [
                'id' => 10,
                'name' => 'Puri',
                'location' => 'Odisha',
                'duration' => '3 Nights / 4 Days',
                'price' => 5000,
                'original_price' => 7000,
                'description' => 'Spiritual Durga Puja experience at the holy city of Puri.',
                'image' => 'assets/destinations/puri.jpg',
                'highlights' => ['Jagannath Temple', 'Puri Beach', 'Konark Sun Temple', 'Sand art'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', 'Spiritual', 'Beach + Temple']
            ],
            [
                'id' => 11,
                'name' => 'Sundarban',
                'location' => 'Mangrove Forest',
                'duration' => '2 Nights / 3 Days',
                'price' => 4500,
                'original_price' => 6000,
                'description' => 'Unique Durga Puja experience in the mangrove forests of Sundarban.',
                'image' => 'assets/destinations/sundarban.jpg',
                'highlights' => ['Tiger safari', 'Mangrove cruise', 'Bird watching', 'Local culture'],
                'inclusions' => ['Fooding', 'Lodging', 'Boat safari', 'Forest permits'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Wildlife', 'Eco-tourism', 'Tiger Territory']
            ],
            [
                'id' => 12,
                'name' => 'Bishnupur',
                'location' => 'West Bengal',
                'duration' => '3 Nights / 4 Days',
                'price' => 5000,
                'original_price' => 7000,
                'description' => 'Explore terracotta temples and traditional Durga Puja in historic Bishnupur.',
                'image' => 'assets/destinations/bishnupur.jpg',
                'highlights' => ['Terracotta temples', 'Bankura horses', 'Mukutmanipur lake', 'Folk music'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Cultural programs'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Heritage', 'Temple Architecture', 'Traditional Crafts']
            ],
            [
                'id' => 13,
                'name' => 'Gangtok & North Sikkim (Extended)',
                'location' => 'Sikkim',
                'duration' => '5 Nights / 6 Days',
                'price' => 12500,
                'original_price' => 16500,
                'description' => 'Extended Sikkim tour with more time to explore the mountains during Durga Puja.',
                'image' => 'assets/destinations/gangtok.jpg',
                'highlights' => ['Gurudongmar Lake', 'Lachung', 'Lachen', 'Gangtok local'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Permits'],
                'package_type' => 'Holiday Package',
                'special_features' => ['NJP to NJP', '4N Gangtok + 1N North Sikkim', 'Zero Point optional']
            ],
            [
                'id' => 14,
                'name' => 'Offbeat North Bengal',
                'location' => 'Dhotrey/Tinchule',
                'duration' => '4 Nights / 5 Days',
                'price' => 10500,
                'original_price' => 14000,
                'description' => 'Discover hidden gems of North Bengal during Durga Puja festival.',
                'image' => 'assets/destinations/north-bengal.jpg',
                'highlights' => ['Dhotrey views', 'Tinchule monastery', 'Darjeeling tea gardens', 'Tiger Hill'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing'],
                'package_type' => 'Holiday Package',
                'special_features' => ['NJP to NJP', '1N Dhotrey + 1N Tinchule + 2N Darjeeling']
            ],
            [
                'id' => 15,
                'name' => 'Ranchi & Netarhat',
                'location' => 'Jharkhand',
                'duration' => '7 Nights / 8 Days',
                'price' => 10000,
                'original_price' => 13500,
                'description' => 'Experience tribal culture and natural beauty during Durga Puja.',
                'image' => 'assets/destinations/ranchi-netarhat.jpg',
                'highlights' => ['Netarhat sunset', 'Betla National Park', 'Tribal villages', 'Waterfalls'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', '2N Ranchi + 2N Netarhat + 1N Betla']
            ],
            [
                'id' => 16,
                'name' => 'Purulia',
                'location' => 'West Bengal',
                'duration' => '2 Nights / 3 Days',
                'price' => 5000,
                'original_price' => 7000,
                'description' => 'Short getaway to experience tribal culture and Durga Puja in Purulia.',
                'image' => 'assets/destinations/purulia.jpg',
                'highlights' => ['Tribal dances', 'Rock formations', 'Handicrafts', 'Local festivals'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', 'Tribal culture', 'Budget friendly']
            ],
            [
                'id' => 17,
                'name' => 'Delhi, Agra & Mathura',
                'location' => 'Northern India',
                'duration' => '6 Nights / 7 Days',
                'price' => 10000,
                'original_price' => 14000,
                'description' => 'Golden Triangle with spiritual Mathura during Durga Puja season.',
                'image' => 'assets/destinations/delhi-agra.jpg',
                'highlights' => ['Taj Mahal', 'Red Fort', 'Krishna Janmabhoomi', 'India Gate'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Train fare'],
                'package_type' => 'Holiday Package',
                'special_features' => ['2N Delhi + 2N Agra + 2N Mathura', 'Heritage + Spirituality']
            ],
            [
                'id' => 18,
                'name' => 'Vaishno Devi & Kashmir',
                'location' => 'Jammu & Kashmir',
                'duration' => '12 Nights / 13 Days',
                'price' => 20000,
                'original_price' => 28000,
                'description' => 'Spiritual journey combined with Kashmir beauty during Durga Puja.',
                'image' => 'assets/destinations/vaishnodevi.jpg',
                'highlights' => ['Vaishno Devi Temple', 'Dal Lake', 'Pahalgam valley', 'Shikara ride'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Kolkata to Kolkata', '2N Katra + 4N Srinagar + 2N Pahalgam']
            ],
            [
                'id' => 19,
                'name' => 'Vizag & Araku',
                'location' => 'Andhra Pradesh',
                'duration' => '4 Nights / 5 Days',
                'price' => 9500,
                'original_price' => 13000,
                'description' => 'Beach city and hill station combo during Durga Puja celebrations.',
                'image' => 'assets/destinations/vizag-araku.jpg',
                'highlights' => ['Araku Valley', 'Borra Caves', 'Beach Road', 'Submarine Museum'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', '3N Vizag + 1N Araku Valley']
            ],
            [
                'id' => 20,
                'name' => 'Dooars',
                'location' => 'West Bengal',
                'duration' => '4 Nights / 5 Days',
                'price' => 9000,
                'original_price' => 12000,
                'description' => 'Wildlife and tea gardens experience during Durga Puja in Dooars.',
                'image' => 'assets/destinations/dooars.jpg',
                'highlights' => ['Elephant safari', 'Tea gardens', 'Lava monastery', 'Rishop views'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing'],
                'package_type' => 'Holiday Package',
                'special_features' => ['NJP to NJP', '2N Dooars + 1N Lava + 1N Rishop']
            ],
            [
                'id' => 21,
                'name' => 'Gopalpur & Daringbari',
                'location' => 'Odisha',
                'duration' => '3 Nights / 4 Days',
                'price' => 8000,
                'original_price' => 11000,
                'description' => 'Beach and hill station combination in Odisha during Durga Puja.',
                'image' => 'assets/destinations/gopalpur.jpg',
                'highlights' => ['Gopalpur beach', 'Daringbari hill station', 'Tribal culture', 'Nature walks'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', 'Beach + Hills combo']
            ],
            [
                'id' => 22,
                'name' => 'Lava & Rishop (Offbeat)',
                'location' => 'West Bengal',
                'duration' => '2 Nights / 3 Days',
                'price' => 8500,
                'original_price' => 11500,
                'description' => 'Offbeat hill destinations in North Bengal for a peaceful Durga Puja.',
                'image' => 'assets/destinations/lava-rishop.jpg',
                'highlights' => ['Lava monastery', 'Rishop views', 'Pine forests', 'Peaceful environment'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing'],
                'package_type' => 'Holiday Package',
                'special_features' => ['NJP to NJP', '1N Lava + 1N Rishop', 'Offbeat destination']
            ],
            [
                'id' => 23,
                'name' => 'Assam & Meghalaya',
                'location' => 'Northeast India',
                'duration' => '6 Nights / 7 Days',
                'price' => 17000,
                'original_price' => 23000,
                'description' => 'Northeast India exploration during Durga Puja with unique cultures.',
                'image' => 'assets/destinations/asaam-meghalaya.jpg',
                'highlights' => ['Cherrapunji', 'Living root bridges', 'Kamakhya Temple', 'Tea gardens'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Sleeper train'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', '2N Meghalaya + 2N Cherrapunji + 2N Guwahati']
            ],
            [
                'id' => 24,
                'name' => 'Haridwar & Mussoorie',
                'location' => 'Uttarakhand',
                'duration' => '5 Nights / 6 Days',
                'price' => 11000,
                'original_price' => 15000,
                'description' => 'Spiritual Haridwar and hill station Mussoorie during Durga Puja.',
                'image' => 'assets/destinations/haridwar-mussoorie.jpg',
                'highlights' => ['Ganga Aarti', 'Har Ki Pauri', 'Mall Road Mussoorie', 'Cable car'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Train fare'],
                'package_type' => 'Holiday Package',
                'special_features' => ['2N Haridwar + 3N Mussoorie', 'Spirituality + Hills']
            ],
            [
                'id' => 25,
                'name' => 'Pelling & Ravangla',
                'location' => 'West Sikkim',
                'duration' => '4 Nights / 5 Days',
                'price' => 10000,
                'original_price' => 13500,
                'description' => 'West Sikkim exploration with monastery visits during Durga Puja.',
                'image' => 'assets/destinations/pelling-ravangla.jpg',
                'highlights' => ['Pelling monastery', 'Ravangla Buddha Park', 'Kanchenjunga views', 'Tea gardens'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing', 'Car'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Howrah to Howrah', 'West Sikkim circuit', 'Mountain views']
            ],
            [
                'id' => 26,
                'name' => 'Ghatsila',
                'location' => 'Jharkhand',
                'duration' => '3 Nights / 4 Days',
                'price' => 5000,
                'original_price' => 7500,
                'description' => 'Peaceful hill station getaway in Jharkhand during Durga Puja.',
                'image' => 'assets/destinations/ghatsila.jpg',
                'highlights' => ['Dharagiri Falls', 'Burudih Lake', 'Hill views', 'Peaceful environment'],
                'inclusions' => ['Fooding', 'Lodging', 'Sightseeing'],
                'package_type' => 'Holiday Package',
                'special_features' => ['Budget friendly', 'Nature retreat', 'Hill station']
            ]
        ];
        
        // Get mood-based destinations
        $moodDestinations = $this->getMoodDestinations();
        
        // Get distance-based destinations
        $distanceDestinations = $this->getDistanceDestinations();
        
        return view('tour-packages', compact('packages', 'featuredPackages', 'categories', 'durgaPujaPackages', 'moodDestinations', 'distanceDestinations'));
    }

    public function byCategory($category)
    {
        $categoryName = str_replace('-', ' ', $category);
        
        // Get packages from database
        $dbPackages = TourPackage::byCategory($categoryName)->active()->get();
        
        // Define category-specific destinations to ensure content is always available
        $categoryDestinations = $this->getCategoryDestinations($category);
        
        // Combine database packages with mock data, prioritizing database content
        $packages = $dbPackages->isNotEmpty() ? $dbPackages : collect($categoryDestinations);
        
        return view('travel-categories', compact('packages', 'categoryName'));
    }
    
    private function getCategoryDestinations($category)
    {
        $destinations = [
            'cultural-tours' => [
                [
                    'id' => 101,
                    'name' => 'Golden Triangle Delhi-Agra-Jaipur',
                    'location' => 'Delhi, Uttar Pradesh, Rajasthan',
                    'description' => 'Explore India\'s rich Mughal and Rajput heritage through iconic monuments, palaces, and cultural experiences.',
                    'image' => 'assets/destinations/delhi-agra.jpg',
                    'price' => 18999,
                    'duration' => 6,
                    'highlights' => ['Taj Mahal', 'Red Fort', 'Amber Palace', 'City Palace'],
                    'category' => 'Cultural Tours',
                    'is_featured' => true
                ],
                [
                    'id' => 102, 
                    'name' => 'Rajasthan Heritage Circuit',
                    'location' => 'Rajasthan',
                    'description' => 'Royal palaces, desert forts, and vibrant culture in the land of maharajas.',
                    'image' => 'assets/destinations/rajasthan.jpg',
                    'price' => 24999,
                    'duration' => 8,
                    'highlights' => ['Mehrangarh Fort', 'Lake Palace', 'Hawa Mahal', 'Desert Safari'],
                    'category' => 'Cultural Tours',
                    'is_featured' => false
                ],
                [
                    'id' => 103,
                    'name' => 'Hampi & Badami Heritage',
                    'location' => 'Karnataka',
                    'description' => 'Ancient Vijayanagara empire ruins and cave temples showcasing South Indian architecture.',
                    'image' => 'assets/destinations/kerala.jpg',
                    'price' => 14999,
                    'duration' => 5,
                    'highlights' => ['Virupaksha Temple', 'Stone Chariot', 'Cave Temples', 'Royal Enclosure'],
                    'category' => 'Cultural Tours',
                    'is_featured' => false
                ]
            ],
            'adventure' => [
                [
                    'id' => 201,
                    'name' => 'Ladakh Bike Expedition',
                    'location' => 'Jammu & Kashmir',
                    'description' => 'Ultimate high-altitude adventure through mountain passes, pristine lakes, and Buddhist monasteries.',
                    'image' => 'assets/destinations/ladakh.jpg',
                    'price' => 35999,
                    'duration' => 10,
                    'highlights' => ['Khardung La Pass', 'Pangong Lake', 'Nubra Valley', 'Leh Palace'],
                    'category' => 'Adventure',
                    'is_featured' => true
                ],
                [
                    'id' => 202,
                    'name' => 'Rishikesh Adventure Sports',
                    'location' => 'Uttarakhand', 
                    'description' => 'River rafting, bungee jumping, and trekking in the adventure capital of India.',
                    'image' => 'assets/destinations/haridwar-mussoorie.jpg',
                    'price' => 12999,
                    'duration' => 4,
                    'highlights' => ['White Water Rafting', 'Bungee Jumping', 'Rock Climbing', 'Yoga Sessions'],
                    'category' => 'Adventure',
                    'is_featured' => false
                ],
                [
                    'id' => 203,
                    'name' => 'Spiti Valley Trek',
                    'location' => 'Himachal Pradesh',
                    'description' => 'Remote Himalayan valley with challenging treks, ancient monasteries, and stark landscapes.',
                    'image' => 'assets/destinations/shimla-manali.jpg',
                    'price' => 28999,
                    'duration' => 8,
                    'highlights' => ['Key Monastery', 'Chandratal Lake', 'Pin Valley', 'Fossil Village'],
                    'category' => 'Adventure',
                    'is_featured' => false
                ]
            ],
            'beach-islands' => [
                [
                    'id' => 301,
                    'name' => 'Andaman Island Paradise',
                    'location' => 'Andaman & Nicobar Islands',
                    'description' => 'Pristine coral reefs, crystal clear waters, and world-class diving in tropical paradise.',
                    'image' => 'assets/destinations/andaman.jpg',
                    'price' => 28999,
                    'duration' => 6,
                    'highlights' => ['Scuba Diving', 'Radhanagar Beach', 'Cellular Jail', 'Island Hopping'],
                    'category' => 'Beach & Islands',
                    'is_featured' => true
                ],
                [
                    'id' => 302,
                    'name' => 'Goa Beach Experience',
                    'location' => 'Goa',
                    'description' => 'Golden beaches, Portuguese heritage, vibrant nightlife, and water sports.',
                    'image' => 'assets/destinations/goa.jpg',
                    'price' => 15999,
                    'duration' => 5,
                    'highlights' => ['Beach Parties', 'Water Sports', 'Old Goa Churches', 'Spice Plantation'],
                    'category' => 'Beach & Islands',
                    'is_featured' => true
                ],
                [
                    'id' => 303,
                    'name' => 'Lakshadweep Coral Islands',
                    'location' => 'Lakshadweep',
                    'description' => 'Untouched coral atolls with lagoons, marine life, and pristine beaches.',
                    'image' => 'assets/destinations/andaman.jpg',
                    'price' => 45999,
                    'duration' => 7,
                    'highlights' => ['Coral Reefs', 'Lagoon Swimming', 'Snorkeling', 'Traditional Villages'],
                    'category' => 'Beach & Islands',
                    'is_featured' => false
                ]
            ],
            'spiritual' => [
                [
                    'id' => 401,
                    'name' => 'Char Dham Yatra',
                    'location' => 'Uttarakhand',
                    'description' => 'Sacred pilgrimage to four holy shrines in the Himalayas - Kedarnath, Badrinath, Gangotri, Yamunotri.',
                    'image' => 'assets/destinations/vaishnodevi.jpg',
                    'price' => 22999,
                    'duration' => 8,
                    'highlights' => ['Kedarnath Temple', 'Badrinath Shrine', 'Gangotri Glacier', 'Yamunotri Hot Springs'],
                    'category' => 'Spiritual',
                    'is_featured' => true
                ],
                [
                    'id' => 402,
                    'name' => 'Vaishno Devi Pilgrimage',
                    'location' => 'Jammu & Kashmir',
                    'description' => 'Sacred journey to Mata Vaishno Devi shrine in the Trikuta Mountains.',
                    'image' => 'assets/destinations/vaishnodevi.jpg',
                    'price' => 16999,
                    'duration' => 4,
                    'highlights' => ['Vaishno Devi Temple', 'Bhawan', 'Ardhkuwari Cave', 'Helicopter Service'],
                    'category' => 'Spiritual',
                    'is_featured' => false
                ],
                [
                    'id' => 403,
                    'name' => 'Kashi Vishwanath & Ganga Aarti',
                    'location' => 'Uttar Pradesh',
                    'description' => 'Spiritual experience in the holy city of Varanasi with Ganga aarti and temple visits.',
                    'image' => 'assets/destinations/haridwar-mussoorie.jpg',
                    'price' => 11999,
                    'duration' => 3,
                    'highlights' => ['Kashi Vishwanath', 'Ganga Aarti', 'Boat Ride', 'Sarnath'],
                    'category' => 'Spiritual',
                    'is_featured' => false
                ]
            ],
            'wildlife' => [
                [
                    'id' => 501,
                    'name' => 'Sundarbans Tiger Safari',
                    'location' => 'West Bengal',
                    'description' => 'World\'s largest mangrove forest and home to the Royal Bengal Tiger.',
                    'image' => 'assets/destinations/sundarban.jpg',
                    'price' => 18999,
                    'duration' => 4,
                    'highlights' => ['Tiger Safari', 'Mangrove Forest', 'Boat Rides', 'Bird Watching'],
                    'category' => 'Wildlife',
                    'is_featured' => true
                ],
                [
                    'id' => 502,
                    'name' => 'Jim Corbett National Park',
                    'location' => 'Uttarakhand',
                    'description' => 'India\'s oldest national park famous for Bengal tigers and diverse wildlife.',
                    'image' => 'assets/destinations/dooars.jpg',
                    'price' => 16999,
                    'duration' => 3,
                    'highlights' => ['Tiger Safari', 'Elephant Safari', 'Bird Watching', 'Nature Walks'],
                    'category' => 'Wildlife',
                    'is_featured' => false
                ],
                [
                    'id' => 503,
                    'name' => 'Kaziranga Rhino Safari',
                    'location' => 'Assam',
                    'description' => 'Home to the Great Indian One-horned Rhinoceros and diverse Assamese wildlife.',
                    'image' => 'assets/destinations/dooars.jpg',
                    'price' => 21999,
                    'duration' => 5,
                    'highlights' => ['Rhino Safari', 'Elephant Ride', 'Bird Photography', 'Tea Gardens'],
                    'category' => 'Wildlife',
                    'is_featured' => false
                ]
            ],
            'hill-stations' => [
                [
                    'id' => 601,
                    'name' => 'Shimla & Manali Hill Retreat',
                    'location' => 'Himachal Pradesh',
                    'description' => 'Colonial charm of Shimla combined with adventure activities in Manali.',
                    'image' => 'assets/destinations/shimla-manali.jpg',
                    'price' => 16999,
                    'duration' => 6,
                    'highlights' => ['Mall Road', 'Solang Valley', 'Rohtang Pass', 'Apple Orchards'],
                    'category' => 'Hill Stations',
                    'is_featured' => true
                ],
                [
                    'id' => 602,
                    'name' => 'Darjeeling Tea Gardens',
                    'location' => 'West Bengal',
                    'description' => 'Famous tea gardens, toy train rides, and stunning views of Kanchenjunga.',
                    'image' => 'assets/destinations/darjeeling.jpg',
                    'price' => 13999,
                    'duration' => 4,
                    'highlights' => ['Tiger Hill Sunrise', 'Tea Garden Tours', 'Toy Train', 'Himalayan Views'],
                    'category' => 'Hill Stations',
                    'is_featured' => true
                ],
                [
                    'id' => 603,
                    'name' => 'Ooty Queen of Hills',
                    'location' => 'Tamil Nadu',
                    'description' => 'Pleasant weather, botanical gardens, and scenic train rides in the Nilgiris.',
                    'image' => 'assets/destinations/ooty.jpg',
                    'price' => 12999,
                    'duration' => 4,
                    'highlights' => ['Toy Train Ride', 'Botanical Gardens', 'Doddabetta Peak', 'Tea Estates'],
                    'category' => 'Hill Stations',
                    'is_featured' => false
                ]
            ],
            'luxury-travel' => [
                [
                    'id' => 701,
                    'name' => 'Udaipur Palace Experience',
                    'location' => 'Rajasthan',
                    'description' => 'Stay in heritage palaces, enjoy royal treatments, and experience maharaja lifestyle.',
                    'image' => 'assets/destinations/udaipur-rajasthan.jpg',
                    'price' => 45999,
                    'duration' => 5,
                    'highlights' => ['Palace Hotels', 'Private Tours', 'Royal Dining', 'Lake Cruises'],
                    'category' => 'Luxury Travel',
                    'is_featured' => true
                ],
                [
                    'id' => 702,
                    'name' => 'Kerala Luxury Houseboat',
                    'location' => 'Kerala',
                    'description' => 'Premium houseboat experience in backwaters with personal chef and butler service.',
                    'image' => 'assets/destinations/kerala.jpg',
                    'price' => 38999,
                    'duration' => 6,
                    'highlights' => ['Luxury Houseboat', 'Private Chef', 'Spa Treatments', 'Backwater Cruise'],
                    'category' => 'Luxury Travel',
                    'is_featured' => false
                ],
                [
                    'id' => 703,
                    'name' => 'Goa Luxury Beach Resort',
                    'location' => 'Goa',
                    'description' => 'Five-star beach resorts with private beaches, water sports, and fine dining.',
                    'image' => 'assets/destinations/goa.jpg',
                    'price' => 42999,
                    'duration' => 5,
                    'highlights' => ['5-Star Resort', 'Private Beach', 'Water Sports', 'Fine Dining'],
                    'category' => 'Luxury Travel',
                    'is_featured' => false
                ]
            ],
            'family-tours' => [
                [
                    'id' => 801,
                    'name' => 'Disney-Style Family Fun in Goa',
                    'location' => 'Goa',
                    'description' => 'Family-friendly beaches, water parks, and activities suitable for all ages.',
                    'image' => 'assets/destinations/goa.jpg',
                    'price' => 19999,
                    'duration' => 5,
                    'highlights' => ['Family Beaches', 'Water Parks', 'Dolphin Spotting', 'Kid-friendly Activities'],
                    'category' => 'Family Tours',
                    'is_featured' => true
                ],
                [
                    'id' => 802,
                    'name' => 'Kerala Family Backwaters',
                    'location' => 'Kerala',
                    'description' => 'Safe and comfortable family houseboat experience with cultural shows.',
                    'image' => 'assets/destinations/kerala.jpg',
                    'price' => 22999,
                    'duration' => 6,
                    'highlights' => ['Family Houseboat', 'Cultural Shows', 'Spice Gardens', 'Elephant Camp'],
                    'category' => 'Family Tours',
                    'is_featured' => false
                ],
                [
                    'id' => 803,
                    'name' => 'Rajasthan Family Heritage',
                    'location' => 'Rajasthan',
                    'description' => 'Child-friendly palaces, camel rides, and cultural performances for the whole family.',
                    'image' => 'assets/destinations/rajasthan.jpg',
                    'price' => 25999,
                    'duration' => 7,
                    'highlights' => ['Palace Tours', 'Camel Safari', 'Cultural Shows', 'Craft Workshops'],
                    'category' => 'Family Tours',
                    'is_featured' => false
                ]
            ]
        ];
        
        return $destinations[$category] ?? [];
    }

    public function exploreByRegion()
    {
        // Get all active packages and group them by region
        $allPackages = TourPackage::active()->orderBy('location')->get();
        
        // Define regional destinations based on Angular implementation
        $regionalDestinations = [
            // North India
            [
                'id' => 1,
                'name' => 'Shimla & Manali',
                'location' => 'Himachal Pradesh',
                'region' => 'North',
                'description' => 'Experience the Queen of Hills with colonial charm, snow-capped peaks, and adventure activities in the heart of Himalayas.',
                'image' => 'assets/destinations/shimla-manali.jpg',
                'price' => 15999,
                'duration' => '6D/5N',
                'highlights' => ['Mall Road Shopping', 'Solang Valley Adventure', 'Snow Activities', 'Apple Orchards'],
                'is_popular' => true,
                'difficulty' => 'Easy',
                'best_time' => 'March to June, December to February'
            ],
            [
                'id' => 2,
                'name' => 'Ladakh',
                'location' => 'Jammu & Kashmir',
                'region' => 'North',
                'description' => 'High-altitude desert adventure with pristine lakes, ancient monasteries, and breathtaking mountain landscapes.',
                'image' => 'assets/destinations/ladakh.jpg',
                'price' => 22999,
                'duration' => '7D/6N',
                'highlights' => ['Pangong Lake', 'Nubra Valley', 'Leh Palace', 'Magnetic Hill'],
                'is_popular' => false,
                'difficulty' => 'Challenging',
                'best_time' => 'May to September'
            ],
            [
                'id' => 3,
                'name' => 'Delhi & Agra',
                'location' => 'Uttar Pradesh',
                'region' => 'North',
                'description' => 'Explore India\'s capital and the city of Taj Mahal, experiencing rich Mughal heritage and modern metropolitan culture.',
                'image' => 'assets/destinations/delhi-agra.jpg',
                'price' => 11999,
                'duration' => '4D/3N',
                'highlights' => ['Taj Mahal', 'Red Fort', 'India Gate', 'Agra Fort'],
                'is_popular' => true,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            [
                'id' => 4,
                'name' => 'Rajasthan',
                'location' => 'Rajasthan',
                'region' => 'North',
                'description' => 'Royal palaces, golden deserts, and vibrant culture in the land of kings and maharajas.',
                'image' => 'assets/destinations/rajasthan.jpg',
                'price' => 18999,
                'duration' => '8D/7N',
                'highlights' => ['Jaipur City Palace', 'Udaipur Lakes', 'Jodhpur Fort', 'Desert Safari'],
                'is_popular' => true,
                'difficulty' => 'Moderate',
                'best_time' => 'October to March'
            ],
            [
                'id' => 5,
                'name' => 'Haridwar & Mussoorie',
                'location' => 'Uttarakhand',
                'region' => 'North',
                'description' => 'Spiritual journey to the holy Ganges combined with Queen of Hills\' colonial charm and scenic beauty.',
                'image' => 'assets/destinations/haridwar-mussoorie.jpg',
                'price' => 13999,
                'duration' => '5D/4N',
                'highlights' => ['Ganga Aarti', 'Kempty Falls', 'Gun Hill', 'Temple Visits'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'March to June, September to November'
            ],
            [
                'id' => 6,
                'name' => 'Vaishno Devi',
                'location' => 'Jammu & Kashmir',
                'region' => 'North',
                'description' => 'Sacred pilgrimage to the holy shrine of Mata Vaishno Devi in the Trikuta Mountains.',
                'image' => 'assets/destinations/vaishnodevi.jpg',
                'price' => 16999,
                'duration' => '4D/3N',
                'highlights' => ['Mata Vaishno Devi Temple', 'Helicopter Service', 'Bhawan', 'Ardhkuwari'],
                'is_popular' => false,
                'difficulty' => 'Moderate',
                'best_time' => 'March to October'
            ],
            
            // South India
            [
                'id' => 7,
                'name' => 'Kerala Backwaters',
                'location' => 'Kerala',
                'region' => 'South',
                'description' => 'Serene backwater cruises, lush green landscapes, and traditional houseboat experiences in God\'s Own Country.',
                'image' => 'assets/destinations/kerala.jpg',
                'price' => 16999,
                'duration' => '6D/5N',
                'highlights' => ['Houseboat Stay', 'Alleppey Backwaters', 'Spice Plantations', 'Ayurvedic Treatments'],
                'is_popular' => true,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            [
                'id' => 8,
                'name' => 'Goa Beaches',
                'location' => 'Goa',
                'region' => 'West',
                'description' => 'Golden beaches, Portuguese heritage, vibrant nightlife, and water sports in India\'s beach paradise.',
                'image' => 'assets/destinations/goa.jpg',
                'price' => 14999,
                'duration' => '5D/4N',
                'highlights' => ['Beach Parties', 'Water Sports', 'Old Goa Churches', 'Spice Plantation'],
                'is_popular' => true,
                'difficulty' => 'Easy',
                'best_time' => 'November to March'
            ],
            [
                'id' => 9,
                'name' => 'Ooty',
                'location' => 'Tamil Nadu',
                'region' => 'South',
                'description' => 'Queen of Hill Stations with tea gardens, toy train rides, and pleasant weather perfect for mountain lovers.',
                'image' => 'assets/destinations/ooty.jpg',
                'price' => 12999,
                'duration' => '4D/3N',
                'highlights' => ['Toy Train Ride', 'Tea Gardens', 'Botanical Gardens', 'Doddabetta Peak'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'April to June, September to November'
            ],
            [
                'id' => 20,
                'name' => 'Andaman Islands',
                'location' => 'Andaman & Nicobar',
                'region' => 'South',
                'description' => 'Pristine tropical islands with crystal clear waters, coral reefs, and world-class diving experiences.',
                'image' => 'assets/destinations/andaman.jpg',
                'price' => 25999,
                'duration' => '6D/5N',
                'highlights' => ['Scuba Diving', 'Radhanagar Beach', 'Cellular Jail', 'Island Hopping'],
                'is_popular' => true,
                'difficulty' => 'Moderate',
                'best_time' => 'November to April'
            ],
            
            // East India
            [
                'id' => 10,
                'name' => 'Darjeeling',
                'location' => 'West Bengal',
                'region' => 'East',
                'description' => 'Famous tea gardens, heritage toy train, and stunning Himalayan views with Kanchenjunga peak.',
                'image' => 'assets/destinations/darjeeling.jpg',
                'price' => 12999,
                'duration' => '4D/3N',
                'highlights' => ['Tiger Hill Sunrise', 'Tea Garden Tours', 'Toy Train Ride', 'Himalayan Views'],
                'is_popular' => true,
                'difficulty' => 'Moderate',
                'best_time' => 'March to May, September to November'
            ],
            [
                'id' => 11,
                'name' => 'Gangtok',
                'location' => 'Sikkim',
                'region' => 'East',
                'description' => 'Capital of Sikkim with Buddhist monasteries, cable car rides, and breathtaking mountain vistas.',
                'image' => 'assets/destinations/gangtok.jpg',
                'price' => 13999,
                'duration' => '4D/3N',
                'highlights' => ['Monastery Visits', 'Cable Car Ride', 'Tsomgo Lake', 'MG Marg'],
                'is_popular' => true,
                'difficulty' => 'Moderate',
                'best_time' => 'March to May, September to November'
            ],
            [
                'id' => 12,
                'name' => 'Puri',
                'location' => 'Odisha',
                'region' => 'East',
                'description' => 'Sacred coastal city famous for Jagannath Temple and golden beaches perfect for spiritual and beach lovers.',
                'image' => 'assets/destinations/puri.jpg',
                'price' => 9999,
                'duration' => '3D/2N',
                'highlights' => ['Jagannath Temple', 'Golden Beach', 'Sand Art', 'Konark Sun Temple'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            [
                'id' => 13,
                'name' => 'Sundarbans',
                'location' => 'West Bengal',
                'region' => 'East',
                'description' => 'World\'s largest mangrove forest and home to the Royal Bengal Tiger with unique ecosystem.',
                'image' => 'assets/destinations/sundarban.jpg',
                'price' => 16999,
                'duration' => '4D/3N',
                'highlights' => ['Tiger Safari', 'Mangrove Forest', 'Boat Rides', 'Bird Watching'],
                'is_popular' => false,
                'difficulty' => 'Moderate',
                'best_time' => 'November to March'
            ],
            [
                'id' => 14,
                'name' => 'Dooars',
                'location' => 'West Bengal',
                'region' => 'East',
                'description' => 'Gateway to Bhutan with lush tea gardens, wildlife sanctuaries, and elephant corridors.',
                'image' => 'assets/destinations/dooars.jpg',
                'price' => 11999,
                'duration' => '3D/2N',
                'highlights' => ['Elephant Safari', 'Tea Gardens', 'Wildlife Sanctuaries', 'River Crossing'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            [
                'id' => 15,
                'name' => 'Digha',
                'location' => 'West Bengal',
                'region' => 'East',
                'description' => 'Popular beach destination with golden sands and gentle waves, perfect for weekend getaways.',
                'image' => 'assets/destinations/digha.jpg',
                'price' => 6999,
                'duration' => '2D/1N',
                'highlights' => ['Beach Activities', 'Sea Bathing', 'Local Seafood', 'Marine Drive'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            [
                'id' => 16,
                'name' => 'Bishnupur',
                'location' => 'West Bengal',
                'region' => 'East',
                'description' => 'Historic town famous for terracotta temples, Baluchari sarees, and classical music traditions.',
                'image' => 'assets/destinations/bishnupur.jpg',
                'price' => 8999,
                'duration' => '2D/1N',
                'highlights' => ['Terracotta Temples', 'Handicrafts', 'Cultural Heritage', 'Rasmancha'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            
            // West India
            [
                'id' => 17,
                'name' => 'Mumbai',
                'location' => 'Maharashtra',
                'region' => 'West',
                'description' => 'City of dreams with Bollywood glamour, colonial architecture, and vibrant street food culture.',
                'image' => 'assets/destinations/mumbai.jpg',
                'price' => 12999,
                'duration' => '4D/3N',
                'highlights' => ['Gateway of India', 'Marine Drive', 'Bollywood Studios', 'Street Food'],
                'is_popular' => true,
                'difficulty' => 'Easy',
                'best_time' => 'November to February'
            ],
            [
                'id' => 18,
                'name' => 'Udaipur',
                'location' => 'Rajasthan',
                'region' => 'West',
                'description' => 'City of Lakes with magnificent palaces, romantic boat rides, and royal Rajasthani culture.',
                'image' => 'assets/destinations/udaipur-rajasthan.jpg',
                'price' => 15999,
                'duration' => '4D/3N',
                'highlights' => ['City Palace', 'Lake Pichola', 'Jag Mandir', 'Sunset Boat Ride'],
                'is_popular' => true,
                'difficulty' => 'Easy',
                'best_time' => 'October to March'
            ],
            [
                'id' => 19,
                'name' => 'Gujarat Heritage',
                'location' => 'Gujarat',
                'region' => 'West',
                'description' => 'Rich cultural heritage with ancient temples, stepwells, and the birthplace of Mahatma Gandhi.',
                'image' => 'assets/destinations/gujarat.jpg',
                'price' => 13999,
                'duration' => '5D/4N',
                'highlights' => ['Somnath Temple', 'Rann of Kutch', 'Sabarmati Ashram', 'Stepwells'],
                'is_popular' => false,
                'difficulty' => 'Easy',
                'best_time' => 'November to February'
            ]
        ];
        
        // Group destinations by region
        $destinationsByRegion = collect($regionalDestinations)->groupBy('region');
        
        $northIndia = $destinationsByRegion->get('North', collect());
        $southIndia = $destinationsByRegion->get('South', collect());
        $eastIndia = $destinationsByRegion->get('East', collect());
        $westIndia = $destinationsByRegion->get('West', collect());
        
        return view('explore-by-region', compact('northIndia', 'southIndia', 'eastIndia', 'westIndia'));
    }

    public function show(TourPackage $package)
    {
        return view('tour-packages.show', compact('package'));
    }
    
    private function getMoodDestinations()
    {
        return [
            // Hill Stations
            [
                'id' => 1,
                'mood' => 'hills',
                'name' => 'Darjeeling',
                'location' => 'West Bengal',
                'description' => 'Famous for its tea gardens, toy train, and stunning views of Mount Kanchenjunga. Experience colonial charm and mountain serenity.',
                'image' => 'assets/destinations/darjeeling.jpg',
                'price' => 12999,
                'duration' => '4D/3N',
                'best_time' => 'March to May, September to November',
                'activities' => ['Tea Garden Tours', 'Toy Train Ride', 'Tiger Hill Sunrise', 'Monastery Visits', 'Cable Car Ride'],
                'mood_description' => 'Perfect for peaceful mountain retreat',
                'features' => ['Mountain Views', 'Tea Culture', 'Colonial Heritage']
            ],
            [
                'id' => 2,
                'mood' => 'hills',
                'name' => 'Ooty',
                'location' => 'Tamil Nadu',
                'description' => 'Queen of Hill Stations with beautiful botanical gardens, toy train, and pleasant weather perfect for a relaxing mountain getaway.',
                'image' => 'assets/destinations/ooty.jpg',
                'price' => 14999,
                'duration' => '4D/3N',
                'best_time' => 'April to June, September to November',
                'activities' => ['Botanical Gardens', 'Toy Train Ride', 'Boating', 'Tea Factory Visits', 'Horse Riding'],
                'mood_description' => 'Classic hill station experience',
                'features' => ['Cool Climate', 'Gardens', 'Colonial Heritage']
            ],
            [
                'id' => 11,
                'mood' => 'hills',
                'name' => 'Shimla',
                'location' => 'Himachal Pradesh',
                'description' => 'The Queen of Hills offers pleasant weather, colonial architecture, and scenic beauty perfect for a refreshing hill station experience.',
                'image' => 'assets/destinations/shimla-manali.jpg',
                'price' => 15999,
                'duration' => '5D/4N',
                'best_time' => 'March to June, September to November',
                'activities' => ['Mall Road Shopping', 'Ridge Walk', 'Kufri Skiing', 'Jakhu Temple', 'Heritage Train'],
                'mood_description' => 'Colonial hill station charm',
                'features' => ['Cool Climate', 'Shopping', 'Adventure Sports']
            ],
            [
                'id' => 12,
                'mood' => 'hills',
                'name' => 'Gangtok',
                'location' => 'Sikkim',
                'description' => 'Capital of Sikkim with breathtaking mountain views, Buddhist monasteries, and peaceful atmosphere in the Eastern Himalayas.',
                'image' => 'assets/destinations/sikkim.jpg',
                'price' => 13999,
                'duration' => '4D/3N',
                'best_time' => 'March to May, September to November',
                'activities' => ['Monastery Visits', 'Cable Car Ride', 'Mountain Views', 'Local Markets', 'Cultural Tours'],
                'mood_description' => 'Himalayan mountain retreat',
                'features' => ['Buddhist Culture', 'Mountain Views', 'Clean Environment']
            ],
            [
                'id' => 13,
                'mood' => 'hills',
                'name' => 'Gulmarg',
                'location' => 'Jammu & Kashmir',
                'description' => 'Meadow of Flowers with world-class skiing, gondola rides, and stunning alpine scenery in the Kashmir valley.',
                'image' => 'assets/destinations/gulmarg.jpg',
                'price' => 18999,
                'duration' => '5D/4N',
                'best_time' => 'December to March (Snow), April to October (Flowers)',
                'activities' => ['Skiing', 'Gondola Ride', 'Golf', 'Trekking', 'Photography'],
                'mood_description' => 'Alpine adventure paradise',
                'features' => ['Snow Sports', 'Alpine Meadows', 'Adventure Activities']
            ],
            [
                'id' => 14,
                'mood' => 'hills',
                'name' => 'Mussoorie',
                'location' => 'Uttarakhand',
                'description' => 'Queen of the Hills with pleasant weather, colonial charm, and beautiful valley views perfect for a peaceful mountain getaway.',
                'image' => 'assets/destinations/mussoorie.jpg',
                'price' => 12999,
                'duration' => '4D/3N',
                'best_time' => 'March to June, September to November',
                'activities' => ['Mall Road Walk', 'Cable Car Ride', 'Kempty Falls', 'Gun Hill', 'Nature Walks'],
                'mood_description' => 'Classic Himalayan hill station',
                'features' => ['Valley Views', 'Colonial Heritage', 'Pleasant Weather']
            ],
            
            // Sea & Beaches
            [
                'id' => 4,
                'mood' => 'sea',
                'name' => 'Goa Beaches',
                'location' => 'Goa',
                'description' => 'Sun, sand, and sea with vibrant nightlife, Portuguese heritage, and some of India\'s most beautiful beaches.',
                'image' => 'assets/destinations/goa.jpg',
                'price' => 14999,
                'duration' => '5D/4N',
                'best_time' => 'November to March',
                'activities' => ['Beach Lounging', 'Water Sports', 'Nightlife', 'Heritage Tours', 'Spice Plantation'],
                'mood_description' => 'Tropical beach paradise',
                'features' => ['Golden Beaches', 'Nightlife', 'Portuguese Culture']
            ],
            [
                'id' => 5,
                'mood' => 'sea',
                'name' => 'Andaman Islands',
                'location' => 'Andaman & Nicobar',
                'description' => 'Crystal clear waters, pristine beaches, and rich marine life. Perfect for those seeking untouched natural beauty.',
                'image' => 'assets/destinations/andaman.jpg',
                'price' => 25999,
                'duration' => '6D/5N',
                'best_time' => 'November to April',
                'activities' => ['Scuba Diving', 'Snorkeling', 'Island Hopping', 'Beach Activities', 'Coral Viewing'],
                'mood_description' => 'Pristine island paradise',
                'features' => ['Crystal Waters', 'Marine Life', 'Untouched Nature']
            ],
            [
                'id' => 6,
                'mood' => 'sea',
                'name' => 'Puri',
                'location' => 'Odisha',
                'description' => 'Sacred coastal city famous for Jagannath Temple and golden beaches. Perfect blend of spirituality and seaside relaxation.',
                'image' => 'assets/destinations/puri.jpg',
                'price' => 9999,
                'duration' => '3D/2N',
                'best_time' => 'October to March',
                'activities' => ['Temple Visits', 'Beach Activities', 'Sand Art', 'Local Cuisine', 'Cultural Shows'],
                'mood_description' => 'Spiritual beach destination',
                'features' => ['Sacred Sites', 'Cultural Heritage', 'Golden Beaches']
            ],
            [
                'id' => 10,
                'mood' => 'sea',
                'name' => 'Digha',
                'location' => 'West Bengal',
                'description' => 'Popular beach destination with golden sands, gentle waves, and a perfect weekend getaway for families and couples.',
                'image' => 'assets/destinations/digha.jpg',
                'price' => 6999,
                'duration' => '2D/1N',
                'best_time' => 'October to March',
                'activities' => ['Beach Walks', 'Sea Bathing', 'Local Seafood', 'Shopping', 'Photography'],
                'mood_description' => 'Accessible coastal retreat',
                'features' => ['Family Friendly', 'Budget Travel', 'Local Culture']
            ],
            
            // Forests & Wildlife
            [
                'id' => 7,
                'mood' => 'forest',
                'name' => 'Sundarbans',
                'location' => 'West Bengal',
                'description' => 'World\'s largest mangrove forest, home to the Royal Bengal Tiger. Experience unique ecosystem and wildlife.',
                'image' => 'assets/destinations/sundarban.jpg',
                'price' => 16999,
                'duration' => '4D/3N',
                'best_time' => 'November to March',
                'activities' => ['Tiger Safari', 'Boat Rides', 'Bird Watching', 'Village Tours', 'Photography'],
                'mood_description' => 'Mangrove wilderness adventure',
                'features' => ['Royal Bengal Tiger', 'Mangrove Forest', 'Unique Ecosystem']
            ],
            [
                'id' => 8,
                'mood' => 'forest',
                'name' => 'Jim Corbett',
                'location' => 'Uttarakhand',
                'description' => 'India\'s oldest national park, perfect for wildlife enthusiasts seeking tigers, elephants, and diverse flora.',
                'image' => 'assets/destinations/jim-corbett.jpg',
                'price' => 19999,
                'duration' => '5D/4N',
                'best_time' => 'November to March',
                'activities' => ['Jungle Safari', 'Wildlife Photography', 'Nature Walks', 'River Rafting', 'Bird Watching'],
                'mood_description' => 'Classic wildlife experience',
                'features' => ['Tiger Reserve', 'Diverse Wildlife', 'Adventure Activities']
            ],
            [
                'id' => 9,
                'mood' => 'forest',
                'name' => 'Dooars',
                'location' => 'West Bengal',
                'description' => 'Gateway to Bhutan with lush tea gardens, elephant corridors, and diverse wildlife in the foothills of the Himalayas.',
                'image' => 'assets/destinations/dooars.jpg',
                'price' => 11999,
                'duration' => '3D/2N',
                'best_time' => 'October to March',
                'activities' => ['Elephant Safari', 'Tea Garden Tours', 'Bird Watching', 'Village Visits', 'Nature Photography'],
                'mood_description' => 'Himalayan foothills wilderness',
                'features' => ['Elephant Corridors', 'Tea Gardens', 'Himalayan Views']
            ]
        ];
    }
    
    private function getDistanceDestinations()
    {
        return [
            // Weekend Getaways (0-100km from Kolkata)
            [
                'id' => 2,
                'name' => 'Bakkali',
                'location' => 'West Bengal',
                'distance' => 85,
                'category' => 'weekend',
                'travel_time' => '2 hours',
                'description' => 'Peaceful riverside destination perfect for a refreshing weekend getaway with natural beauty.',
                'image' => 'assets/destinations/bakkhali.jpg',
                'price' => 2499,
                'duration' => '2D/1N',
                'transport_mode' => ['Car', 'Bus'],
                'highlights' => ['Riverside Views', 'Natural Beauty', 'Peaceful Environment', 'Local Culture'],
                'best_for' => ['Nature Lovers', 'Peace Seekers', 'Weekend Escape']
            ],
            [
                'id' => 21,
                'name' => 'Mayapur Iskcon',
                'location' => 'West Bengal',
                'distance' => 130,
                'category' => 'weekend',
                'travel_time' => '2.5 hours',
                'description' => 'Spiritual destination and headquarters of ISKCON with beautiful temples and peaceful atmosphere.',
                'image' => 'assets/destinations/mayapur.jpg',
                'price' => 3499,
                'duration' => '2D/1N',
                'transport_mode' => ['Car', 'Bus', 'Train'],
                'highlights' => ['ISKCON Temple', 'Spiritual Atmosphere', 'Cultural Programs', 'Vegetarian Cuisine'],
                'best_for' => ['Spiritual Seekers', 'Culture Enthusiasts', 'Peace Lovers']
            ],
            [
                'id' => 22,
                'name' => 'Taki',
                'location' => 'West Bengal',
                'distance' => 70,
                'category' => 'weekend',
                'travel_time' => '1.5 hours',
                'description' => 'Charming border town on the banks of Ichhamati River, perfect for a quick weekend retreat.',
                'image' => 'assets/destinations/taki.jpg',
                'price' => 2199,
                'duration' => '2D/1N',
                'transport_mode' => ['Car', 'Bus', 'Train'],
                'highlights' => ['Ichhamati River', 'Border Town Culture', 'River Views', 'Local Markets'],
                'best_for' => ['River Lovers', 'Cultural Experience', 'Budget Travel']
            ],
            
            // Short Trips (100-300km)
            [
                'id' => 1,
                'name' => 'Shantiniketan',
                'location' => 'West Bengal',
                'distance' => 165,
                'category' => 'short',
                'travel_time' => '3-4 hours',
                'description' => 'Peaceful university town founded by Rabindranath Tagore, known for its cultural heritage and artistic atmosphere.',
                'image' => 'assets/destinations/shantiniketan.jpg',
                'price' => 4999,
                'duration' => '2D/1N',
                'transport_mode' => ['Car', 'Train', 'Bus'],
                'highlights' => ['Visva Bharati University', 'Tagore Museum', 'Local Handicrafts', 'Cultural Programs'],
                'best_for' => ['Culture Lovers', 'Art Enthusiasts', 'Peaceful Retreat']
            ],
            [
                'id' => 3,
                'name' => 'Bishnupur',
                'location' => 'West Bengal',
                'distance' => 152,
                'category' => 'short',
                'travel_time' => '3 hours',
                'description' => 'Historic town famous for terracotta temples, traditional music, and cultural heritage.',
                'image' => 'assets/destinations/bishnupur.jpg',
                'price' => 5999,
                'duration' => '2D/1N',
                'transport_mode' => ['Car', 'Train'],
                'highlights' => ['Terracotta Temples', 'Handicrafts', 'Cultural Heritage', 'Local Cuisine'],
                'best_for' => ['History Buffs', 'Culture Enthusiasts', 'Architecture Lovers']
            ],
            [
                'id' => 7,
                'name' => 'Digha',
                'location' => 'West Bengal',
                'distance' => 187,
                'category' => 'short',
                'travel_time' => '3-4 hours',
                'description' => 'Popular beach destination perfect for a relaxing coastal weekend getaway.',
                'image' => 'assets/destinations/digha.jpg',
                'price' => 3999,
                'duration' => '2D/1N',
                'transport_mode' => ['Car', 'Train', 'Bus'],
                'highlights' => ['Sandy Beaches', 'Sea Bathing', 'Beach Activities', 'Seafood'],
                'best_for' => ['Beach Lovers', 'Family Trip', 'Relaxation']
            ],
            
            // Long Distance (300km+)
            [
                'id' => 4,
                'name' => 'Darjeeling',
                'location' => 'West Bengal',
                'distance' => 650,
                'category' => 'long',
                'travel_time' => '10-12 hours',
                'description' => 'Queen of Hills with tea gardens, toy train, and magnificent mountain views.',
                'image' => 'assets/destinations/darjeeling.jpg',
                'price' => 12999,
                'duration' => '4D/3N',
                'transport_mode' => ['Car', 'Train', 'Flight to Bagdogra'],
                'highlights' => ['Tea Gardens', 'Toy Train', 'Tiger Hill', 'Himalayan Views'],
                'best_for' => ['Mountain Lovers', 'Tea Enthusiasts', 'Adventure Seekers']
            ],
            [
                'id' => 5,
                'name' => 'Puri',
                'location' => 'Odisha',
                'distance' => 502,
                'category' => 'long',
                'travel_time' => '8-10 hours',
                'description' => 'Sacred coastal city with beautiful beaches and the famous Jagannath Temple.',
                'image' => 'assets/destinations/puri.jpg',
                'price' => 9999,
                'duration' => '3D/2N',
                'transport_mode' => ['Car', 'Train', 'Flight to Bhubaneswar'],
                'highlights' => ['Jagannath Temple', 'Golden Beach', 'Sand Art', 'Local Cuisine'],
                'best_for' => ['Spiritual Travelers', 'Beach Lovers', 'Cultural Experience']
            ],
            [
                'id' => 6,
                'name' => 'Kalimpong',
                'location' => 'West Bengal',
                'distance' => 680,
                'category' => 'long',
                'travel_time' => '11-13 hours',
                'description' => 'Peaceful hill station with panoramic mountain views and rich cultural diversity.',
                'image' => 'assets/destinations/lava-rishop.jpg',
                'price' => 11999,
                'duration' => '4D/3N',
                'transport_mode' => ['Car', 'Flight to Bagdogra + Car'],
                'highlights' => ['Mountain Views', 'Flower Nurseries', 'Monasteries', 'Adventure Sports'],
                'best_for' => ['Peace Seekers', 'Adventure Lovers', 'Mountain Views']
            ]
        ];
    }
}
