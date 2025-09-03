<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cholo Bondhu - Tour & Travels')</title>
    
    <meta name="description" content="@yield('description', 'Discover incredible places with Cholo Bondhu Travel. Expert travel planning, best prices, and unforgettable experiences across India and beyond.')">
    <meta name="keywords" content="travel, tours, India travel, vacation packages, travel agency, Cholo Bondhu">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Cholo Bondhu - Tour & Travels')">
    <meta property="og:description" content="@yield('description', 'Discover incredible places with Cholo Bondhu Travel. Expert travel planning, best prices, and unforgettable experiences across India and beyond.')">
    <meta property="og:image" content="{{ asset('og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Cholo Bondhu - Tour & Travels')">
    <meta property="twitter:description" content="@yield('description', 'Discover incredible places with Cholo Bondhu Travel. Expert travel planning, best prices, and unforgettable experiences across India and beyond.')">
    <meta property="twitter:image" content="{{ asset('og-image.jpg') }}">
    
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Preload critical images -->
    <link rel="preload" href="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" as="image">
    <link rel="preload" href="{{ asset('assets/hero-travel-bg.jpg') }}" as="image">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            visibility: hidden;
        }
    </style>
    <script>
        // Force scroll to top and only then show the page
        window.history.scrollRestoration = 'manual';
        window.scrollTo(0, 0);
        
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.scrollTo(0, 0);
                document.body.style.visibility = 'visible';
            }, 50); // Small delay to ensure render tree is ready
        });
    </script>
</head>
<body class="min-h-screen transition-colors duration-300" id="app-body">
    <!-- City Transition Animation -->
    <div id="city-transition" class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-500">
        <!-- We'll implement this with JavaScript later -->
    </div>

    <div class="min-h-screen transition-colors duration-300" id="main-container">
        @isset($navigation)
            {{ $navigation }}
        @else
            @include('partials.navigation')
        @endisset
        
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow mt-16">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Main Content -->
        <main class="pt-0">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    <!-- Dark Mode Script -->
    <script>
        // Dark mode functionality
        let isDarkMode = localStorage.getItem('darkMode') === 'true';
        
        function updateTheme() {
            const html = document.documentElement;
            const body = document.getElementById('app-body');
            const container = document.getElementById('main-container');
            
            if (isDarkMode) {
                html.classList.add('dark');
                body.classList.add('dark');
                container.classList.add('bg-gray-900', 'text-white');
                container.classList.remove('bg-white', 'text-gray-900');
            } else {
                html.classList.remove('dark');
                body.classList.remove('dark');
                container.classList.add('bg-white', 'text-gray-900');
                container.classList.remove('bg-gray-900', 'text-white');
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
            
            // Show transition animation
            const transition = document.getElementById('city-transition');
            if (transition) {
                transition.classList.remove('opacity-0');
                transition.classList.add('opacity-100');
                
                setTimeout(() => {
                    transition.classList.remove('opacity-100');
                    transition.classList.add('opacity-0');
                }, 800);
            }
        }
        
        // Initialize theme on load and before DOM content loaded to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('darkMode');
            if (savedTheme === 'true') {
                document.documentElement.classList.add('dark');
                isDarkMode = true;
            }
        })();
        
        document.addEventListener('DOMContentLoaded', () => {
            updateTheme();
        });
        
        // Make function globally available
        window.toggleDarkMode = toggleDarkMode;
    </script>

    @stack('scripts')
</body>
</html>
