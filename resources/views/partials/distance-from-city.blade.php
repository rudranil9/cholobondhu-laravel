<div class="space-y-8">
    <!-- Distance Filter Tabs -->
    <div class="flex flex-wrap justify-center gap-4 mb-8">
        <button 
            onclick="setSelectedDistance('weekend')"
            id="weekend-tab"
            class="distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white"
        >
            <span>🚗</span>
            <span>Weekend Getaways</span>
            <span class="text-xs opacity-75">(0-100km)</span>
        </button>
        <button 
            onclick="setSelectedDistance('short')"
            id="short-tab"
            class="distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gray-100 text-gray-600 hover:bg-gray-200"
        >
            <span>🚌</span>
            <span>Short Trips</span>
            <span class="text-xs opacity-75">(100-300km)</span>
        </button>
        <button 
            onclick="setSelectedDistance('long')"
            id="long-tab"
            class="distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gray-100 text-gray-600 hover:bg-gray-200"
        >
            <span>✈️</span>
            <span>Long Distance</span>
            <span class="text-xs opacity-75">(300km+)</span>
        </button>
    </div>

    <!-- Category Description -->
    <div class="text-center mb-8">
        <div id="weekend-description" class="distance-description bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-2xl">
            <h3 class="text-2xl font-bold text-purple-800 mb-2">🚗 Weekend Getaways</h3>
            <p class="text-purple-700">Quick escapes within 100km - Perfect for short breaks and spontaneous trips</p>
        </div>
        <div id="short-description" class="distance-description bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-2xl hidden">
            <h3 class="text-2xl font-bold text-blue-800 mb-2">🚌 Short Trips</h3>
            <p class="text-blue-700">Comfortable distances 100-300km - Ideal for 3-5 day holidays</p>
        </div>
        <div id="long-description" class="distance-description bg-gradient-to-r from-green-50 to-teal-50 p-6 rounded-2xl hidden">
            <h3 class="text-2xl font-bold text-green-800 mb-2">✈️ Long Distance Adventures</h3>
            <p class="text-green-700">Epic journeys 300km+ - Perfect for extended vacations and exploration</p>
        </div>
    </div>

    <!-- Destinations Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($distanceDestinations as $destination)
        <div 
            class="distance-destination bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group"
            data-category="{{ $destination['category'] }}"
            style="display: {{ $destination['category'] === 'weekend' ? 'block' : 'none' }}"
        >
            <!-- Destination Image -->
            <div class="relative overflow-hidden">
                <img 
                    src="{{ asset($destination['image']) }}" 
                    alt="{{ $destination['name'] }}"
                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700"
                >
                @php
                $categoryBadgeClasses = [
                    'weekend' => 'bg-gradient-to-r from-purple-500 to-pink-500',
                    'short' => 'bg-gradient-to-r from-blue-500 to-indigo-500',
                    'long' => 'bg-gradient-to-r from-green-500 to-teal-500'
                ];
                $categoryIcons = ['weekend' => '🚗', 'short' => '🚌', 'long' => '✈️'];
                @endphp
                <div class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold text-white {{ $categoryBadgeClasses[$destination['category']] }}">
                    {{ $categoryIcons[$destination['category']] }} {{ $destination['distance'] }}km
                </div>
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                    ₹{{ number_format($destination['price']) }}
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>

            <!-- Destination Content -->
            <div class="p-6">
                <div class="mb-3">
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors mb-1">
                        {{ $destination['name'] }}
                    </h3>
                    <div class="flex items-center text-gray-600 text-sm">
                        <span class="text-red-500 mr-1">📍</span>
                        <span class="mr-3">{{ $destination['location'] }}</span>
                        <span class="text-blue-500 mr-1">⏱️</span>
                        <span>{{ $destination['duration'] }}</span>
                    </div>
                </div>

                <p class="text-gray-600 mb-4 text-sm line-clamp-3">{{ $destination['description'] }}</p>

                <!-- Travel Info -->
                @php
                $categoryInfoClasses = [
                    'weekend' => 'border-l-4 p-3 mb-4 bg-purple-50 border-purple-400',
                    'short' => 'border-l-4 p-3 mb-4 bg-blue-50 border-blue-400',
                    'long' => 'border-l-4 p-3 mb-4 bg-green-50 border-green-400'
                ];
                @endphp
                <div class="{{ $categoryInfoClasses[$destination['category']] }}">
                    <div class="flex items-center mb-1">
                        <span class="text-lg mr-2">🚗</span>
                        <span class="font-semibold text-sm">Travel Time: {{ $destination['travel_time'] }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($destination['transport_mode'] as $mode)
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                            {{ $mode }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Best For -->
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 mb-2 text-sm">Best For:</h4>
                    <div class="flex flex-wrap gap-1">
                        @php
                        $categoryTagClasses = [
                            'weekend' => 'bg-purple-100 text-purple-800',
                            'short' => 'bg-blue-100 text-blue-800',
                            'long' => 'bg-green-100 text-green-800'
                        ];
                        @endphp
                        @foreach($destination['best_for'] as $bestFor)
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $categoryTagClasses[$destination['category']] }}">
                            {{ $bestFor }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Highlights -->
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 mb-2 text-sm">Highlights:</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        @foreach(array_slice($destination['highlights'], 0, 3) as $highlight)
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 mt-0.5">✓</span>
                            <span>{{ $highlight }}</span>
                        </li>
                        @endforeach
                        @if(count($destination['highlights']) > 3)
                        <li class="text-gray-500 text-xs">
                            +{{ count($destination['highlights']) - 3 }} more highlights
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- Action Buttons -->
                @php
                $categoryButtonClasses = [
                    'weekend' => 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600',
                    'short' => 'bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600',
                    'long' => 'bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600'
                ];
                $categoryBorderClasses = [
                    'weekend' => 'border-purple-500 text-purple-500 hover:bg-purple-500 hover:text-white',
                    'short' => 'border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white',
                    'long' => 'border-green-500 text-green-500 hover:bg-green-500 hover:text-white'
                ];
                @endphp
                <div class="flex space-x-3">
                    <button 
                        onclick="planTrip({{ json_encode($destination) }})"
                        class="flex-1 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 {{ $categoryButtonClasses[$destination['category']] }}"
                    >
                        Plan Trip
                    </button>
                    <button 
                        onclick="bookDestination({{ json_encode($destination) }})"
                        class="flex-1 border-2 py-2 px-4 rounded-lg font-semibold transition-all duration-300 {{ $categoryBorderClasses[$destination['category']] }}"
                    >
                        Book Now
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Distance Summary -->
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-2xl mt-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Choose Your Perfect Distance</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-white rounded-lg">
                <div class="text-2xl mb-2">🚗</div>
                <h4 class="font-semibold text-purple-800">Weekend (0-100km)</h4>
                <p class="text-sm text-gray-600">2-3 hours drive</p>
                <p class="text-xs text-gray-500">Perfect for quick getaways</p>
            </div>
            <div class="text-center p-4 bg-white rounded-lg">
                <div class="text-2xl mb-2">🚌</div>
                <h4 class="font-semibold text-blue-800">Short (100-300km)</h4>
                <p class="text-sm text-gray-600">3-6 hours journey</p>
                <p class="text-xs text-gray-500">Ideal for mini vacations</p>
            </div>
            <div class="text-center p-4 bg-white rounded-lg">
                <div class="text-2xl mb-2">✈️</div>
                <h4 class="font-semibold text-green-800">Long (300km+)</h4>
                <p class="text-sm text-gray-600">6+ hours or flight</p>
                <p class="text-xs text-gray-500">Epic adventure trips</p>
            </div>
        </div>
    </div>
</div>

<script>
let selectedDistance = 'weekend';

function setSelectedDistance(category) {
    selectedDistance = category;
    
    // Update tab styles
    document.querySelectorAll('.distance-tab').forEach(tab => {
        tab.className = 'distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gray-100 text-gray-600 hover:bg-gray-200';
    });
    
    // Set active tab
    const activeTab = document.getElementById(category + '-tab');
    if (category === 'weekend') {
        activeTab.className = 'distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white';
    } else if (category === 'short') {
        activeTab.className = 'distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white';
    } else if (category === 'long') {
        activeTab.className = 'distance-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center space-x-2 bg-gradient-to-r from-green-500 to-teal-500 text-white';
    }
    
    // Hide all descriptions
    document.querySelectorAll('.distance-description').forEach(desc => {
        desc.classList.add('hidden');
    });
    
    // Show selected description
    document.getElementById(category + '-description').classList.remove('hidden');
    
    // Hide all destinations
    document.querySelectorAll('.distance-destination').forEach(dest => {
        dest.style.display = 'none';
    });
    
    // Show destinations for selected category
    document.querySelectorAll(`[data-category="${category}"]`).forEach(dest => {
        dest.style.display = 'block';
    });
}

function planTrip(destination) {
    console.log('Planning trip to:', destination.name);
    alert(`Planning trip to ${destination.name} (${destination.distance}km away). This would show route planning, itinerary options, and travel tips.`);
}

function bookDestination(destination) {
    // Navigate to contact form with destination information
    const params = new URLSearchParams({
        destination: destination.name,
        location: destination.location,
        distance: destination.distance,
        price: destination.price,
        duration: destination.duration,
        category: destination.category,
        request: 'booking'
    });
    window.location.href = '/contact?' + params.toString();
}
</script>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
