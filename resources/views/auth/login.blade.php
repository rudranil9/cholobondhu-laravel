@extends('layouts.auth')

@section('title', 'Login')

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
    <h2 class="text-4xl font-bold gradient-text mb-2 animate-fade-in">Welcome Back!</h2>
    <p class="text-gray-600 dark:text-gray-400 animate-fade-in" style="animation-delay: 0.2s;">Sign in to your account to continue your journey</p>
</div>

<!-- Session Status -->
@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-3 rounded-lg">
        {{ session('status') }}
    </div>
@endif

@if (session('success'))
    <div class="mb-6 font-medium text-sm bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 p-4 rounded-xl border border-green-200 dark:border-green-800 animate-fade-in">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- Special message for deactivated accounts -->
@if (session('deactivated_user') || ($errors->has('email') && str_contains($errors->first('email'), 'deactivated')))
    <div class="mb-6 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-orange-800 dark:text-orange-200 mb-2">Account Deactivated</h3>
                <p class="text-sm text-orange-700 dark:text-orange-300 mb-3">
                    {{ $errors->has('email') ? $errors->first('email') : 'Your account has been deactivated by the administrator.' }}
                </p>
                <div class="bg-orange-100 dark:bg-orange-900/50 p-3 rounded-md border border-orange-200 dark:border-orange-800">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        <span class="text-sm font-medium text-orange-700 dark:text-orange-300">Please contact customer support for assistance.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="loginForm()">
    @csrf

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
                autofocus 
                autocomplete="username"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg"
                placeholder="Enter your email"
            />
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $message }}</span>
            </p>
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
                autocomplete="current-password"
                class="block w-full pl-3 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700/50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300 backdrop-blur-sm hover:shadow-md focus:shadow-lg @error('password') border-red-500 @enderror"
                placeholder="Enter your password"
            />
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $message }}</span>
            </p>
        @enderror
    </div>

    <!-- Forgot Password -->
    <div class="flex justify-end">
        @if (Route::has('password.request'))
            <a 
                href="{{ route('password.request') }}" 
                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-300"
            >
                Forgot password?
            </a>
        @endif
    </div>

    <!-- Submit Button -->
    <div>
        <button 
            type="submit" 
            @click="submitForm()"
            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-4 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 relative overflow-hidden group border border-blue-500/20"
        >
            <!-- Shimmer effect -->
            <div class="absolute inset-0 -top-px bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 group-hover:animate-pulse"></div>
            <!-- Button Content -->
            <span class="relative flex items-center justify-center space-x-2">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span>Sign In to Your Account</span>
            </span>
        </button>
    </div>

    <!-- Register Link -->
    <div class="text-center mt-6">
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
            isSubmitting: false,
            
            submitForm() {
                if (this.isSubmitting) return;
                this.isSubmitting = true;
                
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
                
                setTimeout(() => {
                    if (button && this.isSubmitting) {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        this.isSubmitting = false;
                    }
                }, 5000);
            }
        }
    }
</script>
@endpush
@endsection
