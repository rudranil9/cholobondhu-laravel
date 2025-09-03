@php
$features = [
    [
        'icon' => '🛡️',
        'title' => 'Trusted & Secure',
        'description' => 'Your safety is our priority. We ensure secure bookings, trusted accommodations, and 24/7 support during your journey.'
    ],
    [
        'icon' => '🎯',
        'title' => 'Expert Planning',
        'description' => 'Our travel experts craft personalized itineraries based on your preferences, budget, and interests.'
    ],
    [
        'icon' => '🏆',
        'title' => 'Best Price Guarantee',
        'description' => 'We offer competitive pricing and value-packed packages without compromising on quality and service.'
    ],
    [
        'icon' => '🌟',
        'title' => 'Authentic Experiences',
        'description' => 'Deep local knowledge and connections ensure authentic experiences and insider access to hidden gems.'
    ]
];

$testimonials = [
    [
        'name' => 'Dibyendu Kumar',
        'location' => 'Kolkata',
        'rating' => 5,
        'text' => 'Amazing Darjeeling trip! Professional service, great accommodations, and unforgettable mountain views. Highly recommend Cholo Bondhu for hill station tours.',
        'image' => 'assets/testimonials/dibyendu-kumar.jpg'
    ],
    [
        'name' => 'Pathika Ray Bhattacharya',
        'location' => 'Howrah',
        'rating' => 5,
        'text' => 'Excellent Sikkim package! Well-organized itinerary, comfortable stay, and breathtaking landscapes. The team was very supportive throughout.',
        'image' => 'assets/testimonials/pathika-ray-bhattacharya.jpg'
    ],
    [
        'name' => 'Shaoni Dasbose',
        'location' => 'Kolkata',
        'rating' => 5,
        'text' => 'Fantastic Goa vacation! Great hotel recommendations, smooth transfers, and excellent customer service. Will definitely book again with Cholo Bondhu.',
        'image' => 'assets/testimonials/shaoni-dasbose.jpg'
    ]
];
@endphp

<section id="why-choose-us" class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Why Choose Cholo Bondhu?
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                With years of experience and thousands of happy travelers, we're your trusted partner for unforgettable journeys
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
            @foreach($features as $feature)
            <div class="text-center group">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                    {{ $feature['icon'] }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Testimonials Section -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 lg:p-12">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    What Our Travelers Say
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Real experiences from real travelers
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 relative">
                    <!-- Rating Stars -->
                    <div class="flex items-center mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-yellow-400 text-lg">⭐</span>
                        @endfor
                    </div>

                    <!-- Testimonial Text -->
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "{{ $testimonial['text'] }}"
                    </p>

                    <!-- Author -->
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                            <img 
                                src="{{ asset($testimonial['image']) }}" 
                                alt="{{ $testimonial['name'] }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $testimonial['name'] }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $testimonial['location'] }}</p>
                        </div>
                    </div>

                    <!-- Quote Mark -->
                    <div class="absolute top-4 right-6 text-4xl text-blue-200 dark:text-blue-800">"</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
