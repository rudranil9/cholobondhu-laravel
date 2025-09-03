@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<!-- Logo Header -->
<div class="text-center mb-8">
    <div class="inline-block relative mb-4 group">
        <div class="w-24 h-24 mx-auto bg-white dark:bg-gray-700 rounded-full shadow-xl overflow-hidden border-2 border-white/50 dark:border-gray-600/50 transition-transform duration-300 group-hover:scale-105 group-hover:shadow-2xl">
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
        <!-- Floating ring animation -->
        <div class="absolute -inset-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full opacity-20 animate-ping"></div>
    </div>
    <h2 class="text-4xl font-bold gradient-text mb-2 animate-fade-in">Join Cholo Bondhu!</h2>
    <p class="text-gray-600 dark:text-gray-400 animate-fade-in" style="animation-delay: 0.2s;">Create your account and start planning amazing trips</p>
</div>

<form action="{{ route('register') }}" method="POST" class="space-y-6" x-data="registerForm()">
    @csrf

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Full Name
        </label>
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg border border-blue-200 dark:border-blue-600">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                required
                autocomplete="name"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your full name"
            />
        </div>
        @error('name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Email Address
        </label>
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg border border-blue-200 dark:border-blue-600">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
            </div>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your email"
            />
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone Number -->
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Phone Number
        </label>
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg border border-blue-200 dark:border-blue-600">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <input 
                id="phone" 
                name="phone" 
                type="tel" 
                value="{{ old('phone') }}" 
                autocomplete="tel"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your phone number"
            />
        </div>
        @error('phone')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Password
        </label>
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg border border-blue-200 dark:border-blue-600">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <input 
                id="password" 
                name="password" 
                type="password" 
                required 
                autocomplete="new-password"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg @error('password') border-red-500 @enderror"
                placeholder="Create a password"
            />
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Confirm Password
        </label>
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg border border-blue-200 dark:border-blue-600">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <input 
                id="password_confirmation" 
                name="password_confirmation" 
                type="password" 
                required 
                autocomplete="new-password"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg @error('password_confirmation') border-red-500 @enderror"
                placeholder="Confirm your password"
            />
        </div>
        @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Terms & Conditions -->
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input 
                id="terms" 
                name="terms" 
                type="checkbox" 
                required
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded transition-all duration-300"
            >
        </div>
        <div class="ml-3 text-sm">
            <label for="terms" class="text-gray-600 dark:text-gray-400">
                I agree to the 
                <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-300">
                    Terms of Service
                </a>
                and 
                <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-300">
                    Privacy Policy
                </a>
            </label>
        </div>
    </div>

    <!-- Error Display -->
    <div id="error-message" class="hidden p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
        <p class="text-sm text-red-600 dark:text-red-400"></p>
    </div>

    <!-- Submit Button -->
    <div>
        <button 
            type="submit"
            @click="submitForm()"
            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-4 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 relative overflow-hidden group border border-blue-500/20"
            :disabled="isSubmitting"
            :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }"
        >
            <!-- Loading Spinner -->
            <div id="loading-spinner" class="hidden absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            <!-- Shimmer effect -->
            <div class="absolute inset-0 -top-px bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 group-hover:animate-pulse"></div>
            
            <!-- Button Content -->
            <span id="button-text" class="relative flex items-center justify-center space-x-2">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span>Create Your Account</span>
            </span>
        </button>
    </div>

    <!-- Login Link -->
    <div class="text-center mt-6">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-300">
                Sign in here
            </a>
        </p>
    </div>
</form>

@push('scripts')
<script>
    function registerForm() {
        return {
            isSubmitting: false,
            
            submitForm() {
                if (this.isSubmitting) return;
                this.isSubmitting = true;
                
                const button = event.target;
                const originalText = button.innerHTML;
                const form = button.closest('form');
                
                button.innerHTML = `
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Creating Account...</span>
                    </span>
                `;
                
                setTimeout(() => {
                    if (this.isSubmitting) {
                        button.innerHTML = originalText;
                        this.isSubmitting = false;
                    }
                }, 5000);
            }
        }
    }
</script>
@endpush

@endsection
