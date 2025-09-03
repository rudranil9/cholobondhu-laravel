@extends('layouts.app')

@section('title', 'About Us - Cholo Bondhu Travel')
@section('description', 'Learn about Cholo Bondhu Travel - your trusted partner for incredible journeys across India and beyond. Expert travel planning since 2015.')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900">
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
                        About 
                        <span class="relative inline-block">
                            <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent">
                                Cholo Bondhu
                            </span>
                            <div class="absolute -bottom-3 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full transform scale-x-0 animate-scale-x"></div>
                        </span>
                    </h1>
                    
                    <!-- Professional Subtitle -->
                    <div class="max-w-4xl mx-auto">
                        <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 leading-relaxed font-light mb-8">
                            Crafting extraordinary travel experiences across India with unmatched expertise, 
                            authentic local connections, and a commitment to sustainable tourism excellence.
                        </p>
                        
                        <!-- Professional Call-to-Action -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium">Trusted by 1,200+ travelers</span>
                            </div>
                            <div class="hidden sm:block w-px h-6 bg-gray-300 dark:bg-gray-600"></div>
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-sm font-medium">8+ years of excellence</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Founder Section -->
    <section class="py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-blue-600 dark:text-blue-400 tracking-wider uppercase bg-blue-50 dark:bg-blue-900/30 px-4 py-2 rounded-full">
                    Leadership
                </span>
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mt-6 mb-4">
                    Meet Our Owner
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Driven by passion for travel and commitment to excellence
                </p>
            </div>

            <!-- Professional Founder Card -->
            <div class="max-w-6xl mx-auto">
                <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-800 dark:to-gray-700 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-600">
                    <div class="flex flex-col">
                        
                        <!-- Professional Content Section -->
                        <div class="w-full p-12 flex flex-col justify-center">
                            <div class="max-w-4xl mx-auto text-center">
                                <!-- Name and Title -->
                                <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
                                    Rukmini Pathak
                                </h3>
                                <p class="text-xl text-blue-600 dark:text-blue-400 font-semibold mb-8">
                                    Owner
                                </p>
                                
                                <!-- Professional Description -->
                                <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                                    Cholo Bondhu is proudly named after Rukmini Pathak. Her values of warmth, hospitality, and genuine care for others form the foundation of our travel company. We are honored to carry forward her spirit of welcoming guests and ensuring their comfort in everything we do.
                                </p>
                                
                                <!-- Company Values -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full mt-3 flex-shrink-0"></div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Hospitality First</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Treating every guest like family</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-green-600 rounded-full mt-3 flex-shrink-0"></div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Genuine Care</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Personal attention to every detail</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-purple-600 rounded-full mt-3 flex-shrink-0"></div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Cultural Respect</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Honoring local traditions and heritage</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-orange-600 rounded-full mt-3 flex-shrink-0"></div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Memorable Experiences</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Creating lasting travel memories</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Professional Quote -->
                                <blockquote class="border-l-4 border-blue-600 pl-6 italic text-gray-700 dark:text-gray-300">
                                    "Travel is not just about visiting places; it's about creating connections, 
                                    understanding cultures, and leaving a positive impact wherever we go."
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour Gallery Carousel Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Our Amazing Tours
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Take a glimpse at the incredible experiences we've crafted for our travelers. Each photo tells a story of adventure, discovery, and unforgettable memories.
                </p>
            </div>

            <!-- Carousel Container -->
            <div class="relative max-w-6xl mx-auto" x-data="tourCarousel()">
                <div class="overflow-hidden rounded-2xl shadow-2xl">
                    <div class="flex transition-transform duration-500 ease-in-out"
                         :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                        
                        <div class="w-full flex-shrink-0 relative">
                            <div class="aspect-video bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                    <div class="absolute inset-0 bg-black/20"></div>
                                    <div class="relative z-10 text-center text-white p-8 max-w-2xl">
                                        <div class="text-6xl mb-6">🏔️</div>
                                        <h3 class="text-4xl font-bold mb-4">Himalayan Adventures</h3>
                                        <p class="text-xl mb-6 opacity-90">Experience the breathtaking beauty of the Himalayas with our carefully curated mountain adventures.</p>
                                        <div class="flex flex-wrap justify-center gap-3">
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Scenic Views</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Adventure Activities</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Cultural Immersion</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Professional Guides</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full flex-shrink-0 relative">
                            <div class="aspect-video bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-teal-600 flex items-center justify-center">
                                    <div class="absolute inset-0 bg-black/20"></div>
                                    <div class="relative z-10 text-center text-white p-8 max-w-2xl">
                                        <div class="text-6xl mb-6">🛶</div>
                                        <h3 class="text-4xl font-bold mb-4">Kerala Backwaters</h3>
                                        <p class="text-xl mb-6 opacity-90">Cruise through the tranquil backwaters of Kerala and discover the rich culture of South India.</p>
                                        <div class="flex flex-wrap justify-center gap-3">
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Houseboat Stay</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Traditional Cuisine</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Wildlife Spotting</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Peaceful Environment</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full flex-shrink-0 relative">
                            <div class="aspect-video bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-orange-400 to-red-600 flex items-center justify-center">
                                    <div class="absolute inset-0 bg-black/20"></div>
                                    <div class="relative z-10 text-center text-white p-8 max-w-2xl">
                                        <div class="text-6xl mb-6">🏰</div>
                                        <h3 class="text-4xl font-bold mb-4">Rajasthan Heritage</h3>
                                        <p class="text-xl mb-6 opacity-90">Explore the royal heritage of Rajasthan with its magnificent palaces and rich cultural traditions.</p>
                                        <div class="flex flex-wrap justify-center gap-3">
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Royal Palaces</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Desert Safari</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Cultural Shows</span>
                                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">Traditional Crafts</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button 
                    @click="previousSlide()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white p-3 rounded-full transition-all duration-300 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button 
                    @click="nextSlide()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white p-3 rounded-full transition-all duration-300 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-6 space-x-2">
                    <template x-for="(tour, index) in tourGallery" :key="index">
                        <button 
                            @click="goToSlide(index)"
                            class="w-3 h-3 rounded-full transition-all duration-300"
                            :class="index === currentSlide ? 'bg-blue-600' : 'bg-gray-300'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Timeline -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Our Story</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    From a simple dream to a thriving travel community
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1 bg-gradient-to-b from-blue-400 via-purple-400 to-green-400 h-full"></div>
                    
                    <!-- Timeline items -->
                    <div class="space-y-16">
                        @php
                        $timeline = [
                            ['year' => '2020', 'title' => 'The Dream Begins', 'description' => 'Cholo Bondhu was born from a simple idea: to make travel more meaningful. We started with a small team of passionate explorers.', 'color' => '#3B82F6'],
                            ['year' => '2021', 'title' => 'First Adventures', 'description' => 'Launched our first tour packages focusing on authentic experiences and sustainable tourism practices.', 'color' => '#8B5CF6'],
                            ['year' => '2022', 'title' => 'Growing Community', 'description' => 'Our community grew, and so did our destinations. We expanded our offerings to include more unique and off-the-beaten-path adventures.', 'color' => '#10B981'],
                            ['year' => '2023', 'title' => 'Innovation & Expansion', 'description' => 'Introduced digital innovations and expanded to cover all major regions of India with specialized tour packages.', 'color' => '#F59E0B'],
                            ['year' => 'Today', 'title' => 'Our Promise', 'description' => 'We continue to innovate and inspire, committed to providing exceptional travel experiences that create lasting memories.', 'color' => '#EF4444']
                        ];
                        @endphp
                        
                        @foreach($timeline as $index => $milestone)
                        <div class="relative flex items-center {{ $index % 2 === 1 ? 'flex-row-reverse' : '' }}">
                            
                            <!-- Timeline marker -->
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full border-4 border-white dark:border-gray-900 shadow-lg z-10"
                                 style="background-color: {{ $milestone['color'] }}">
                            </div>
                            
                            <!-- Content card -->
                            <div class="w-5/12 p-6 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl shadow-xl {{ $index % 2 === 0 ? 'ml-auto' : 'mr-auto' }}">
                                <div class="text-center {{ $index % 2 === 1 ? 'text-right' : '' }}">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $milestone['year'] }}</h3>
                                    <h4 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-3">{{ $milestone['title'] }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $milestone['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission and Vision -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 rounded-2xl shadow-xl text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold mb-6">Our Mission</h3>
                    <p class="text-lg leading-relaxed opacity-90">
                        To craft unique and immersive travel experiences that connect people, cultures, and nature, fostering a deeper understanding of the world and creating lasting memories.
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-8 rounded-2xl shadow-xl text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold mb-6">Our Vision</h3>
                    <p class="text-lg leading-relaxed opacity-90">
                        To be the most trusted and innovative travel community, inspiring people to explore with curiosity, respect, and a sense of adventure while preserving the beauty of our destinations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us - Professional Experience -->
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 relative">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.15) 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Professional Header -->
            <div class="text-center mb-20">
                <div class="inline-block mb-4">
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400 tracking-wider uppercase bg-blue-50 dark:bg-blue-900/30 px-4 py-2 rounded-full">
                        Our Excellence
                    </span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    Why Choose 
                    <span class="relative">
                        Cholo Bondhu
                        <div class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full transform scale-x-0 animate-scale-x"></div>
                    </span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Experience unparalleled service and expertise that sets us apart in the travel industry
                </p>
            </div>
            
            <!-- Professional Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
                @php
                $features = [
                    ['icon' => '🎯', 'title' => 'Expert Planning', 'description' => 'Our seasoned travel consultants meticulously plan every aspect of your journey, ensuring seamless execution and unforgettable experiences from start to finish.'],
                    ['icon' => '🤝', 'title' => 'Local Partnerships', 'description' => 'We collaborate with verified local partners and communities to provide authentic cultural experiences while supporting sustainable tourism development.'],
                    ['icon' => '🌱', 'title' => 'Sustainable Practices', 'description' => 'Committed to responsible tourism, we implement eco-friendly practices that preserve natural environments and benefit local communities for future generations.'],
                    ['icon' => '🏆', 'title' => 'Premium Quality', 'description' => 'Every service is rigorously vetted and maintained to international standards, ensuring exceptional quality, safety, and customer satisfaction throughout your journey.'],
                    ['icon' => '📞', 'title' => 'Concierge Support', 'description' => 'Our dedicated 24/7 concierge team provides immediate assistance, emergency support, and personalized recommendations throughout your travel experience.'],
                    ['icon' => '💰', 'title' => 'Transparent Pricing', 'description' => 'We offer competitive, all-inclusive pricing with no hidden fees, providing exceptional value while maintaining the highest standards of service and comfort.']
                ];
                @endphp
                
                @foreach($features as $index => $feature)
                <div class="group relative animate-fade-in-up" style="animation-delay: {{ $index * 150 }}ms;">
                    
                    <!-- Professional Card Design -->
                    <div class="relative h-full bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-700 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-200 dark:hover:border-blue-600">
                        
                        <!-- Subtle Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Content -->
                        <div class="relative p-8">
                            
                            <!-- Professional Icon -->
                            <div class="mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl flex items-center justify-center transition-all duration-500 group-hover:scale-110 group-hover:rotate-3">
                                    <span class="text-2xl filter drop-shadow-sm">{{ $feature['icon'] }}</span>
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 transition-colors duration-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                {{ $feature['title'] }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6 transition-colors duration-300 group-hover:text-gray-700 dark:group-hover:text-gray-200">
                                {{ $feature['description'] }}
                            </p>
                            
                            <!-- Professional Badge -->
                            <div class="flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-2 group-hover:translate-y-0">
                                <div class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full mr-2"></div>
                                Premium Service
                            </div>
                        </div>
                        
                        <!-- Bottom Border Animation -->
                        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Professional Credentials Section -->
            <div class="relative">
                <!-- Background Blur Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-3xl blur-3xl opacity-30"></div>
                
                <div class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50 p-12">
                    <div class="text-center mb-12">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            Trusted by Travelers Worldwide
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                            Our commitment to excellence is reflected in our growing community of satisfied travelers
                        </p>
                    </div>

                    <!-- Professional Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        @php
                        $stats = [
                            ['value' => '1,200+', 'label' => 'Satisfied Travelers'],
                            ['value' => '75+', 'label' => 'Unique Destinations'],
                            ['value' => '8+', 'label' => 'Years Excellence'],
                            ['value' => '99.2%', 'label' => 'Success Rate']
                        ];
                        @endphp
                        
                        @foreach($stats as $index => $stat)
                        <div class="text-center group" style="animation-delay: {{ $index * 200 }}ms;">
                            <div class="relative mb-4">
                                <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent transition-all duration-500 group-hover:scale-110">
                                    {{ $stat['value'] }}
                                </div>
                                <!-- Animated Underline -->
                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-700"></div>
                            </div>
                            <div class="text-gray-600 dark:text-gray-300 font-medium uppercase tracking-wide text-sm">
                                {{ $stat['label'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Professional Certifications -->
            <div class="mt-20 text-center">
                <div class="inline-flex items-center space-x-8 p-6 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">ISO Certified</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">4.9★ Rated</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Verified Partner</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    // Alpine.js component for tour carousel
    function tourCarousel() {
        return {
            currentSlide: 0,
            slideInterval: null,
            tourGallery: [
                {
                    title: 'Himalayan Adventures',
                    subtitle: 'Majestic Mountain Experiences',
                    description: 'Experience the breathtaking beauty of the Himalayas with our carefully curated mountain adventures.',
                    icon: '🏔️',
                    highlights: ['Scenic Views', 'Adventure Activities', 'Cultural Immersion', 'Professional Guides']
                },
                {
                    title: 'Kerala Backwaters',
                    subtitle: 'Serene Water Journeys',
                    description: 'Cruise through the tranquil backwaters of Kerala and discover the rich culture of South India.',
                    icon: '🛶',
                    highlights: ['Houseboat Stay', 'Traditional Cuisine', 'Wildlife Spotting', 'Peaceful Environment']
                },
                {
                    title: 'Rajasthan Heritage',
                    subtitle: 'Royal Cultural Tours',
                    description: 'Explore the royal heritage of Rajasthan with its magnificent palaces and rich cultural traditions.',
                    icon: '🏰',
                    highlights: ['Royal Palaces', 'Desert Safari', 'Cultural Shows', 'Traditional Crafts']
                },
                {
                    title: 'Goa Beach Bliss',
                    subtitle: 'Tropical Paradise',
                    description: 'Relax on pristine beaches and enjoy the vibrant nightlife of Goa.',
                    icon: '🏖️',
                    highlights: ['Beach Activities', 'Water Sports', 'Nightlife', 'Portuguese Heritage']
                },
                {
                    title: 'Darjeeling Tea Gardens',
                    subtitle: 'Hill Station Retreat',
                    description: 'Discover the famous tea gardens and enjoy panoramic views of the Kanchenjunga.',
                    icon: '🍃',
                    highlights: ['Tea Plantation Tours', 'Mountain Views', 'Toy Train Ride', 'Local Culture']
                }
            ],
            
            init() {
                this.startSlideshow();
            },
            
            startSlideshow() {
                this.slideInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            },
            
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.tourGallery.length;
            },
            
            previousSlide() {
                this.currentSlide = this.currentSlide === 0 ? this.tourGallery.length - 1 : this.currentSlide - 1;
            },
            
            goToSlide(index) {
                this.currentSlide = index;
                if (this.slideInterval) {
                    clearInterval(this.slideInterval);
                    this.startSlideshow();
                }
            }
        }
    }
</script>

<style>
    /* Professional Animations */
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

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    /* Staggered Animation for Grid Items */
    .group:nth-child(1) { 
        animation: fadeInUp 0.8s ease-out 0.1s both; 
    }
    .group:nth-child(2) { 
        animation: fadeInUp 0.8s ease-out 0.2s both; 
    }
    .group:nth-child(3) { 
        animation: fadeInUp 0.8s ease-out 0.3s both; 
    }
    .group:nth-child(4) { 
        animation: fadeInUp 0.8s ease-out 0.4s both; 
    }
    .group:nth-child(5) { 
        animation: fadeInUp 0.8s ease-out 0.5s both; 
    }
    .group:nth-child(6) { 
        animation: fadeInUp 0.8s ease-out 0.6s both; 
    }

    /* Professional Hover Effects */
    .backdrop-blur-xl {
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    /* Smooth Gradient Transitions */
    .bg-gradient-to-r {
        background-size: 200% 200%;
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Professional Shadow Effects */
    .shadow-professional {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                    0 2px 4px -1px rgba(0, 0, 0, 0.06),
                    0 0 0 1px rgba(0, 0, 0, 0.05);
    }

    .shadow-professional:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                    0 10px 10px -5px rgba(0, 0, 0, 0.04),
                    0 0 0 1px rgba(59, 130, 246, 0.1);
    }

    /* Professional Transitions */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush
