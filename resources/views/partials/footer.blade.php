<footer class="py-12 mt-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                        <img 
                            src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                            alt="Cholo Bondhu Logo" 
                            class="w-full h-full object-contain"
                        />
                    </div>
                    <span class="text-xl font-bold">Cholo Bondhu</span>
                </div>
                <p class="text-gray-400 mb-4 max-w-md">
                    Your trusted travel companion for exploring incredible destinations across India and beyond. 
                    Creating memories that last a lifetime.
                </p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/CholoBondhuTravelAgency" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                        <span class="text-xl">📘</span>
                    </a>
                    <a href="https://instagram.com/cholobondhutourandtravels" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                        <span class="text-xl">📷</span>
                    </a>
                    <a href="https://wa.me/918100282665" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                        <span class="text-xl">💬</span>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('tour-packages') }}" class="text-gray-400 hover:text-white transition-colors">Tour Packages</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Services</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>Custom Tour Planning</li>
                    <li>Group Bookings</li>
                    <li>Adventure Tours</li>
                    <li>Cultural Experiences</li>
                    <li>Family Packages</li>
                </ul>
            </div>
        </div>

        <!-- Contact Info Row -->
        <div class="mt-8 pt-8 border-t border-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="flex items-center space-x-3">
                    <span class="text-xl">📞</span>
                    <div>
                        <p class="font-semibold">Phone</p>
                        <p class="text-gray-400">+91 81002 82665</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xl">✉️</span>
                    <div>
                        <p class="font-semibold">Email</p>
                        <p class="text-gray-400">cholobondhutour@gmail.com</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xl">📍</span>
                    <div>
                        <p class="font-semibold">Address</p>
                        <p class="text-gray-400">Bagnan, Howrah 711303</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Cholo Bondhu Tour & Travels. All rights reserved.</p>
            <p class="mt-2 text-sm">Made with ❤️ for travelers by travelers</p>
        </div>
    </div>
</footer>
