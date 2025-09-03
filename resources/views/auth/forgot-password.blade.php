@extends('layouts.auth')

@section('title', 'Forgot Password')

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
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 animate-slide-up">Reset Password</h2>
    <p class="text-gray-600 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.2s;">Enter your email to receive a verification code</p>
</div>

<!-- Information Notice -->
<div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 animate-slide-up" style="animation-delay: 0.3s;">
    <div class="flex items-start space-x-3">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-1">Password Reset</h4>
            <p class="text-sm text-blue-700 dark:text-blue-300">We'll send a 6-digit verification code to your email address to reset your password securely.</p>
        </div>
    </div>
</div>

<form action="{{ route('password.email') }}" method="POST" id="forgot-password-form" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div class="animate-slide-up" style="animation-delay: 0.4s;">
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Email Address
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 text-gray-400 group-focus-within:text-blue-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
            </div>
            <input 
                id="email" 
                name="email" 
                type="email" 
                required 
                autofocus
                autocomplete="email"
                value="{{ old('email') }}"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg @error('email') border-red-500 @enderror"
                placeholder="Enter your email address"
            />
        </div>
    </div>

    <!-- Error Display -->
    @if ($errors->any())
        <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg animate-slide-up">
            <ul class="text-sm text-red-600 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('status'))
        <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg animate-slide-up">
            <p class="text-sm text-green-600 dark:text-green-400">{{ session('status') }}</p>
        </div>
    @endif

    <div id="error-message" class="hidden p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg animate-slide-up">
        <p class="text-sm text-red-600 dark:text-red-400"></p>
    </div>

    <!-- Submit Button -->
    <div class="animate-slide-up" style="animation-delay: 0.5s;">
        <button 
            type="submit" 
            id="submit-btn"
            class="group relative w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-4 rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 hover:shadow-xl font-semibold text-lg overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span>Send Reset Code</span>
            </span>
        </button>
    </div>

    <!-- Back to Login -->
    <div class="text-center mt-6 animate-slide-up" style="animation-delay: 0.6s;">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-300">
                Sign in here
            </a>
        </p>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgot-password-form');
    const submitBtn = document.getElementById('submit-btn');
    const loadingSpinner = document.getElementById('loading-spinner');
    const buttonText = document.getElementById('button-text');
    
    // Form submission
    form.addEventListener('submit', function(e) {
        const email = form.querySelector('input[name="email"]').value;
        
        if (!email) {
            e.preventDefault();
            showError('Please enter your email address');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.classList.remove('hidden');
        buttonText.classList.add('opacity-0');
    });
    
    function showError(message) {
        const errorMessage = document.getElementById('error-message');
        errorMessage.classList.remove('hidden');
        errorMessage.querySelector('p').textContent = message;
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
});
</script>
@endpush

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
    
    /* Enhanced input focus effects */
    input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    
    /* Professional transitions */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

@endsection
