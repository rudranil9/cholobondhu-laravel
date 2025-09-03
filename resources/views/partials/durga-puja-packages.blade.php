<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($durgaPujaPackages as $pkg)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
        <!-- Package Image -->
        <div class="relative overflow-hidden">
            <img 
                src="{{ asset($pkg['image']) }}" 
                alt="{{ $pkg['name'] }}"
                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700"
            >
            <div class="absolute top-4 left-4 bg-gradient-to-r from-orange-500 to-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                Puja Special
            </div>
            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                {{ round((($pkg['original_price'] - $pkg['price']) / $pkg['original_price']) * 100) }}% OFF
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>

        <!-- Package Content -->
        <div class="p-6">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-blue-600 transition-colors">
                    {{ $pkg['name'] }}
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                    {{ $pkg['duration'] }}
                </span>
            </div>
            
            <p class="text-gray-600 dark:text-gray-300 mb-2 flex items-center">
                <span class="text-blue-500 mr-1">📍</span>
                {{ $pkg['location'] }}
            </p>
            
            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                {{ $pkg['description'] }}
            </p>

            <!-- Festival Dates -->
            <div class="mb-4 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border-l-4 border-orange-500">
                <p class="text-orange-800 dark:text-orange-200 font-medium flex items-center">
                    <span class="mr-2">🗓️</span>
                    Package Type: {{ $pkg['package_type'] }}
                </p>
            </div>

            <!-- Highlights -->
            <div class="mb-4">
                <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Key Highlights:</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach(array_slice($pkg['highlights'], 0, 3) as $highlight)
                        <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">
                            {{ $highlight }}
                        </span>
                    @endforeach
                    @if(count($pkg['highlights']) > 3)
                        <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full">
                            +{{ count($pkg['highlights']) - 3 }} more
                        </span>
                    @endif
                </div>
            </div>

            <!-- Special Features -->
            <div class="mb-4">
                <div class="flex flex-wrap gap-2">
                    @foreach($pkg['special_features'] as $feature)
                        <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded-full">
                            ✨ {{ $feature }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Pricing -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">₹{{ number_format($pkg['price']) }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">₹{{ number_format($pkg['original_price']) }}</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">per person</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Contact:</p>
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">+91 8100282665</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button 
                    onclick="viewDetails({{ json_encode($pkg) }})"
                    class="flex-1 px-4 py-2 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-300 text-sm font-medium"
                >
                    View Details
                </button>
                <button 
                    onclick="bookNow({{ json_encode($pkg) }})"
                    class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 text-sm font-medium transform hover:scale-105"
                >
                    Book Now
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Contact Information -->
<div class="mt-12 text-center bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-2xl p-8">
    <!-- Company Logo -->
    <div class="w-16 h-16 mx-auto mb-4 bg-white rounded-full shadow-lg overflow-hidden">
        <img 
            src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
            alt="Cholo Bondhu Logo" 
            class="w-full h-full object-contain"
        />
    </div>
    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        🕉️ Celebrate Durga Puja with Cholobondhu Tour And Travels
    </h3>
    <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-2xl mx-auto">
        Join us for an unforgettable Durga Puja celebration! Book your special package now and experience the divine festivities with comfort and joy.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <div class="flex items-center space-x-2 text-lg">
            <span>📱</span>
            <span class="font-semibold text-blue-600 dark:text-blue-400">WhatsApp: +91 8100282665</span>
        </div>
        <div class="flex items-center space-x-2 text-lg">
            <span>🌐</span>
            <span class="font-semibold text-purple-600 dark:text-purple-400">www.cholobondhu.com</span>
        </div>
    </div>
    <div class="mt-6">
        <button 
            onclick="contactForCustomPackage()"
            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 transform hover:scale-105 shadow-lg"
        >
            📞 Contact for Custom Package
        </button>
    </div>
</div>

<!-- Modal for Package Details -->
<div 
    id="packageModal" 
    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden"
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
</div>

<!-- Contact Information -->
<div class="mt-12 text-center bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-2xl p-8">
    <!-- Company Logo -->
    <div class="w-16 h-16 mx-auto mb-4 bg-white rounded-full shadow-lg overflow-hidden">
        <img 
            src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
            alt="Cholo Bondhu Logo" 
            class="w-full h-full object-contain"
        />
    </div>
    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        🕉️ Celebrate Durga Puja with Cholobondhu Tour And Travels
    </h3>
    <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-2xl mx-auto">
        Join us for an unforgettable Durga Puja celebration! Book your special package now and experience the divine festivities with comfort and joy.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <div class="flex items-center space-x-2 text-lg">
            <span>📱</span>
            <span class="font-semibold text-blue-600 dark:text-blue-400">WhatsApp: +91 8100282665</span>
        </div>
        <div class="flex items-center space-x-2 text-lg">
            <span>🌐</span>
            <span class="font-semibold text-purple-600 dark:text-purple-400">www.cholobondhu.com</span>
        </div>
    </div>
    <div class="mt-6">
        <button 
            onclick="contactForCustomPackage()"
            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 transform hover:scale-105 shadow-lg"
        >
            📞 Contact for Custom Package
        </button>
    </div>
</div>

<script>
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
            package_type: pkg.package_type || 'durga-puja-special'
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

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

.animate-slideInUp {
    animation: slideInUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideInUp {
    from {
        transform: translateY(100px) scale(0.8);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}
</style>
