@extends('layouts.app')

@section('title', 'Explore India by Region - Cholo Bondhu')
@section('description', 'Discover the incredible diversity of India through our carefully curated regional experiences. From the majestic Himalayas to serene backwaters.')

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
                            Explore India by 
                            <span class="relative inline-block">
                                <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent">
                                    Region
                                </span>
                                <div class="absolute -bottom-3 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full transform scale-x-0 animate-scale-x"></div>
                            </span>
                        </h1>
                        
                        <!-- Professional Subtitle -->
                        <div class="max-w-4xl mx-auto">
                            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 leading-relaxed font-light mb-8">
                                Discover the incredible diversity of India through our carefully curated regional experiences. 
                                From the majestic Himalayas in the North to the serene backwaters of the South, 
                                embark on a journey that captures the essence of each unique region.
                            </p>
                            
                            <!-- Professional Call-to-Action -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-medium">21+ unique destinations</span>
                                </div>
                                <div class="hidden sm:block w-px h-6 bg-gray-300 dark:bg-gray-600"></div>
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm font-medium">4 distinct regions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- North India Section -->
        <section class="py-16" id="north-india">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-full text-white text-2xl mb-4">
                        🏔️
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">North India</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Majestic mountains, historical monuments, and rich cultural heritage await you in North India
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($northIndia as $destination)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-3">
                            <!-- Popular Badge -->
                            @if($destination['is_popular'])
                                <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    ⭐ POPULAR
                                </div>
                            @endif
                            
                            <!-- Difficulty Badge -->
                            @if(isset($destination['difficulty']))
                                <div class="absolute top-4 right-4 z-10 bg-black/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $destination['difficulty'] }}
                                </div>
                            @endif

                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img 
                                    src="{{ asset($destination['image']) }}" 
                                    alt="{{ $destination['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-4">
                                    <h3 class="text-xl font-bold mb-1">{{ $destination['name'] }}</h3>
                                    <p class="text-orange-300 text-sm flex items-center">
                                        <span class="mr-1">📍</span>{{ $destination['location'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                    {{ $destination['description'] }}
                                </p>

                                <!-- Highlights -->
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Key Highlights:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(array_slice($destination['highlights'], 0, 3) as $highlight)
                                            <span class="text-xs bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 px-3 py-1 rounded-full">
                                                {{ $highlight }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Best Time -->
                                @if(isset($destination['best_time']))
                                    <div class="mb-4 p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg">
                                        <p class="text-orange-800 text-sm font-medium">
                                            <span class="mr-1">🗓️</span>Best Time: {{ $destination['best_time'] }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Enhanced Price and Duration with Better Visibility -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 px-4 py-2 rounded-lg">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($destination['price']) }}</span>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $destination['duration'] }}</div>
                                    </div>
                                    <button 
                                        onclick="getQuote('{{ $destination['name'] }}', '{{ $destination['location'] }}', '{{ $destination['region'] }}', {{ $destination['price'] }}, '{{ $destination['duration'] }}')"
                                        class="px-6 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full hover:from-orange-600 hover:to-red-600 transition-all duration-300 font-medium transform hover:scale-105 shadow-lg"
                                    >
                                        📞 Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- South India Section -->
        <section class="py-16 bg-gradient-to-r from-green-50 to-teal-50 dark:from-gray-800 dark:to-gray-900" id="south-india">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-full text-white text-2xl mb-4">
                        🌴
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">South India</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Tropical beauty, ancient temples, serene backwaters, and pristine beaches
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($southIndia as $destination)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-3">
                            <!-- Popular Badge -->
                            @if($destination['is_popular'])
                                <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    ⭐ POPULAR
                                </div>
                            @endif

                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img 
                                    src="{{ asset($destination['image']) }}" 
                                    alt="{{ $destination['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-4">
                                    <h3 class="text-xl font-bold mb-1">{{ $destination['name'] }}</h3>
                                    <p class="text-green-300 text-sm flex items-center">
                                        <span class="mr-1">📍</span>{{ $destination['location'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                    {{ $destination['description'] }}
                                </p>

                                <!-- Highlights -->
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Key Highlights:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(array_slice($destination['highlights'], 0, 3) as $highlight)
                                            <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full">
                                                {{ $highlight }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Best Time -->
                                @if(isset($destination['best_time']))
                                    <div class="mb-4 p-3 bg-gradient-to-r from-green-50 to-teal-50 rounded-lg">
                                        <p class="text-green-800 text-sm font-medium">
                                            <span class="mr-1">🗓️</span>Best Time: {{ $destination['best_time'] }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Enhanced Price and Duration with Better Visibility -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="bg-gradient-to-r from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 px-4 py-2 rounded-lg">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($destination['price']) }}</span>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $destination['duration'] }}</div>
                                    </div>
                                    <button 
                                        onclick="getQuote('{{ $destination['name'] }}', '{{ $destination['location'] }}', '{{ $destination['region'] }}', {{ $destination['price'] }}, '{{ $destination['duration'] }}')"
                                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-full hover:from-green-600 hover:to-teal-600 transition-all duration-300 font-medium transform hover:scale-105 shadow-lg"
                                    >
                                        📞 Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- East India Section -->
        <section class="py-16" id="east-india">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full text-white text-2xl mb-4">
                        🏛️
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">East India</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Rich cultural heritage, spiritual destinations, and stunning hill stations
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($eastIndia as $destination)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-3">
                            <!-- Popular Badge -->
                            @if($destination['is_popular'])
                                <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    ⭐ POPULAR
                                </div>
                            @endif

                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img 
                                    src="{{ asset($destination['image']) }}" 
                                    alt="{{ $destination['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-4">
                                    <h3 class="text-xl font-bold mb-1">{{ $destination['name'] }}</h3>
                                    <p class="text-blue-300 text-sm flex items-center">
                                        <span class="mr-1">📍</span>{{ $destination['location'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                    {{ $destination['description'] }}
                                </p>

                                <!-- Highlights -->
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Key Highlights:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(array_slice($destination['highlights'], 0, 3) as $highlight)
                                            <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full">
                                                {{ $highlight }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Best Time -->
                                @if(isset($destination['best_time']))
                                    <div class="mb-4 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
                                        <p class="text-blue-800 text-sm font-medium">
                                            <span class="mr-1">🗓️</span>Best Time: {{ $destination['best_time'] }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Enhanced Price and Duration with Better Visibility -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-4 py-2 rounded-lg">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($destination['price']) }}</span>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $destination['duration'] }}</div>
                                    </div>
                                    <button 
                                        onclick="getQuote('{{ $destination['name'] }}', '{{ $destination['location'] }}', '{{ $destination['region'] }}', {{ $destination['price'] }}, '{{ $destination['duration'] }}')"
                                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 font-medium transform hover:scale-105 shadow-lg"
                                    >
                                        📞 Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- West India Section -->
        <section class="py-16 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-900" id="west-india">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full text-white text-2xl mb-4">
                        🏖️
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">West India</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Royal palaces, golden deserts, bustling cities, and pristine beaches
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($westIndia as $destination)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-3">
                            <!-- Popular Badge -->
                            @if($destination['is_popular'])
                                <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    ⭐ POPULAR
                                </div>
                            @endif

                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img 
                                    src="{{ asset($destination['image']) }}" 
                                    alt="{{ $destination['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-4">
                                    <h3 class="text-xl font-bold mb-1">{{ $destination['name'] }}</h3>
                                    <p class="text-purple-300 text-sm flex items-center">
                                        <span class="mr-1">📍</span>{{ $destination['location'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                    {{ $destination['description'] }}
                                </p>

                                <!-- Highlights -->
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Key Highlights:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(array_slice($destination['highlights'], 0, 3) as $highlight)
                                            <span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full">
                                                {{ $highlight }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Best Time -->
                                @if(isset($destination['best_time']))
                                    <div class="mb-4 p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                                        <p class="text-purple-800 text-sm font-medium">
                                            <span class="mr-1">🗓️</span>Best Time: {{ $destination['best_time'] }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Enhanced Price and Duration with Better Visibility -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-4 py-2 rounded-lg">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($destination['price']) }}</span>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $destination['duration'] }}</div>
                                    </div>
                                    <button 
                                        onclick="getQuote('{{ $destination['name'] }}', '{{ $destination['location'] }}', '{{ $destination['region'] }}', {{ $destination['price'] }}, '{{ $destination['duration'] }}')"
                                        class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full hover:from-purple-600 hover:to-pink-600 transition-all duration-300 font-medium transform hover:scale-105 shadow-lg"
                                    >
                                        📞 Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
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
                    Ready to Explore India?
                </h3>
                <p class="text-indigo-100 mb-10 text-lg leading-relaxed">
                    Let our travel experts create a personalized regional tour just for you. 
                    Whether you're seeking adventure, culture, or relaxation, we'll craft the perfect journey.
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
                        onclick="contactForCustomPackage()"
                        class="px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl text-lg"
                    >
                        📞 Plan My Journey
                    </button>
                    <button 
                        onclick="exploreAllDestinations()"
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

function getQuote(name, location, region, price, duration) {
    // Check if user is authenticated
    @auth
        // Navigate to booking page with destination information
        const params = new URLSearchParams({
            package_name: name,
            destination: location,
            price: price,
            duration: duration,
            package_type: region + ' Tour'
        });
        window.location.href = '{{ route("booking.index") }}?' + params.toString();
    @else
        // Store destination preference and redirect to login
        sessionStorage.setItem('intended_booking', JSON.stringify({
            name: name,
            location: location,
            region: region,
            price: price,
            duration: duration,
            package_type: region + ' Tour'
        }));
        window.location.href = '{{ route("login") }}';
    @endauth
}

function contactForCustomPackage() {
    // Navigate to contact form with custom package request
    const params = new URLSearchParams({
        request: 'custom-regional-package'
    });
    
    window.location.href = '/#contact?' + params.toString();
}

function exploreAllDestinations() {
    window.location.href = '/tour-packages';
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
    
    /* Enhanced text shadows for better visibility */
    .drop-shadow-lg {
        filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.8)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.6));
    }
    
    .drop-shadow-md {
        filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.6)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.4));
    }
    
    .drop-shadow-xl {
        filter: drop-shadow(0 20px 13px rgb(0 0 0 / 0.9)) drop-shadow(0 8px 5px rgb(0 0 0 / 0.8)) drop-shadow(0 3px 3px rgb(0 0 0 / 0.7));
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
</style>
