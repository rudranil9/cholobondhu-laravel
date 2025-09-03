@extends('layouts.auth')

@section('title', 'Verify Registration')

@section('content')
<!-- Logo Header -->
<div class="text-center mb-8 animate-fade-in">
    <div class="inline-block relative mb-4">
        <div class="w-20 h-20 mx-auto bg-white dark:bg-gray-700 rounded-full shadow-lg overflow-hidden border-2 border-gray-100 dark:border-gray-600 transform hover:scale-105 transition-all duration-500 ease-out">
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
    </div>
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 animate-slide-up">Verify Your Email</h2>
    <p class="text-gray-600 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.2s;">Enter the 6-digit code sent to your email</p>
</div>

<!-- Email Display -->
<div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 animate-slide-up" style="animation-delay: 0.3s;">
    <div class="flex items-center space-x-3">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">OTP sent to:</p>
            <p class="text-sm text-blue-700 dark:text-blue-300" id="user-email">{{ session('registration_email') ?? $email ?? 'your-email@example.com' }}</p>
        </div>
    </div>
</div>

<!-- OTP Form -->
<form action="{{ route('verify.registration.post') }}" method="POST" id="verify-registration-form" class="space-y-6">
    @csrf

    <!-- Email (hidden field) -->
    <input type="hidden" name="email" value="{{ session('registration_email') ?? $email ?? '' }}">

    <!-- OTP Input -->
    <div class="animate-slide-up" style="animation-delay: 0.4s;">
        <label for="otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4 text-center">
            Enter 6-Digit Verification Code
        </label>

        <!-- Single OTP Input -->
        <div class="flex justify-center mb-4">
            <input
                type="text"
                name="otp"
                id="otp"
                maxlength="6"
                pattern="[0-9]{6}"
                class="w-48 h-12 text-center text-xl font-mono font-bold border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 transition-all duration-300 @error('otp') border-red-500 @enderror"
                placeholder="000000"
                required
                autofocus
            >
        </div>
        
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <ul class="text-sm text-red-600 dark:text-red-400 text-center">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-600 dark:text-green-400 text-center">{{ session('success') }}</p>
            </div>
        @endif
        
        <!-- Error Display -->
        <div id="error-message" class="hidden mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <p class="text-sm text-red-600 dark:text-red-400 text-center"></p>
        </div>
    </div>


    <!-- Verification Information -->
    <div class="animate-slide-up text-xs text-gray-500 dark:text-gray-400" style="animation-delay: 0.5s;">
        <p class="font-medium mb-1">Verification Code Information:</p>
        <ul class="space-y-1 ml-4 list-disc">
            <li>Any code received in the last 10 minutes is valid</li>
            <li>Each code can only be used once</li>
            <li>You can request multiple codes if needed</li>
        </ul>
    </div>

    <!-- Submit Button -->
    <div class="animate-slide-up" style="animation-delay: 0.6s;">
        <button 
            type="submit"
            class="group relative w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-4 rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 hover:shadow-xl font-semibold text-lg"
        >
            <!-- Loading Spinner -->
            <div id="loading-spinner" class="hidden absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            <!-- Button Content -->
            <span id="button-text" class="relative flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Verify & Complete Registration</span>
            </span>
        </button>
    </div>

    <!-- Resend OTP Section (Separate Form) -->
    <div class="text-center animate-slide-up mt-6" style="animation-delay: 0.7s;">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Didn't receive the code?</p>
        <form action="{{ route('auth.resend-otp') }}" method="POST" class="inline-block">
            @csrf
            <input type="hidden" name="email" value="{{ session('registration_email') ?? $email ?? '' }}">
            <input type="hidden" name="type" value="registration">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 font-medium transition-all duration-300 border border-green-200 dark:border-green-800">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                </svg>
                Send OTP Again
            </button>
        </form>
        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
            <span>or </span>
            <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-300 underline">
                Start over
            </a>
        </div>
    </div>

    <!-- Back to Registration -->
    <div class="text-center mt-6 animate-slide-up" style="animation-delay: 0.8s;">
        <a href="{{ route('register') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">
            ← Back to Registration
        </a>
    </div>
</form>


<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out forwards;
        opacity: 0;
    }
    
    /* OTP Input Styling */
    .otp-input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: scale(1.05);
    }
    
    .otp-input {
        transition: all 0.2s ease;
    }
    
    /* Professional transitions */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>



@endsection
