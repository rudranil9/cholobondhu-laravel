@extends('layouts.auth')

@section('title', 'Login - Cholo Bondhu')

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
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 animate-slide-up">Welcome Back!</h2>
    <p class="text-gray-600 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.2s;">Sign in to your account to continue your journey</p>
    
    <!-- Progress indicator -->
    <div class="mt-4 flex justify-center space-x-2">
        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
        <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
    </div>
</div>

<!-- Session Status -->
@if (session('success'))
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-3 rounded-lg">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login.post') }}" class="space-y-6" x-data="loginForm()">
    @csrf

    <!-- Email Address -->
    <div class="animate-slide-up" style="animation-delay: 0.3s;">
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Email Address
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300" :class="emailFocused ? 'text-blue-500' : 'text-gray-400'">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
            </div>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                @focus="emailFocused = true"
                @blur="emailFocused = false"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your email"
            />
            <!-- Focus indicator -->
            <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-shake">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="animate-slide-up" style="animation-delay: 0.4s;">
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Password
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300" :class="passwordFocused ? 'text-blue-500' : 'text-gray-400'">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <input 
                id="password" 
                name="password" 
                x-bind:type="showPassword ? 'text' : 'password'"
                required 
                autocomplete="current-password"
                @focus="passwordFocused = true"
                @blur="passwordFocused = false"
                class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your password"
            />
            <!-- Password visibility toggle -->
            <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                :aria-label="showPassword ? 'Hide password' : 'Show password'"
            >
                <svg x-show="!showPassword" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                </svg>
            </button>
            <!-- Focus indicator -->
            <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-shake">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between animate-slide-up" style="animation-delay: 0.5s;">
        <label for="remember_me" class="flex items-center group cursor-pointer">
            <input 
                id="remember_me" 
                type="checkbox" 
                name="remember" 
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded transition-all duration-300"
            >
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors duration-300">Remember me</span>
        </label>
        
        <a 
            href="{{ route('password.request') }}" 
            class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-300"
        >
            Forgot password?
        </a>
    </div>

    <!-- Submit Button -->
    <div class="animate-slide-up" style="animation-delay: 0.6s;">
        <button 
            type="submit" 
            @click="submitForm()"
            class="group relative w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-4 rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 hover:shadow-xl font-semibold text-lg overflow-hidden"
        >
            <!-- Button Background Animation -->
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <!-- Button Content -->
            <span class="relative flex items-center justify-center space-x-2">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span>Sign In to Your Account</span>
            </span>
            
            <!-- Ripple Effect -->
            <div class="absolute inset-0 opacity-0 group-active:opacity-20 group-active:animate-ping bg-white rounded-xl"></div>
        </button>
    </div>

    <!-- Register Link -->
    <div class="text-center mt-6 animate-slide-up" style="animation-delay: 0.7s;">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-300">
                Create one now
            </a>
        </p>
    </div>
</form>

@push('scripts')
<script>
    function loginForm() {
        return {
            emailFocused: false,
            passwordFocused: false,
            showPassword: false,
            
            togglePasswordVisibility() {
                this.showPassword = !this.showPassword;
            },
            
            submitForm() {
                // Add loading state animation
                const button = event.target;
                const originalText = button.innerHTML;
                
                button.innerHTML = `
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Signing In...</span>
                    </span>
                `;
                
                button.disabled = true;
                
                // Restore original state after a delay (in case of validation errors)
                setTimeout(() => {
                    if (button) {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                }, 3000);
            }
        }
    }
</script>

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
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
    
    /* Enhanced input focus effects */
    input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    
    /* Ripple effect for buttons */
    .group:active .group-active\:animate-ping {
        animation: ping 0.5s cubic-bezier(0, 0, 0.2, 1);
    }
</style>
@endpush
@endsection
