<section id="about" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div>
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    About Cholo Bondhu
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                    We are passionate travel enthusiasts dedicated to creating extraordinary experiences for our fellow travelers. 
                    Since our inception, we've been committed to providing authentic, sustainable, and memorable journeys.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    Our team of experienced travel experts understands that every journey is unique. We pride ourselves on 
                    authentic local connections, and a commitment to sustainable tourism excellence.
                </p>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">500+</div>
                        <div class="text-sm text-gray-600 dark:text-gray-300">Happy Customers</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">100+</div>
                        <div class="text-sm text-gray-600 dark:text-gray-300">Destinations</div>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Learn More About Us
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Image -->
            <div class="relative">
                <div class="aspect-w-4 aspect-h-3 rounded-2xl overflow-hidden shadow-2xl">
                    <img 
                        src="{{ asset('assets/riman-pathak.jpg') }}" 
                        alt="Cholo Bondhu Team" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-500 rounded-full opacity-20"></div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-purple-500 rounded-full opacity-20"></div>
            </div>
        </div>
    </div>
</section>
