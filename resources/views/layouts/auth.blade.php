<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication') - Cholo Bondhu Travel</title>
    
    <meta name="description" content="Join Cholo Bondhu Travel - Login or register to book amazing travel packages and manage your trips.">
    
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            visibility: hidden;
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script>
        // Initialize dark mode before page load to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('darkMode');
            if (savedTheme === 'true') {
                document.documentElement.classList.add('dark');
            }
        })();
        
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.visibility = 'visible';
        });
    </script>
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-all duration-500">
    <!-- Animated Background Pattern -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Animated gradient orbs -->
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full opacity-15 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 left-1/2 w-64 h-64 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full opacity-10 animate-pulse" style="animation-delay: 4s;"></div>
        
        <!-- Floating particles -->
        <div class="absolute inset-0">
            <div class="particle absolute w-2 h-2 bg-blue-400 rounded-full opacity-30" style="left: 10%; top: 20%; animation: float 6s ease-in-out infinite;"></div>
            <div class="particle absolute w-1 h-1 bg-purple-400 rounded-full opacity-40" style="left: 80%; top: 30%; animation: float 4s ease-in-out infinite 1s;"></div>
            <div class="particle absolute w-3 h-3 bg-cyan-400 rounded-full opacity-20" style="left: 60%; top: 60%; animation: float 5s ease-in-out infinite 2s;"></div>
            <div class="particle absolute w-1 h-1 bg-pink-400 rounded-full opacity-50" style="left: 20%; top: 70%; animation: float 7s ease-in-out infinite 3s;"></div>
            <div class="particle absolute w-2 h-2 bg-indigo-400 rounded-full opacity-30" style="left: 90%; top: 80%; animation: float 8s ease-in-out infinite 4s;"></div>
        </div>
    </div>
    
    <!-- Floating Travel Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-plane absolute top-20 right-20 text-6xl opacity-20 floating-animation">✈️</div>
        <div class="floating-train absolute bottom-40 left-20 text-5xl opacity-15 floating-animation" style="animation-delay: 1s;">🚂</div>
        <div class="floating-boat absolute top-1/3 right-1/3 text-4xl opacity-10 floating-animation" style="animation-delay: 2s;">🚢</div>
        <div class="floating-car absolute bottom-20 right-40 text-4xl opacity-15 floating-animation" style="animation-delay: 3s;">🚗</div>
        <div class="floating-map absolute top-40 left-40 text-3xl opacity-20 floating-animation" style="animation-delay: 4s;">🗺️</div>
    </div>

    <!-- Navigation -->
    @include('partials.navigation')
    
    <div class="relative min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Auth Card -->
        <div class="w-full max-w-md sm:max-w-lg mt-6 px-6 py-8 sm:px-8 sm:py-10 glass-card dark:glass-card-dark shadow-2xl overflow-hidden rounded-2xl sm:rounded-3xl border border-white/20 dark:border-gray-700/30 backdrop-blur-xl">
            @yield('content')
        </div>
    </div>
    
    <!-- Footer -->
    @include('partials.footer')
        
        <!-- Dark Mode Toggle -->
        <button onclick="toggleDarkMode()" class="fixed top-4 right-4 theme-icon p-3 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors shadow-lg">
            <!-- Sun icon (shown in dark mode) -->
            <svg class="sun-icon w-6 h-6" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <!-- Moon icon (shown in light mode) -->
            <svg class="moon-icon w-6 h-6" style="display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </div>
    
    <!-- Dark Mode Script -->
    <script>
        // Dark mode functionality for auth pages
        let isDarkMode = localStorage.getItem('darkMode') === 'true';
        
        function updateTheme() {
            const html = document.documentElement;
            
            if (isDarkMode) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            
            // Update theme icon
            updateThemeIcon();
        }
        
        function updateThemeIcon() {
            const themeIcons = document.querySelectorAll('.theme-icon');
            themeIcons.forEach(icon => {
                const sunIcon = icon.querySelector('.sun-icon');
                const moonIcon = icon.querySelector('.moon-icon');
                
                if (isDarkMode) {
                    if (sunIcon) sunIcon.style.display = 'block';
                    if (moonIcon) moonIcon.style.display = 'none';
                } else {
                    if (sunIcon) sunIcon.style.display = 'none';
                    if (moonIcon) moonIcon.style.display = 'block';
                }
            });
        }
        
        function toggleDarkMode() {
            isDarkMode = !isDarkMode;
            localStorage.setItem('darkMode', isDarkMode);
            updateTheme();
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            updateTheme();
        });
        
        // Make function globally available
        window.toggleDarkMode = toggleDarkMode;
    </script>

    <style>
        .floating-plane {
            animation: floatPlane 8s ease-in-out infinite;
        }
        
        .floating-train {
            animation: floatTrain 10s ease-in-out infinite;
        }
        
        .floating-boat {
            animation: floatBoat 9s ease-in-out infinite;
        }
        
        .floating-car {
            animation: floatCar 7s ease-in-out infinite;
        }
        
        .floating-map {
            animation: floatMap 6s ease-in-out infinite;
        }
        
        @keyframes floatPlane {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-20px, -15px) rotate(-2deg); }
            50% { transform: translate(10px, -30px) rotate(1deg); }
            75% { transform: translate(25px, -10px) rotate(-1deg); }
        }
        
        @keyframes floatTrain {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-30px); }
        }
        
        @keyframes floatBoat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(15px, 10px) rotate(1deg); }
            66% { transform: translate(-10px, -8px) rotate(-1deg); }
        }
        
        @keyframes floatCar {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes floatMap {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(2deg); }
        }
    </style>
</body>
</html>
