<div class="space-y-8">
    <!-- Mood Filter Tabs -->
    <div class="flex flex-wrap justify-center gap-4 mb-8">
        <button 
            onclick="setSelectedMood('hills')"
            id="hills-tab"
            class="mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gradient-to-r from-green-500 to-blue-500 text-white"
        >
            <span class="mr-2">🏔️</span>
            Hill Stations
        </button>
        <button 
            onclick="setSelectedMood('sea')"
            id="sea-tab"
            class="mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200"
        >
            <span class="mr-2">🌊</span>
            Sea & Beaches
        </button>
        <button 
            onclick="setSelectedMood('forest')"
            id="forest-tab"
            class="mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200"
        >
            <span class="mr-2">🌲</span>
            Forests & Wildlife
        </button>
    </div>

    <!-- Mood Description -->
    <div class="text-center mb-8">
        <div id="hills-description" class="mood-description bg-gradient-to-r from-green-50 to-blue-50 p-6 rounded-2xl">
            <h3 class="text-2xl font-bold text-green-800 mb-2">🏔️ Hill Station Escapes</h3>
            <p class="text-green-700">Breathe in the fresh mountain air, enjoy cool weather, and find peace in nature's grandeur</p>
        </div>
        <div id="sea-description" class="mood-description bg-gradient-to-r from-blue-50 to-cyan-50 p-6 rounded-2xl hidden">
            <h3 class="text-2xl font-bold text-blue-800 mb-2">🌊 Coastal Adventures</h3>
            <p class="text-blue-700">Feel the ocean breeze, walk on sandy beaches, and let the waves wash your worries away</p>
        </div>
        <div id="forest-description" class="mood-description bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-2xl hidden">
            <h3 class="text-2xl font-bold text-emerald-800 mb-2">🌲 Forest Retreats</h3>
            <p class="text-emerald-700">Connect with nature, discover wildlife, and rejuvenate in the heart of wilderness</p>
        </div>
    </div>

    <!-- Destinations Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($moodDestinations as $destination)
        <div 
            class="mood-destination bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group"
            data-mood="{{ $destination['mood'] }}"
            style="display: {{ $destination['mood'] === 'hills' ? 'block' : 'none' }}"
        >
            <!-- Destination Image -->
            <div class="relative overflow-hidden">
                <img 
                    src="{{ asset($destination['image']) }}" 
                    alt="{{ $destination['name'] }}"
                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700"
                >
                @php
                $moodBadgeClasses = [
                    'hills' => 'bg-gradient-to-r from-green-500 to-blue-500',
                    'sea' => 'bg-gradient-to-r from-blue-500 to-cyan-500',
                    'forest' => 'bg-gradient-to-r from-green-500 to-emerald-500'
                ];
                $moodIcons = ['hills' => '🏔️', 'sea' => '🌊', 'forest' => '🌲'];
                $moodLabels = ['hills' => 'Hill Stations', 'sea' => 'Sea & Beaches', 'forest' => 'Forests & Wildlife'];
                @endphp
                <div class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold text-white {{ $moodBadgeClasses[$destination['mood']] }}">
                    {{ $moodIcons[$destination['mood']] }} {{ $moodLabels[$destination['mood']] }}
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

                <!-- Best Time -->
                <div class="bg-amber-50 border-l-4 border-amber-400 p-3 mb-4">
                    <div class="flex items-center">
                        <span class="text-amber-500 mr-2">🌤️</span>
                        <span class="font-semibold text-amber-800 text-sm">Best Time:</span>
                    </div>
                    <p class="text-amber-700 text-sm">{{ $destination['best_time'] }}</p>
                </div>

                <!-- Activities -->
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 mb-2 text-sm">Popular Activities:</h4>
                    <div class="flex flex-wrap gap-1">
                        @php
                        $moodTagClasses = [
                            'hills' => 'bg-green-100 text-green-800',
                            'sea' => 'bg-blue-100 text-blue-800',
                            'forest' => 'bg-emerald-100 text-emerald-800'
                        ];
                        @endphp
                        @foreach(array_slice($destination['activities'], 0, 3) as $activity)
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $moodTagClasses[$destination['mood']] }}">
                            {{ $activity }}
                        </span>
                        @endforeach
                        @if(count($destination['activities']) > 3)
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            +{{ count($destination['activities']) - 3 }} more
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Features -->
                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        @foreach(array_slice($destination['features'], 0, 2) as $feature)
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                            {{ $feature }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                @php
                $moodButtonClasses = [
                    'hills' => 'bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600',
                    'sea' => 'bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600',
                    'forest' => 'bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600'
                ];
                $moodBorderClasses = [
                    'hills' => 'border-green-500 text-green-500 hover:bg-green-500 hover:text-white',
                    'sea' => 'border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white',
                    'forest' => 'border-emerald-500 text-emerald-500 hover:bg-emerald-500 hover:text-white'
                ];
                @endphp
                <div class="flex space-x-3">
                    <button 
                        onclick="exploreDestination({{ json_encode($destination) }})"
                        class="flex-1 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 {{ $moodButtonClasses[$destination['mood']] }}"
                    >
                        Explore
                    </button>
                    <button 
                        onclick="getMoodQuote({{ json_encode($destination) }})"
                        class="flex-1 border-2 py-2 px-4 rounded-lg font-semibold transition-all duration-300 {{ $moodBorderClasses[$destination['mood']] }}"
                    >
                        Get Quote
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Show All Button -->
    <div class="text-center mt-8">
        <button id="viewAllMoodBtn" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
            View All Hill Stations Destinations
        </button>
    </div>
</div>

<script>
let selectedMood = 'hills';

function setSelectedMood(mood) {
    selectedMood = mood;
    
    // Update tab styles
    document.querySelectorAll('.mood-tab').forEach(tab => {
        tab.className = 'mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200';
    });
    
    // Set active tab
    const activeTab = document.getElementById(mood + '-tab');
    if (mood === 'hills') {
        activeTab.className = 'mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gradient-to-r from-green-500 to-blue-500 text-white';
    } else if (mood === 'sea') {
        activeTab.className = 'mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gradient-to-r from-blue-500 to-cyan-500 text-white';
    } else if (mood === 'forest') {
        activeTab.className = 'mood-tab px-6 py-3 rounded-full font-semibold transition-all duration-300 bg-gradient-to-r from-green-500 to-emerald-500 text-white';
    }
    
    // Hide all descriptions
    document.querySelectorAll('.mood-description').forEach(desc => {
        desc.classList.add('hidden');
    });
    
    // Show selected description
    document.getElementById(mood + '-description').classList.remove('hidden');
    
    // Hide all destinations
    document.querySelectorAll('.mood-destination').forEach(dest => {
        dest.style.display = 'none';
    });
    
    // Show destinations for selected mood
    document.querySelectorAll(`[data-mood="${mood}"]`).forEach(dest => {
        dest.style.display = 'block';
    });
    
    // Update button text
    const moodLabels = {
        'hills': 'Hill Stations',
        'sea': 'Sea & Beaches', 
        'forest': 'Forests & Wildlife'
    };
    document.getElementById('viewAllMoodBtn').textContent = `View All ${moodLabels[mood]} Destinations`;
}

function exploreDestination(destination) {
    console.log('Exploring destination:', destination.name);
    alert(`Exploring ${destination.name}. This would show detailed information, photo galleries, and travel guides.`);
}

function getMoodQuote(destination) {
    // Navigate to contact form with destination information for quote
    const params = new URLSearchParams({
        destination: destination.name,
        location: destination.location,
        duration: destination.duration,
        mood: destination.mood,
        request: 'quote'
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
