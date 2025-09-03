@extends('layouts.app')

@section('title', 'Tour Packages - Cholo Bondhu')
@section('description', 'Discover amazing destinations and create unforgettable memories with our carefully curated tour packages designed for every type of traveler.')

@section('content')
    <!-- Professional Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-gray-50 via-slate-50 to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 relative overflow-hidden">
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
                        Tour 
                        <span class="relative inline-block">
                            <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent">
                                Packages
                            </span>
                            <div class="absolute -bottom-3 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full transform scale-x-0 animate-scale-x"></div>
                        </span>
                    </h1>
                    
                    <!-- Professional Subtitle -->
                    <div class="max-w-4xl mx-auto">
                        <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 leading-relaxed font-light mb-8">
                            Discover amazing destinations and create unforgettable memories with our carefully curated tour packages designed for every type of traveler.
                        </p>
                        
                        <!-- Professional Call-to-Action -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <button 
                                onclick="scrollToPackages()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2"
                            >
                                <span>Explore Packages</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium">75+ unique destinations available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Travel Background Animations -->
    <div class="travel-background-layer">
        <!-- Flying Planes -->
        <div class="travel-vehicle plane-1">✈️</div>
        <div class="travel-vehicle plane-2">🛫</div>
        <div class="travel-vehicle plane-3">🛩️</div>
        
        <!-- Moving Trains -->
        <div class="travel-vehicle train-1">🚄</div>
        <div class="travel-vehicle train-2">🚂</div>
        <div class="travel-vehicle train-3">🚆</div>
        
        <!-- Cars and Buses -->
        <div class="travel-vehicle car-1">🚗</div>
        <div class="travel-vehicle bus-1">🚌</div>
        <div class="travel-vehicle car-2">🚙</div>
        
        <!-- Ships and Boats -->
        <div class="travel-vehicle ship-1">🛳️</div>
        <div class="travel-vehicle boat-1">⛵</div>
        <div class="travel-vehicle ship-2">🚢</div>
        
        <!-- Travel Elements -->
        <div class="travel-element-bg map-1">🗺️</div>
        <div class="travel-element-bg compass-1">🧭</div>
        <div class="travel-element-bg luggage-1">🎒</div>
        <div class="travel-element-bg camera-1">📷</div>
        <div class="travel-element-bg world-1">🌍</div>
        <div class="travel-element-bg mountain-1">🏔️</div>
        
        <!-- Floating Travel Particles -->
        <div class="travel-particle star-1">⭐</div>
        <div class="travel-particle star-2">✨</div>
        <div class="travel-particle star-3">🌟</div>
        <div class="travel-particle cloud-1">☁️</div>
        <div class="travel-particle cloud-2">⛅</div>
        <div class="travel-particle sun-1">☀️</div>
    </div>

    <!-- Package Categories -->
    <main class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 py-12 relative z-10">
            <!-- Durga Puja Special Packages -->
            <section id="durga-puja-packages" class="mb-16 scroll-mt-20 relative">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Durga Puja Special Packages</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-red-500 mx-auto mb-4"></div>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Experience the grandeur of Durga Puja with our exclusive festival packages
                    </p>
                </div>
                @include('partials.durga-puja-packages')
            </section>

            <!-- Search by Mood -->
            <section id="search-by-mood" class="mb-16 scroll-mt-20 relative">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Search by Your Mood</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-blue-500 mx-auto mb-4"></div>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Find the perfect destination based on your current mood and preferences
                    </p>
                </div>
                @include('partials.search-by-mood')
            </section>

            <!-- Distance from City -->
            <section id="distance-from-city" class="mb-16 scroll-mt-20 relative">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Distance from City</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto mb-4"></div>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Choose your perfect getaway based on how far you want to travel
                    </p>
                </div>
                @include('partials.distance-from-city')
            </section>

            <!-- Call to Action Section -->
            <section class="text-center py-16 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl relative">
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Ready to Start Your Journey?</h3>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                    Have questions or need a custom package? Our travel experts are here to help you plan the perfect trip.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a 
                        href="{{ route('contact') }}"
                        class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg"
                    >
                        Contact Our Experts
                    </a>
                    <a 
                        href="{{ route('contact', ['request' => 'custom-quote']) }}"
                        class="px-8 py-4 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-all duration-300"
                    >
                        Get Custom Quote
                    </a>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal for Package Details -->
    <div 
        id="packageModal" 
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden animate-fadeIn"
        onclick="closeModal()"
    >
        <div 
            class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl animate-slideInUp"
            onclick="event.stopPropagation()"
        >
            <!-- Modal Header -->
            <div class="relative bg-gradient-to-r from-orange-500 to-red-500 text-white p-6 rounded-t-2xl">
                <button 
                    onclick="closeModal()"
                    class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl font-bold transition-all duration-200 hover:scale-110 hover:rotate-90"
                >
                    ×
                </button>
                <!-- Company Logo -->
                <div class="w-12 h-12 mx-auto mb-3 bg-white rounded-full shadow-lg overflow-hidden">
                    <img 
                        src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                        alt="Cholo Bondhu Logo" 
                        class="w-full h-full object-contain"
                    />
                </div>
                <h2 id="modalPackageName" class="text-2xl font-bold mb-2"></h2>
                <div class="flex items-center justify-center space-x-4 text-sm">
                    <span id="modalLocation"></span>
                    <span id="modalDuration"></span>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <!-- Price Section -->
                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span id="modalPrice" class="text-3xl font-bold text-green-600 dark:text-green-400"></span>
                            <span id="modalOriginalPrice" class="text-lg text-gray-500 dark:text-gray-400 line-through ml-3"></span>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">per person</p>
                        </div>
                        <div class="text-center">
                            <div id="modalDiscount" class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            </div>
                            <p id="modalPackageType" class="text-xs text-gray-600 dark:text-gray-300 mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">About This Package</h3>
                    <p id="modalDescription" class="text-gray-600 dark:text-gray-300 leading-relaxed"></p>
                </div>

                <!-- Highlights -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">✨ Package Highlights</h3>
                    <div id="modalHighlights" class="grid grid-cols-1 md:grid-cols-2 gap-2"></div>
                </div>

                <!-- Inclusions -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">📋 What's Included</h3>
                    <div id="modalInclusions" class="grid grid-cols-1 md:grid-cols-2 gap-2"></div>
                </div>

                <!-- Special Features -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">🌟 Special Features</h3>
                    <div id="modalSpecialFeatures" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- Contact Information -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">📞 Contact Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center space-x-2">
                            <span>📱</span>
                            <span class="font-semibold text-blue-600 dark:text-blue-400">WhatsApp: +91 8100282665</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span>🌐</span>
                            <span class="font-semibold text-purple-600 dark:text-purple-400">www.cholobondhu.com</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span>🏢</span>
                            <span class="text-gray-600 dark:text-gray-300">Cholobondhu Tour And Travels</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button 
                        onclick="bookNowModal()"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-medium transform hover:scale-105"
                    >
                        📞 Book Now
                    </button>
                    <button 
                        onclick="contactForMoreInfo()"
                        class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 font-medium"
                    >
                        💬 More Info
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function scrollToPackages() {
    const element = document.getElementById('durga-puja-packages');
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

let selectedPackage = null;

function calculateDiscount(currentPrice, originalPrice) {
    return Math.round(((originalPrice - currentPrice) / originalPrice) * 100);
}

function viewDetails(pkg) {
    selectedPackage = pkg;
    document.getElementById('modalPackageName').textContent = pkg.name;
    document.getElementById('modalLocation').textContent = '📍 ' + pkg.location;
    document.getElementById('modalDuration').textContent = '⏰ ' + pkg.duration;
    document.getElementById('modalPrice').textContent = '₹' + new Intl.NumberFormat().format(pkg.price);
    document.getElementById('modalOriginalPrice').textContent = '₹' + new Intl.NumberFormat().format(pkg.original_price);
    document.getElementById('modalDiscount').textContent = calculateDiscount(pkg.price, pkg.original_price) + '% OFF';
    document.getElementById('modalPackageType').textContent = pkg.package_type;
    document.getElementById('modalDescription').textContent = pkg.description;
    
    // Clear and populate highlights
    const highlightsContainer = document.getElementById('modalHighlights');
    highlightsContainer.innerHTML = '';
    pkg.highlights.forEach(highlight => {
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300';
        div.innerHTML = `<span class="text-blue-500">•</span><span>${highlight}</span>`;
        highlightsContainer.appendChild(div);
    });
    
    // Clear and populate inclusions
    const inclusionsContainer = document.getElementById('modalInclusions');
    inclusionsContainer.innerHTML = '';
    pkg.inclusions.forEach(inclusion => {
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 text-sm text-green-600 dark:text-green-400';
        div.innerHTML = `<span>✓</span><span>${inclusion}</span>`;
        inclusionsContainer.appendChild(div);
    });
    
    // Clear and populate special features
    const featuresContainer = document.getElementById('modalSpecialFeatures');
    featuresContainer.innerHTML = '';
    pkg.special_features.forEach(feature => {
        const span = document.createElement('span');
        span.className = 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full text-sm';
        span.textContent = feature;
        featuresContainer.appendChild(span);
    });
    
    document.getElementById('packageModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('packageModal').classList.add('hidden');
    selectedPackage = null;
}

function bookNow(pkg) {
    // Check if user is authenticated
    @auth
        // Navigate to booking page with package information
        const params = new URLSearchParams({
            package_name: pkg.name,
            destination: pkg.location,
            price: pkg.price,
            duration: pkg.duration,
            package_type: pkg.package_type || 'tour'
        });
        window.location.href = '{{ route("booking.index") }}?' + params.toString();
    @else
        // Redirect to login first, then to booking
        sessionStorage.setItem('intended_booking', JSON.stringify(pkg));
        window.location.href = '{{ route("login") }}';
    @endauth
}

function bookNowModal() {
    if (selectedPackage) {
        bookNow(selectedPackage);
    }
}

function contactForMoreInfo() {
    if (selectedPackage) {
        const params = new URLSearchParams({
            package: selectedPackage.name,
            price: selectedPackage.price,
            duration: selectedPackage.duration,
            request: 'more-info'
        });
        window.location.href = '/contact?' + params.toString();
    }
    closeModal();
}

function contactForCustomPackage() {
    const params = new URLSearchParams({
        request: 'custom-quote',
        category: 'durga-puja-special'
    });
    window.location.href = '/contact?' + params.toString();
}
</script>
@endpush

<style>
    /* Dynamic Travel Background Layer */
    .travel-background-layer {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 1;
        overflow: hidden;
    }

    /* Hide animations in content areas */
    .travel-background-layer::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        width: 90%;
        height: 70%;
        background: transparent;
        z-index: 2;
    }

    /* Travel Vehicles - Dynamic Movement */
    .travel-vehicle {
        position: absolute;
        font-size: 2rem;
        opacity: 0.7;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
    }

    /* Planes - Flying at edges only */
    .plane-1 {
        top: 8%;
        left: -100px;
        animation: fly-right 25s linear infinite;
    }

    .plane-2 {
        top: 12%;
        right: -100px;
        animation: fly-left 30s linear infinite 8s;
        transform: scaleX(-1);
    }

    .plane-3 {
        top: 85%;
        left: -100px;
        animation: fly-diagonal 35s linear infinite 15s;
    }

    @keyframes fly-right {
        0% { transform: translateX(-100px) translateY(0px); }
        100% { transform: translateX(calc(100vw + 100px)) translateY(-50px); }
    }

    @keyframes fly-left {
        0% { transform: scaleX(-1) translateX(100px) translateY(0px); }
        100% { transform: scaleX(-1) translateX(calc(-100vw - 100px)) translateY(30px); }
    }

    @keyframes fly-diagonal {
        0% { transform: translateX(-100px) translateY(0px); }
        50% { transform: translateX(50vw) translateY(-80px); }
        100% { transform: translateX(calc(100vw + 100px)) translateY(20px); }
    }

    /* Trains - At bottom edge only */
    .train-1 {
        bottom: 5%;
        left: -150px;
        animation: train-journey 20s linear infinite 5s;
    }

    .train-2 {
        bottom: 8%;
        right: -150px;
        animation: train-return 22s linear infinite 12s;
        transform: scaleX(-1);
    }

    .train-3 {
        bottom: 2%;
        left: -150px;
        animation: train-journey 18s linear infinite 20s;
    }

    @keyframes train-journey {
        0% { transform: translateX(-150px); }
        100% { transform: translateX(calc(100vw + 150px)); }
    }

    @keyframes train-return {
        0% { transform: scaleX(-1) translateX(150px); }
        100% { transform: scaleX(-1) translateX(calc(-100vw - 150px)); }
    }

    /* Cars and Buses - Road Movement */
    .car-1 {
        bottom: 10%;
        left: -80px;
        animation: drive-right 15s linear infinite 3s;
    }

    .bus-1 {
        bottom: 25%;
        right: -120px;
        animation: drive-left 18s linear infinite 10s;
        transform: scaleX(-1);
    }

    .car-2 {
        bottom: 5%;
        left: -80px;
        animation: drive-right 16s linear infinite 25s;
    }

    @keyframes drive-right {
        0% { transform: translateX(-80px); }
        100% { transform: translateX(calc(100vw + 80px)); }
    }

    @keyframes drive-left {
        0% { transform: scaleX(-1) translateX(120px); }
        100% { transform: scaleX(-1) translateX(calc(-100vw - 120px)); }
    }

    /* Ships - Water Movement */
    .ship-1 {
        bottom: 30%;
        left: -100px;
        animation: sail-waves 28s linear infinite 7s;
    }

    .boat-1 {
        bottom: 35%;
        right: -80px;
        animation: sail-return 24s linear infinite 18s;
        transform: scaleX(-1);
    }

    .ship-2 {
        bottom: 45%;
        left: -100px;
        animation: sail-waves 32s linear infinite 30s;
    }

    @keyframes sail-waves {
        0% { transform: translateX(-100px) translateY(0px); }
        25% { transform: translateX(25vw) translateY(-10px); }
        50% { transform: translateX(50vw) translateY(5px); }
        75% { transform: translateX(75vw) translateY(-8px); }
        100% { transform: translateX(calc(100vw + 100px)) translateY(0px); }
    }

    @keyframes sail-return {
        0% { transform: scaleX(-1) translateX(80px) translateY(0px); }
        25% { transform: scaleX(-1) translateX(-25vw) translateY(8px); }
        50% { transform: scaleX(-1) translateX(-50vw) translateY(-5px); }
        75% { transform: scaleX(-1) translateX(-75vw) translateY(10px); }
        100% { transform: scaleX(-1) translateX(calc(-100vw - 80px)) translateY(0px); }
    }

    /* Travel Elements Background - Edge positions only */
    .travel-element-bg {
        position: absolute;
        font-size: 1.8rem;
        opacity: 0.3;
    }

    .map-1 {
        top: 5%;
        left: 5%;
        animation: gentle-float 8s ease-in-out infinite;
    }

    .compass-1 {
        top: 10%;
        right: 5%;
        animation: gentle-float 10s ease-in-out infinite 2s;
    }

    .luggage-1 {
        bottom: 10%;
        left: 3%;
        animation: gentle-bounce 12s ease-in-out infinite 4s;
    }

    .camera-1 {
        bottom: 15%;
        right: 8%;
        animation: gentle-bounce 9s ease-in-out infinite 1s;
    }

    .world-1 {
        top: 8%;
        left: 15%;
        animation: gentle-rotate 15s linear infinite;
    }

    .mountain-1 {
        bottom: 5%;
        right: 15%;
        animation: gentle-float 11s ease-in-out infinite 3s;
    }

    @keyframes gentle-float {
        0%, 100% { transform: translateY(0px) translateX(0px); }
        25% { transform: translateY(-15px) translateX(5px); }
        50% { transform: translateY(-8px) translateX(-3px); }
        75% { transform: translateY(-12px) translateX(8px); }
    }

    @keyframes gentle-bounce {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-20px) scale(1.1); }
    }

    @keyframes gentle-rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Travel Particles - Edge positions only */
    .travel-particle {
        position: absolute;
        font-size: 1.2rem;
        opacity: 0.5;
    }

    .star-1 {
        top: 3%;
        left: 8%;
        animation: twinkle-drift 6s ease-in-out infinite;
    }

    .star-2 {
        top: 6%;
        right: 12%;
        animation: twinkle-drift 8s ease-in-out infinite 2s;
    }

    .star-3 {
        bottom: 8%;
        left: 10%;
        animation: twinkle-drift 7s ease-in-out infinite 4s;
    }

    .cloud-1 {
        top: 4%;
        left: 25%;
        animation: cloud-drift 20s linear infinite;
    }

    .cloud-2 {
        top: 7%;
        right: 25%;
        animation: cloud-drift 25s linear infinite 10s;
    }

    .sun-1 {
        top: 2%;
        right: 3%;
        animation: sun-glow 4s ease-in-out infinite;
    }

    @keyframes twinkle-drift {
        0%, 100% { transform: translateY(0px) scale(1); opacity: 0.6; }
        25% { transform: translateY(-30px) scale(1.2); opacity: 1; }
        50% { transform: translateY(-15px) scale(0.8); opacity: 0.8; }
        75% { transform: translateY(-25px) scale(1.1); opacity: 0.9; }
    }

    @keyframes cloud-drift {
        0% { transform: translateX(-50px); }
        100% { transform: translateX(calc(100vw + 50px)); }
    }

    @keyframes sun-glow {
        0%, 100% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.2); opacity: 1; }
    }

    /* Original Styles */
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

    section {
        scroll-margin-top: 80px;
    }

    /* Ensure text content is above animations */
    main {
        position: relative;
        z-index: 10;
        background: transparent;
    }

    /* Responsive - Reduce animations on smaller screens */
    @media (max-width: 768px) {
        .travel-vehicle,
        .travel-element-bg {
            font-size: 1.5rem;
        }
        
        .travel-particle {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .travel-vehicle {
            display: none;
        }
        
        .travel-element-bg,
        .travel-particle {
            font-size: 0.8rem;
            opacity: 0.3;
        }
    }

    .bg-clip-text {
        -webkit-background-clip: text;
        background-clip: text;
    }
</style>
