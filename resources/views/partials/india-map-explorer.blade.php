<section id="india-map" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Explore India by Region
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Discover the diverse beauty of India from the snow-capped Himalayas to the sun-kissed beaches of the south
            </p>
        </div>

        <!-- Interactive Region Explorer -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" x-data="regionExplorer()">
            <!-- Interactive Region Selector -->
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-8 shadow-xl">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                        Popular Destinations by Region
                    </h3>
                    
                    <!-- Region Cards -->
                    <div class="space-y-4">
                        @php
                        $regions = [
                            [
                                'name' => 'North India', 
                                'icon' => '🏔️', 
                                'anchor' => 'north-india',
                                'description' => 'Majestic mountains, historical monuments, and rich culture',
                                'destinations' => ['Delhi & Agra', 'Rajasthan', 'Shimla & Manali', 'Haridwar & Mussoorie', 'Ladakh', 'Vaishno Devi'],
                                'startingPrice' => 11999,
                                'fullDescription' => 'North India offers an incredible blend of history, culture, and natural beauty. From the snow-capped peaks of the Himalayas to the golden deserts of Rajasthan.',
                                'highlights' => ['Visit the iconic Taj Mahal in Agra', 'Explore the royal palaces of Rajasthan', 'Experience the spiritual capital of Varanasi', 'Adventure activities in Himachal Pradesh']
                            ],
                            [
                                'name' => 'South India', 
                                'icon' => '🌴', 
                                'anchor' => 'south-india',
                                'description' => 'Tropical beauty, ancient temples, and backwaters',
                                'destinations' => ['Kerala', 'Ooty', 'Andaman Islands'],
                                'startingPrice' => 11999,
                                'fullDescription' => 'South India is a land of diverse landscapes, from the serene backwaters of Kerala to the ancient temples of Tamil Nadu.',
                                'highlights' => ['Cruise through Kerala\'s backwaters', 'Explore ancient temples in Tamil Nadu', 'Coffee plantations in Karnataka', 'Tropical island paradise experiences']
                            ],
                            [
                                'name' => 'East India', 
                                'icon' => '🏛️', 
                                'anchor' => 'east-india',
                                'description' => 'Cultural heritage, hill stations, and tribal culture',
                                'destinations' => ['Darjeeling', 'Gangtok', 'Puri', 'Sundarbans', 'Dooars', 'Digha', 'Bishnupur'],
                                'startingPrice' => 6999,
                                'fullDescription' => 'East India is known for its rich cultural heritage, intellectual traditions, and stunning natural beauty.',
                                'highlights' => ['Cultural immersion in Kolkata', 'Tea garden tours in Darjeeling', 'Spiritual journey to Puri', 'Tribal culture in Odisha']
                            ],
                            [
                                'name' => 'West India', 
                                'icon' => '🏖️', 
                                'anchor' => 'west-india',
                                'description' => 'Beaches, business hubs, and diverse landscapes',
                                'destinations' => ['Mumbai', 'Goa Beaches', 'Udaipur', 'Gujarat Heritage'],
                                'startingPrice' => 12999,
                                'fullDescription' => 'West India combines modern urban experiences with natural beauty and historical significance.',
                                'highlights' => ['Bollywood and beaches in Mumbai', 'Golden beaches and nightlife in Goa', 'Wildlife safaris in Gujarat', 'Historic caves and forts in Maharashtra']
                            ]
                        ];
                        @endphp
                        
                        @foreach($regions as $index => $region)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer border-l-4 group"
                             :class="{
                                'border-blue-500': selectedRegion !== {{ $index }},
                                'border-green-500 bg-green-50 dark:bg-green-900/20': selectedRegion === {{ $index }}
                             }"
                             @click="selectRegion({{ $index }})"
                             x-data="{ regionData: @js($region) }">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xl transition-all duration-300"
                                     :class="{
                                        'from-green-500 to-green-600': selectedRegion === {{ $index }}
                                     }">
                                    {{ $region['icon'] }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 dark:text-white transition-colors duration-300"
                                        :class="{
                                            'text-green-700 dark:text-green-300': selectedRegion === {{ $index }}
                                        }">
                                        {{ $region['name'] }}
                                        <span x-show="selectedRegion === {{ $index }}" class="text-green-600 ml-2">✓</span>
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $region['description'] }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium transition-colors duration-300"
                                         :class="{
                                            'text-blue-600 dark:text-blue-400': selectedRegion !== {{ $index }},
                                            'text-green-600 dark:text-green-400': selectedRegion === {{ $index }}
                                         }">
                                        {{ count($region['destinations']) }} destinations
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        from ₹{{ number_format($region['startingPrice']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Selected Region Details -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl">
                    <h3 class="text-2xl font-bold mb-4" x-text="getSelectedRegion().name"></h3>
                    <p class="text-blue-100 mb-6 leading-relaxed" x-text="getSelectedRegion().fullDescription"></p>
                    
                    <!-- Highlights -->
                    <div class="mb-6">
                        <h4 class="font-bold mb-3">Highlights:</h4>
                        <div class="grid grid-cols-1 gap-2">
                            <template x-for="highlight in getSelectedRegion().highlights">
                                <div class="flex items-center space-x-2">
                                    <span class="text-yellow-300">✨</span>
                                    <span class="text-blue-100" x-text="highlight"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Popular Destinations -->
                    <div class="mb-6">
                        <h4 class="font-bold mb-3">Popular Destinations:</h4>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="destination in getSelectedRegion().destinations">
                                <span class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 text-sm" x-text="destination"></span>
                            </template>
                        </div>
                    </div>

                    <!-- Explore Button -->
                    <div class="text-center">
                        <button 
                            @click="exploreSelectedRegion()"
                            class="px-8 py-4 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg w-full text-lg"
                            :class="getRegionButtonClass()"
                            x-html="getSelectedRegion().icon + ' Explore ' + getSelectedRegion().name + ' Tours'">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function regionExplorer() {
    const regions = [
        {
            name: "North India",
            icon: "🏔️",
            anchor: "north-india",
            description: "Majestic mountains, historical monuments, and rich culture",
            startingPrice: 11999,
            fullDescription: "North India offers an incredible blend of history, culture, and natural beauty. From the snow-capped peaks of the Himalayas to the golden deserts of Rajasthan.",
            highlights: [
                "Visit the iconic Taj Mahal in Agra",
                "Explore the royal palaces of Rajasthan",
                "Experience the spiritual capital of Varanasi",
                "Adventure activities in Himachal Pradesh"
            ],
            destinations: ["Delhi & Agra", "Rajasthan", "Shimla & Manali", "Haridwar & Mussoorie", "Ladakh", "Vaishno Devi"]
        },
        {
            name: "South India",
            icon: "🌴",
            anchor: "south-india",
            description: "Tropical beauty, ancient temples, and backwaters",
            startingPrice: 11999,
            fullDescription: "South India is a land of diverse landscapes, from the serene backwaters of Kerala to the ancient temples of Tamil Nadu.",
            highlights: [
                "Cruise through Kerala's backwaters",
                "Explore ancient temples in Tamil Nadu",
                "Coffee plantations in Karnataka",
                "Tropical island paradise experiences"
            ],
            destinations: ["Kerala", "Ooty", "Andaman Islands"]
        },
        {
            name: "East India",
            icon: "🏛️",
            anchor: "east-india",
            description: "Cultural heritage, hill stations, and tribal culture",
            startingPrice: 6999,
            fullDescription: "East India is known for its rich cultural heritage, intellectual traditions, and stunning natural beauty.",
            highlights: [
                "Cultural immersion in Kolkata",
                "Tea garden tours in Darjeeling",
                "Spiritual journey to Puri",
                "Tribal culture in Odisha"
            ],
            destinations: ["Darjeeling", "Gangtok", "Puri", "Sundarbans", "Dooars", "Digha", "Bishnupur"]
        },
        {
            name: "West India",
            icon: "🏖️",
            anchor: "west-india",
            description: "Beaches, business hubs, and diverse landscapes",
            startingPrice: 12999,
            fullDescription: "West India combines modern urban experiences with natural beauty and historical significance.",
            highlights: [
                "Bollywood and beaches in Mumbai",
                "Golden beaches and nightlife in Goa",
                "Wildlife safaris in Gujarat",
                "Historic caves and forts in Maharashtra"
            ],
            destinations: ["Mumbai", "Goa Beaches", "Udaipur", "Gujarat Heritage"]
        }
    ];
    
    return {
        selectedRegion: 0, // Default to North India
        regions: regions,
        
        selectRegion(index) {
            this.selectedRegion = index;
        },
        
        getSelectedRegion() {
            return this.regions[this.selectedRegion];
        },
        
        exploreSelectedRegion() {
            const region = this.getSelectedRegion();
            window.location.href = '/explore-by-region#' + region.anchor;
        },
        
        getRegionButtonClass() {
            const regionName = this.getSelectedRegion().name;
            switch (regionName) {
                case 'North India':
                    return 'bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white';
                case 'South India':
                    return 'bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white';
                case 'East India':
                    return 'bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white';
                case 'West India':
                    return 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white';
                default:
                    return 'bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white';
            }
        }
    }
}
</script>
@endpush
