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
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Preload critical images -->
    <link rel="preload" href="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" as="image">
    <link rel="preload" href="{{ asset('assets/hero-travel-bg.jpg') }}" as="image">
    
    <!-- PRODUCTION CSS LOADING - MULTIPLE STRATEGIES -->
    @php
        $isProduction = app()->environment('production') || !config('app.debug');
        $cssLoaded = false;
    @endphp
    
    @if($isProduction)
        <!-- FIXED: Use manifest.json to get correct CSS file name -->
        @php
            $manifestPath = public_path('build/manifest.json');
            $manifest = [];
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            }
            
            $cssFile = $manifest['resources/css/app.css']['file'] ?? 'assets/app.css';
            $jsFile = $manifest['resources/js/app.js']['file'] ?? 'assets/app.js';
        @endphp
        
        <!-- Strategy 1: Use correct manifest file path -->
        <link rel="stylesheet" href="/build/{{ $cssFile }}" type="text/css">
        
        <!-- Strategy 2: Asset helper with manifest path -->
        <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}" type="text/css">
        
        <!-- Strategy 3: Direct current build paths as backup -->
        <link rel="stylesheet" href="/build/assets/app-Dk15iVT-.css" type="text/css">
        
        <!-- Strategy 4: Inline critical CSS as absolute fallback -->
        <style id="critical-css">
            /* Tailwind Reset & Base */
            *,::before,::after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}
            ::before,::after{--tw-content:''}
            html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal}
            body{margin:0;line-height:inherit;font-family:Inter,Poppins,ui-sans-serif,system-ui,sans-serif}
            
            /* Critical Layout Classes */
            .container{width:100%;max-width:1200px;margin-left:auto;margin-right:auto;padding-left:1rem;padding-right:1rem}
            .hidden{display:none!important}
            .block{display:block}
            .flex{display:flex}
            .inline-flex{display:inline-flex}
            .items-center{align-items:center}
            .justify-between{justify-content:space-between}
            .justify-center{justify-content:center}
            .text-center{text-align:center}
            .text-white{color:#fff}
            .bg-white{background-color:#fff}
            .bg-blue-500{background-color:#3b82f6}
            .bg-blue-600{background-color:#2563eb}
            .hover\\:bg-blue-700:hover{background-color:#1d4ed8}
            .py-4{padding-top:1rem;padding-bottom:1rem}
            .px-6{padding-left:1.5rem;padding-right:1.5rem}
            .px-4{padding-left:1rem;padding-right:1rem}
            .mb-4{margin-bottom:1rem}
            .mt-4{margin-top:1rem}
            .rounded{border-radius:0.375rem}
            .rounded-lg{border-radius:0.5rem}
            .shadow{box-shadow:0 1px 3px 0 rgb(0 0 0/0.1),0 1px 2px -1px rgb(0 0 0/0.1)}
            .shadow-lg{box-shadow:0 10px 15px -3px rgb(0 0 0/0.1),0 4px 6px -4px rgb(0 0 0/0.1)}
            .transition{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms}
            
            /* Navigation */
            nav{background:#fff;box-shadow:0 4px 6px -1px rgb(0 0 0/0.1);position:fixed;top:0;left:0;right:0;z-index:50;transition:all 0.3s ease}
            .dark nav{background:#1f2937;border-bottom:1px solid #374151}
            .nav-container{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;max-width:1200px;margin:0 auto}
            .logo{width:60px;height:60px;border-radius:50%}
            .nav-links{display:flex;align-items:center;gap:2rem}
            .nav-link{color:#374151;text-decoration:none;font-weight:500;transition:all 0.3s ease;padding:0.5rem 0.75rem;border-radius:0.375rem}
            .nav-link:hover{color:#3b82f6;transform:translateY(-1px)}
            .dark .nav-link{color:#d1d5db}
            .dark .nav-link:hover{color:#60a5fa}
            
            /* Mobile Navigation */
            @media (max-width: 768px) {
                .md\\:hidden{display:block}
                .md\\:flex{display:none}
                .nav-container{padding:1rem}
            }
            
            /* Dropdown */
            .dropdown{position:relative}
            .dropdown-menu{position:absolute;right:0;top:100%;background:#fff;border-radius:0.5rem;box-shadow:0 10px 15px -3px rgb(0 0 0/0.1);padding:0.5rem;margin-top:0.5rem;min-width:12rem}
            .dark .dropdown-menu{background:#374151;border:1px solid #4b5563}
            
            /* Button styles */
            .btn-primary{background:linear-gradient(135deg,#3b82f6,#8b5cf6);color:#fff;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;transition:all 0.3s;text-decoration:none;display:inline-block}
            .btn-primary:hover{transform:translateY(-1px);box-shadow:0 10px 20px rgba(0,0,0,0.2);background:linear-gradient(135deg,#1d4ed8,#7c3aed)}
            
            /* Ensure body has top padding for fixed nav */
            body{padding-top:4rem}
            
            /* Hero Section */
            .hero{min-height:100vh;background:linear-gradient(to bottom right,#1e40af,#3b82f6,#8b5cf6);position:relative;display:flex;align-items:center;justify-content:center;text-align:center;color:white}
            .hero-bg{position:absolute;inset:0;background:url('/assets/hero-travel-bg.jpg') center/cover;opacity:0.3}
            .hero-content{position:relative;z-index:10;max-width:800px;padding:2rem}
            .hero-title{font-size:4rem;font-weight:800;margin-bottom:1rem;background:linear-gradient(to right,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
            .hero-subtitle{font-size:2rem;margin-bottom:2rem;color:#e5e7eb}
            .hero-buttons{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
            .btn{display:inline-block;padding:1rem 2rem;background:linear-gradient(135deg,#3b82f6,#8b5cf6);color:white;text-decoration:none;border-radius:0.5rem;font-weight:600;transition:all 0.3s;box-shadow:0 4px 15px rgba(59,130,246,0.4)}
            .btn:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(59,130,246,0.5)}
            .btn-secondary{background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3)}
            
            /* Responsive */
            @media (max-width: 768px){
                .hero-title{font-size:2.5rem}
                .hero-subtitle{font-size:1.5rem}
                .nav-container{padding:1rem}
                .hero-content{padding:1rem}
                .hero-buttons{flex-direction:column;align-items:center}
            }
        </style>
        
        <!-- Debug info -->
        <script>
            console.log('Production CSS loading attempt');
            console.log('Environment:', '{{ app()->environment() }}');
            console.log('Debug mode:', {{ config('app.debug') ? 'true' : 'false' }});
        </script>
        
        <script src="/build/assets/app-DtCVKgHt.js" defer></script>
        <script src="{{ asset('build/assets/app-DtCVKgHt.js') }}" defer onerror="console.log('JS failed to load')"></script>
    @else
        <!-- Development mode -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
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
