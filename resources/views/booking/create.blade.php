@extends('layouts.app')

@section('title', 'Book Your Trip - Cholo Bondhu')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-block relative mb-6">
                <div class="w-24 h-24 mx-auto bg-white dark:bg-gray-700 rounded-full shadow-lg overflow-hidden border-2 border-gray-100 dark:border-gray-600 transform hover:scale-105 transition-all duration-500">
                    <img 
                        src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                        alt="Cholo Bondhu Logo" 
                        class="w-full h-full object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    />
                    <div class="w-full h-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-2xl" style="display: none;">
                        CB
                    </div>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 animate-slide-up">
                Book Your Dream Trip
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.2s;">
                Fill in the details below and we'll create your perfect travel experience
            </p>
            
            @if(isset($autoFillData) && !empty($autoFillData))
            <div class="mt-6 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">📦 Selected Package</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    @if(isset($autoFillData['package_name']))
                    <div class="text-center">
                        <span class="text-gray-600 dark:text-gray-400">Package</span>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $autoFillData['package_name'] }}</p>
                    </div>
                    @endif
                    @if(isset($autoFillData['destination']))
                    <div class="text-center">
                        <span class="text-gray-600 dark:text-gray-400">Destination</span>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $autoFillData['destination'] }}</p>
                    </div>
                    @endif
                    @if(isset($autoFillData['price']))
                    <div class="text-center">
                        <span class="text-gray-600 dark:text-gray-400">Price</span>
                        <p class="font-semibold text-green-600 dark:text-green-400">₹{{ number_format($autoFillData['price']) }}</p>
                    </div>
                    @endif
                    @if(isset($autoFillData['duration']))
                    <div class="text-center">
                        <span class="text-gray-600 dark:text-gray-400">Duration</span>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $autoFillData['duration'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Booking Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6">
                <h2 class="text-2xl font-bold text-white mb-2">🎯 Booking Information</h2>
                <p class="text-blue-100">Please provide your travel details</p>
            </div>

            <form method="POST" action="{{ route('booking.store') }}" class="p-6 space-y-6">
                @csrf
                
                <!-- Hidden fields for auto-fill data -->
                @if(isset($autoFillData))
                    @if(isset($autoFillData['package_name']))
                        <input type="hidden" name="package_name" value="{{ $autoFillData['package_name'] }}">
                    @endif
                    @if(isset($autoFillData['price']))
                        <input type="hidden" name="package_price" value="{{ $autoFillData['price'] }}">
                    @endif
                    @if(isset($autoFillData['duration']))
                        <input type="hidden" name="package_duration" value="{{ $autoFillData['duration'] }}">
                    @endif
                    @if(isset($autoFillData['package_type']))
                        <input type="hidden" name="package_type" value="{{ $autoFillData['package_type'] }}">
                    @endif
                @endif

                <!-- Customer Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div class="animate-slide-up" style="animation-delay: 0.1s;">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Full Name *
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input 
                                id="customer_name" 
                                name="customer_name" 
                                type="text" 
                                value="{{ old('customer_name', auth()->user()->name ?? '') }}" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300"
                                placeholder="Enter your full name"
                            />
                        </div>
                        @error('customer_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="animate-slide-up" style="animation-delay: 0.2s;">
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address *
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input 
                                id="customer_email" 
                                name="customer_email" 
                                type="email" 
                                value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300"
                                placeholder="Enter your email"
                            />
                        </div>
                        @error('customer_email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="animate-slide-up" style="animation-delay: 0.3s;">
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number *
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input 
                                id="customer_phone" 
                                name="customer_phone" 
                                type="tel" 
                                value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300"
                                placeholder="Enter your phone number"
                            />
                        </div>
                        @error('customer_phone')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination -->
                    <div class="animate-slide-up" style="animation-delay: 0.4s;">
                        <label for="destination" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Destination *
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <input 
                                id="destination" 
                                name="destination" 
                                type="text" 
                                value="{{ old('destination', $autoFillData['destination'] ?? '') }}" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300"
                                placeholder="Where do you want to go?"
                            />
                        </div>
                        @error('destination')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Travel Dates -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Start Date -->
                    <div class="animate-slide-up" style="animation-delay: 0.5s;">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Start Date
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input 
                                id="start_date" 
                                name="start_date" 
                                type="date" 
                                value="{{ old('start_date') }}" 
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300"
                            />
                        </div>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="animate-slide-up" style="animation-delay: 0.6s;">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            End Date (Optional)
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input 
                                id="end_date" 
                                name="end_date" 
                                type="date" 
                                value="{{ old('end_date') }}"
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300"
                            />
                        </div>
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Number of Travelers -->
                    <div class="animate-slide-up" style="animation-delay: 0.7s;">
                        <label for="number_of_travelers" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Travelers *
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <input 
                                id="number_of_travelers" 
                                name="number_of_travelers" 
                                type="number" 
                                value="{{ old('number_of_travelers', 1) }}" 
                                required 
                                min="1" 
                                max="50"
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300"
                                placeholder="Number of travelers"
                            />
                        </div>
                        @error('number_of_travelers')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Budget Range -->
                <div class="animate-slide-up" style="animation-delay: 0.8s;">
                    <label for="budget_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Budget Range (Optional)
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <select 
                            id="budget_range" 
                            name="budget_range"
                            class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300"
                        >
                            <option value="">Select your budget range</option>
                            <option value="₹10,000 - ₹25,000" {{ old('budget_range') == '₹10,000 - ₹25,000' ? 'selected' : '' }}>₹10,000 - ₹25,000</option>
                            <option value="₹25,000 - ₹50,000" {{ old('budget_range') == '₹25,000 - ₹50,000' ? 'selected' : '' }}>₹25,000 - ₹50,000</option>
                            <option value="₹50,000 - ₹1,00,000" {{ old('budget_range') == '₹50,000 - ₹1,00,000' ? 'selected' : '' }}>₹50,000 - ₹1,00,000</option>
                            <option value="₹1,00,000+" {{ old('budget_range') == '₹1,00,000+' ? 'selected' : '' }}>₹1,00,000+</option>
                        </select>
                    </div>
                    @error('budget_range')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Special Requirements -->
                <div class="animate-slide-up" style="animation-delay: 0.9s;">
                    <label for="special_requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Special Requirements (Optional)
                    </label>
                    <div class="relative group">
                        <textarea 
                            id="special_requirements" 
                            name="special_requirements" 
                            rows="4"
                            class="block w-full px-3 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300 resize-none"
                            placeholder="Any special requirements, dietary restrictions, accessibility needs, etc."
                        >{{ old('special_requirements') }}</textarea>
                    </div>
                    @error('special_requirements')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="animate-slide-up" style="animation-delay: 1.1s;">
                    <button 
                        type="submit" 
                        class="group relative w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 hover:shadow-xl font-semibold text-lg overflow-hidden"
                    >
                        <!-- Button Background Animation -->
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Button Content -->
                        <span class="relative flex items-center justify-center space-x-2">
                            <svg class="w-6 h-6 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Book Now - Get Your Ticket</span>
                        </span>
                        
                        <!-- Ripple Effect -->
                        <div class="absolute inset-0 opacity-0 group-active:opacity-20 group-active:animate-ping bg-white rounded-xl"></div>
                    </button>
                </div>

                <!-- Security Notice -->
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 animate-slide-up" style="animation-delay: 1.2s;">
                    🔒 Your information is secure and will only be used for booking purposes
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Popup Modal -->
@if(session('show_popup') && session('success') && session('ticket_number'))
<div id="successPopup" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full shadow-2xl animate-bounce-in">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-green-500 to-blue-500 text-white p-6 rounded-t-2xl text-center">
            <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-full shadow-lg overflow-hidden">
                <img 
                    src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                    alt="Cholo Bondhu Logo" 
                    class="w-full h-full object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div class="w-full h-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-xl" style="display: none;">
                    CB
                </div>
            </div>
            <div class="text-6xl mb-3">🎉</div>
            <h2 class="text-2xl font-bold mb-2">Booking Successful!</h2>
            <p class="text-green-100">Your dream trip request has been submitted</p>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
            <!-- Ticket Number Display -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg p-4 mb-6 text-center">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">🎫 Your Ticket Number</h3>
                <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border-2 border-dashed border-blue-300 dark:border-blue-600">
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 font-mono tracking-wider">{{ session('ticket_number') }}</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Save this number for your records</p>
            </div>

            <!-- Success Message -->
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</span>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="space-y-3 mb-6">
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">📧 Admin Notification</span>
                    <span class="text-green-600 dark:text-green-400 font-semibold">Sent ✓</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">📞 Contact Within</span>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold">24 Hours</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 dark:text-gray-400">📱 WhatsApp Support</span>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold">+91 8100282665</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button 
                    onclick="viewMyBookings()"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-medium"
                >
                    📋 View My Bookings
                </button>
                <button 
                    onclick="closeSuccessPopup()"
                    class="w-full px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 font-medium"
                >
                    Continue Browsing
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // Success popup functions
    function viewMyBookings() {
        window.location.href = '{{ route("booking.my-bookings") }}';
    }
    
    function closeSuccessPopup() {
        document.getElementById('successPopup').style.display = 'none';
    }
    
    // Auto-close popup after 30 seconds
    @if(session('show_popup'))
    setTimeout(function() {
        const popup = document.getElementById('successPopup');
        if (popup) {
            popup.style.opacity = '0';
            popup.style.transform = 'scale(0.9)';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 300);
        }
    }, 30000);
    @endif
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes bounce-in {
        0% { opacity: 0; transform: scale(0.3) translateY(-50px); }
        50% { opacity: 1; transform: scale(1.05) translateY(0); }
        70% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-bounce-in {
        animation: bounce-in 0.6s ease-out forwards;
    }
</style>

@endsection