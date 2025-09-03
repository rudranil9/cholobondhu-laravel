@extends('layouts.auth')

@section('title', 'Register')

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
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 animate-slide-up">Join Cholo Bondhu!</h2>
    <p class="text-gray-600 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.2s;">Create your account and start planning amazing trips</p>
    
    <!-- Progress indicator -->
    <div class="mt-4 flex justify-center space-x-2">
        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
        <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
    </div>
</div>


<form id="secure-register-form" class="space-y-6">
    @csrf

    <!-- Name -->
    <div class="animate-slide-up" style="animation-delay: 0.4s;">
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Full Name
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 text-gray-400 group-focus-within:text-blue-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <input 
                id="name" 
                name="name" 
                type="text" 
                required 
                autofocus 
                autocomplete="name"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your full name"
            />
        </div>
    </div>

    <!-- Email Address -->
    <div class="animate-slide-up" style="animation-delay: 0.5s;">
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
                autocomplete="username"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your email"
            />
        </div>
    </div>

    <!-- Phone Number -->
    <div class="animate-slide-up" style="animation-delay: 0.6s;">
        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Phone Number
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 text-gray-400 group-focus-within:text-blue-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <input 
                id="phone" 
                name="phone" 
                type="tel" 
                autocomplete="tel"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your phone number"
            />
        </div>
    </div>

    <!-- Password -->
    <div class="animate-slide-up" style="animation-delay: 0.7s;">
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Password
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 text-gray-400 group-focus-within:text-blue-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <input 
                id="password" 
                name="password" 
                type="password" 
                required 
                autocomplete="new-password"
                class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Create a strong password"
            />
            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <svg id="eye-closed" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                </svg>
                <svg id="eye-open" class="hidden h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
        </div>
        
    </div>

    <!-- Confirm Password -->
    <div class="animate-slide-up" style="animation-delay: 0.8s;">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Confirm Password
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 text-gray-400 group-focus-within:text-blue-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <input 
                id="password_confirmation" 
                name="password_confirmation" 
                type="password" 
                required 
                autocomplete="new-password"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Confirm your password"
            />
        </div>
        <div id="password-match" class="mt-1 text-xs hidden">
            <span id="match-text"></span>
        </div>
    </div>

    <!-- Error Display -->
    <div id="error-message" class="hidden p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg animate-slide-up">
        <p class="text-sm text-red-600 dark:text-red-400"></p>
    </div>

    <!-- Submit Button -->
    <div class="animate-slide-up" style="animation-delay: 0.9s;">
        <button 
            type="submit" 
            id="register-btn"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
                <span>Create Account</span>
            </span>
        </button>
    </div>

    <!-- Login Link -->
    <div class="text-center mt-6 animate-slide-up" style="animation-delay: 1.0s;">
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
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing registration form...');
    
    const form = document.getElementById('secure-register-form');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('toggle-password');
    const eyeClosed = document.getElementById('eye-closed');
    const eyeOpen = document.getElementById('eye-open');
    const registerBtn = document.getElementById('register-btn');
    const loadingSpinner = document.getElementById('loading-spinner');
    const buttonText = document.getElementById('button-text');
    const errorMessage = document.getElementById('error-message');
    
    // Check if all elements are found
    console.log('Form found:', form);
    console.log('Register button found:', registerBtn);
    
    if (!form) {
        console.error('Form not found!');
        return;
    }
    
    // Password visibility toggle
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        eyeClosed.classList.toggle('hidden');
        eyeOpen.classList.toggle('hidden');
    });
    
    // Password match checker
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const matchElement = document.getElementById('password-match');
        const matchText = document.getElementById('match-text');
        
        if (confirmPassword.length > 0) {
            matchElement.classList.remove('hidden');
            
            if (password === confirmPassword) {
                matchText.textContent = '✓ Passwords match';
                matchText.className = 'text-green-600 dark:text-green-400';
            } else {
                matchText.textContent = '✗ Passwords do not match';
                matchText.className = 'text-red-600 dark:text-red-400';
            }
        } else {
            matchElement.classList.add('hidden');
        }
    }
    
    // Form submission
    form.addEventListener('submit', async function(e) {
        console.log('Form submission event triggered!');
        
        // Prevent default form submission
        e.preventDefault();
        e.stopPropagation();
        console.log('preventDefault and stopPropagation called');
        
        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            console.log('Form data collected:', { 
                name: data.name,
                email: data.email,
                phone: data.phone,
                passwordLength: data.password ? data.password.length : 0,
                confirmPasswordLength: data.password_confirmation ? data.password_confirmation.length : 0
            });
            
            // Clear any previous error messages
            hideError();
            
            // Simple password validation - minimum 6 characters
            if (!data.password || data.password.length < 6) {
                console.log('Password validation failed: too short');
                showError('Password must be at least 6 characters long');
                return;
            }
            
            if (data.password !== data.password_confirmation) {
                console.log('Password validation failed: passwords do not match');
                showError('Passwords do not match');
                return;
            }
            
            console.log('Password validation passed');
            
            // Show loading state
            console.log('Setting loading state...');
            registerBtn.disabled = true;
            loadingSpinner.classList.remove('hidden');
            buttonText.classList.add('opacity-0');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF token found:', csrfToken ? 'yes' : 'no');
            
            if (!csrfToken) {
                console.error('CSRF token not found!');
                showError('Security token missing. Please refresh the page.');
                return;
            }
            
            console.log('Making API request to /api/auth/register/initiate...');
            
            const response = await fetch('/api/auth/register/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            
            console.log('Response received:', {
                status: response.status,
                statusText: response.statusText,
                ok: response.ok
            });
            
            const result = await response.json();
            console.log('Response data:', result);
            
            if (response.ok && result.success) {
                console.log('Registration initiation successful');
                // Store email in session and redirect to verification
                sessionStorage.setItem('registration_email', data.email);
                console.log('Redirecting to /verify-registration');
                window.location.href = '/verify-registration';
            } else {
                console.log('Registration failed:', result);
                showError(result.message || 'Registration failed. Please try again.');
                
                if (result.errors) {
                    console.log('Validation errors:', result.errors);
                    const firstError = Object.values(result.errors)[0];
                    if (Array.isArray(firstError)) {
                        showError(firstError[0]);
                    }
                }
            }
            
        } catch (error) {
            console.error('Error during form submission:', error);
            showError('Network error. Please check your connection and try again.');
        } finally {
            // Hide loading state
            console.log('Resetting form state...');
            if (loadingSpinner) loadingSpinner.classList.add('hidden');
            if (buttonText) buttonText.classList.remove('opacity-0');
            if (registerBtn) registerBtn.disabled = false;
        }
    });
    
    function showError(message) {
        console.log('Showing error:', message);
        errorMessage.classList.remove('hidden');
        errorMessage.querySelector('p').textContent = message;
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    function hideError() {
        console.log('Hiding error message');
        errorMessage.classList.add('hidden');
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