@extends('layouts.app')

@section('title', ucfirst($categoryName) . ' Tours - Cholo Bondhu')
@section('description', 'Discover amazing ' . $categoryName . ' tour packages and experiences with Cholo Bondhu. Expert-crafted itineraries for unforgettable journeys.')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Professional Hero Section -->
        <section class="pt-32 pb-20 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 relative overflow-hidden">
            <!-- Subtle Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: linear-gradient(30deg, #3b82f6 12%, transparent 12.5%, transparent 87%, #3b82f6 87.5%, #3b82f6), linear-gradient(150deg, #3b82f6 12%, transparent 12.5%, transparent 87%, #3b82f6 87.5%, #3b82f6), linear-gradient(30deg, #3b82f6 12%, transparent 12.5%, transparent 87%, #3b82f6 87.5%, #3b82f6), linear-gradient(150deg, #3b82f6 12%, transparent 12.5%, transparent 87%, #3b82f6 87.5%, #3b82f6); background-size: 80px 80px; background-position: 0 0, 0 0, 40px 40px, 40px 40px;"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center">
                    <!-- Professional Logo Presentation -->
                    <div class="mb-12">
                        <div class="inline-block relative">
                            <div class="w-28 h-28 mx-auto bg-white rounded-full shadow-2xl overflow-hidden border-4 border-white relative">
                                <img 
                                    src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                                    alt="Cholo Bondhu Logo" 
                                    class="w-full h-full object-contain"
                                />
                                <!-- Professional Glow Effect -->
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 to-purple-500/20 opacity-0 hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Typography -->
                    <div class="mb-8">
                        <h1 class="text-5xl md:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            {{ ucfirst($categoryName) }} 
                            <span class="relative inline-block">
                                <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent">
                                    Tours
                                </span>
                                <div class="absolute -bottom-3 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full transform scale-x-0 animate-scale-x"></div>
                            </span>
                        </h1>
                        
                        <!-- Professional Subtitle -->
                        <div class="max-w-4xl mx-auto">
                            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 leading-relaxed font-light mb-8">
                                Explore our carefully curated {{ $categoryName }} experiences designed to create unforgettable memories 
                                and authentic connections with incredible destinations.
                            </p>
                            
                            <!-- Professional Call-to-Action -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-medium">{{ count($packages) }}+ {{ $categoryName }} packages</span>
                                </div>
                                <div class="hidden sm:block w-px h-6 bg-gray-300 dark:bg-gray-600"></div>
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm font-medium">Expert-crafted itineraries</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Packages Section -->
        <section class="py-16" id="packages">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($packages->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($packages as $package)
                            @php
                                // Handle both Eloquent models and array data
                                $isModel = is_object($package);
                                $packageData = $isModel ? $package : (object) $package;
                                $highlights = $isModel ? 
                                    (json_decode($package->highlights, true) ?? []) : 
                                    ($package['highlights'] ?? []);
                            @endphp
                            <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-3">
                                <!-- Popular Badge -->
                                @if(($isModel && $package->is_featured) || (!$isModel && ($package['is_featured'] ?? false)))
                                    <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                        ⭐ FEATURED
                                    </div>
                                @endif
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                                    {{ $isModel ? $package->category : $package['category'] }}
                                </div>

                                <!-- Image -->
                                <div class="relative h-64 overflow-hidden">
                                    <img 
                                        src="{{ $isModel ? ($package->image ? asset('storage/' . $package->image) : asset('assets/destinations/default-destination.jpg')) : asset($package['image']) }}" 
                                        alt="{{ $packageData->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    >
                                    <!-- Enhanced Overlay for Better Text Visibility -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-4">
                                        <h3 class="text-xl font-bold mb-1">{{ $packageData->name }}</h3>
                                        <p class="text-orange-300 text-sm flex items-center">
                                            <span class="mr-1">📍</span>{{ $packageData->location }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                        {{ $packageData->description }}
                                    </p>

                                    <!-- Highlights -->
                                    @if(!empty($highlights))
                                        <div class="mb-4">
                                            <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Key Highlights:</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach(array_slice($highlights, 0, 3) as $highlight)
                                                    <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full">
                                                        {{ $highlight }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Duration and Category Info -->
                                    <div class="mb-4 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-lg">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-blue-800 dark:text-blue-200 font-medium">
                                                <span class="mr-1">⏱️</span>{{ $packageData->duration }} {{ $isModel ? 'days' : 'days' }}
                                            </span>
                                            <span class="text-indigo-800 dark:text-indigo-200 font-medium">
                                                <span class="mr-1">🎯</span>{{ $isModel ? $package->category : $package['category'] }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Enhanced Price and Duration with Better Visibility -->
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/30 dark:to-blue-900/30 px-4 py-2 rounded-lg">
                                            <span class="text-2xl font-bold text-gray-900 dark:text-white drop-shadow-sm">₹{{ number_format($packageData->price) }}</span>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $packageData->duration }} days</div>
                                        </div>
                                        <button 
                                            onclick="getQuote('{{ $packageData->name }}', '{{ $packageData->location }}', '{{ $isModel ? $package->category : $package['category'] }}', {{ $packageData->price }}, '{{ $packageData->duration }}')"
                                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 font-medium transform hover:scale-105 shadow-lg hover:shadow-xl"
                                        >
                                            📞 Book Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No Packages Available -->
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                            <span class="text-4xl">🔍</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No {{ ucfirst($categoryName) }} Tours Available</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-8 max-w-lg mx-auto">
                            We're currently updating our {{ $categoryName }} tour packages. Please check back soon or contact us for custom packages.
                        </p>
                        <div class="space-x-4">
                            <button 
                                onclick="window.location.href='/'"
                                class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 font-medium transform hover:scale-105 shadow-lg"
                            >
                                Back to Home
                            </button>
                            <button 
                                onclick="contactForCustomPackage('{{ $categoryName }}')"
                                class="px-8 py-3 border-2 border-blue-500 text-blue-500 dark:text-blue-400 rounded-full hover:bg-blue-500 hover:text-white transition-all duration-300 font-medium transform hover:scale-105"
                            >
                                Request Custom Package
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Related Categories Section -->
        <section class="py-16 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Explore Other Categories</h3>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Discover more amazing travel experiences
                    </p>
                </div>

                @php
                $allCategories = [
                    [
                        'name' => "Cultural Tours",
                        'description' => "Rich heritage, ancient monuments, and local traditions",
                        'icon' => "🏛️",
                        'slug' => 'cultural-tours'
                    ],
                    [
                        'name' => "Adventure",
                        'description' => "Mountain treks, water sports and thrilling experiences",
                        'icon' => "🏔️",
                        'slug' => 'adventure'
                    ],
                    [
                        'name' => "Beach & Islands",
                        'description' => "Pristine beaches and tropical island getaways",
                        'icon' => "🏖️",
                        'slug' => 'beach-islands'
                    ],
                    [
                        'name' => "Spiritual",
                        'description' => "Sacred journeys to temples and spiritual destinations",
                        'icon' => "🕉️",
                        'slug' => 'spiritual'
                    ],
                    [
                        'name' => "Wildlife",
                        'description' => "Safari adventures and wildlife photography tours",
                        'icon' => "🦁",
                        'slug' => 'wildlife'
                    ],
                    [
                        'name' => "Hill Stations",
                        'description' => "Cool mountain retreats and scenic valleys",
                        'icon' => "⛰️",
                        'slug' => 'hill-stations'
                    ],
                    [
                        'name' => "Luxury Travel",
                        'description' => "Premium experiences with luxury accommodations",
                        'icon' => "💎",
                        'slug' => 'luxury-travel'
                    ],
                    [
                        'name' => "Family Tours",
                        'description' => "Family-friendly destinations for all age groups",
                        'icon' => "👨‍👩‍👧‍👦",
                        'slug' => 'family-tours'
                    ]
                ];
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                    @foreach($allCategories as $cat)
                        @if(strtolower($cat['name']) !== strtolower($categoryName))
                            <div class="text-center group cursor-pointer" 
                                 onclick="window.location.href='{{ route('travel-categories', $cat['slug']) }}'">
                                <div class="w-16 h-16 mx-auto bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center mb-3 group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110">
                                    <span class="text-2xl">{{ $cat['icon'] }}</span>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ $cat['name'] }}</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 leading-tight">{{ $cat['description'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <!-- Company Logo -->
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 bg-white rounded-full shadow-2xl flex items-center justify-center">
                        <img 
                            src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                            alt="Cholo Bondhu Logo" 
                            class="w-16 h-16 object-contain rounded-full"
                        />
                    </div>
                </div>
                
                <h3 class="text-4xl font-bold text-white mb-6">
                    Ready for Your {{ ucfirst($categoryName) }} Adventure?
                </h3>
                <p class="text-indigo-100 mb-10 text-lg leading-relaxed">
                    Let our travel experts create a personalized {{ $categoryName }} package just for you. 
                    We'll craft the perfect {{ $categoryName }} experience tailored to your preferences.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-10">
                    <div class="flex items-center space-x-3 text-lg text-white">
                        <span class="text-2xl">📱</span>
                        <span class="font-semibold">WhatsApp: +91 8100282665</span>
                    </div>
                    <div class="flex items-center space-x-3 text-lg text-white">
                        <span class="text-2xl">🌐</span>
                        <span class="font-semibold">www.cholobondhu.com</span>
                    </div>
                </div>
                <div class="space-x-4">
                    <button 
                        onclick="contactForCustomPackage('{{ $categoryName }}')"
                        class="px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl text-lg"
                    >
                        📞 Plan My {{ ucfirst($categoryName) }} Journey
                    </button>
                    <button 
                        onclick="window.location.href='/tour-packages'"
                        class="px-8 py-4 border-2 border-white text-white rounded-xl font-bold hover:bg-white hover:text-indigo-600 transition-all duration-300 transform hover:scale-105 text-lg"
                    >
                        🗺️ View All Tours
                    </button>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
// Handle anchor navigation when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a hash in the URL
    if (window.location.hash) {
        setTimeout(() => {
            scrollToSection(window.location.hash.substring(1));
        }, 100);
    }
});

// Handle anchor navigation during browsing
window.addEventListener('hashchange', function() {
    if (window.location.hash) {
        scrollToSection(window.location.hash.substring(1));
    }
});

function scrollToSection(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        // Scroll with offset to account for fixed header
        const yOffset = -80;
        const yPosition = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        
        window.scrollTo({
            top: yPosition,
            behavior: 'smooth'
        });
        
        // Add highlight effect to the section
        element.classList.add('highlight-section');
        setTimeout(() => {
            element.classList.remove('highlight-section');
        }, 2000);
    }
}

function getQuote(name, location, category, price, duration) {
    // Check if user is authenticated
    @auth
        // Navigate to booking page with package information
        const params = new URLSearchParams({
            package_name: name,
            destination: location,
            price: price,
            duration: duration + ' days',
            package_type: category
        });
        window.location.href = '{{ route("booking.index") }}?' + params.toString();
    @else
        // Store package preference and redirect to login
        sessionStorage.setItem('intended_booking', JSON.stringify({
            name: name,
            location: location,
            category: category,
            price: price,
            duration: duration + ' days',
            package_type: category
        }));
        window.location.href = '{{ route("login") }}';
    @endauth
}

function contactForCustomPackage(category) {
    // Navigate to contact form with custom package request
    const params = new URLSearchParams({
        category: category,
        request: 'custom-category-package'
    });
    
    window.location.href = '/#contact?' + params.toString();
}
</script>
@endpush

<style>
    .bg-clip-text {
        -webkit-background-clip: text;
        background-clip: text;
    }

    @keyframes scale-x {
        from {
            transform: scaleX(0);
        }
        to {
            transform: scaleX(1);
        }
    }

    .animate-scale-x {
        animation: scale-x 2s ease-out forwards;
    }
    
    /* Highlight effect for sections when navigated via anchor */
    .highlight-section {
        animation: highlightSection 2s ease-in-out;
    }
    
    @keyframes highlightSection {
        0% {
            background-color: rgba(59, 130, 246, 0.1);
            transform: scale(1.01);
        }
        50% {
            background-color: rgba(59, 130, 246, 0.05);
        }
        100% {
            background-color: transparent;
            transform: scale(1);
        }
    }
    
    /* Smooth scrolling for the entire page */
    html {
        scroll-behavior: smooth;
    }

    /* Enhanced text shadows for better visibility */
    .drop-shadow-lg {
        filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.8)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.6));
    }
    
    .drop-shadow-md {
        filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.6)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.4));
    }
</style>
