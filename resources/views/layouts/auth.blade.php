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

    <!-- PRODUCTION CSS LOADING - MULTIPLE STRATEGIES -->
    @php
        $isProduction = app()->environment('production') || !config('app.debug');
        $cssLoaded = false;
    @endphp
    
    @if($isProduction)
        <!-- Use manifest.json to get correct CSS file name -->
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
        
        <!-- JavaScript -->
        <script src="/build/{{ $jsFile }}" defer></script>
        <script src="{{ asset('build/' . $jsFile) }}" defer></script>
        
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
            .grid{display:grid}
            .items-center{align-items:center}
            .items-start{align-items:flex-start}
            .justify-center{justify-content:center}
            .justify-between{justify-content:space-between}
            .justify-end{justify-content:flex-end}
            .space-x-2>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.5rem * var(--tw-space-x-reverse));margin-left:calc(0.5rem * calc(1 - var(--tw-space-x-reverse)))}
            .space-x-3>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.75rem * var(--tw-space-x-reverse));margin-left:calc(0.75rem * calc(1 - var(--tw-space-x-reverse)))}
            .space-x-4>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1rem * var(--tw-space-x-reverse));margin-left:calc(1rem * calc(1 - var(--tw-space-x-reverse)))}
            .space-y-6>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.5rem * var(--tw-space-y-reverse))}
            
            /* Colors & Backgrounds */
            .bg-white{background-color:rgb(255 255 255)}
            .bg-gray-50{background-color:rgb(249 250 251)}
            .bg-gray-100{background-color:rgb(243 244 246)}
            .bg-gray-700{background-color:rgb(55 65 81)}
            .bg-gray-800{background-color:rgb(31 41 55)}
            .bg-gray-900{background-color:rgb(17 24 39)}
            .bg-blue-50{background-color:rgb(239 246 255)}
            .bg-blue-500{background-color:rgb(59 130 246)}
            .bg-blue-600{background-color:rgb(37 99 235)}
            .bg-purple-600{background-color:rgb(147 51 234)}
            .bg-green-50{background-color:rgb(240 253 244)}
            .bg-orange-50{background-color:rgb(255 247 237)}
            .bg-red-50{background-color:rgb(254 242 242)}
            
            /* Gradients */
            .bg-gradient-to-r{background-image:linear-gradient(to right,var(--tw-gradient-stops))}
            .bg-gradient-to-br{background-image:linear-gradient(to bottom right,var(--tw-gradient-stops))}
            .from-blue-50{--tw-gradient-from:rgb(239 246 255);--tw-gradient-to:rgb(239 246 255 / 0);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to)}
            .from-blue-600{--tw-gradient-from:rgb(37 99 235);--tw-gradient-to:rgb(37 99 235 / 0);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to)}
            .from-blue-100{--tw-gradient-from:rgb(219 234 254);--tw-gradient-to:rgb(219 234 254 / 0);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to)}
            .to-purple-50{--tw-gradient-to:rgb(250 245 255)}
            .to-purple-600{--tw-gradient-to:rgb(147 51 234)}
            .to-purple-100{--tw-gradient-to:rgb(237 233 254)}
            .via-white{--tw-gradient-to:rgb(255 255 255 / 0);--tw-gradient-stops:var(--tw-gradient-from),rgb(255 255 255),var(--tw-gradient-to)}
            
            /* Text */
            .text-white{color:rgb(255 255 255)}
            .text-gray-600{color:rgb(75 85 99)}
            .text-gray-700{color:rgb(55 65 81)}
            .text-gray-800{color:rgb(31 41 55)}
            .text-gray-300{color:rgb(209 213 219)}
            .text-gray-400{color:rgb(156 163 175)}
            .text-blue-600{color:rgb(37 99 235)}
            .text-blue-400{color:rgb(96 165 250)}
            .text-green-600{color:rgb(22 163 74)}
            .text-orange-600{color:rgb(234 88 12)}
            .text-red-600{color:rgb(220 38 38)}
            
            /* Font Sizes & Weights */
            .text-xs{font-size:0.75rem;line-height:1rem}
            .text-sm{font-size:0.875rem;line-height:1.25rem}
            .text-base{font-size:1rem;line-height:1.5rem}
            .text-lg{font-size:1.125rem;line-height:1.75rem}
            .text-xl{font-size:1.25rem;line-height:1.75rem}
            .text-2xl{font-size:1.5rem;line-height:2rem}
            .text-4xl{font-size:2.25rem;line-height:2.5rem}
            .text-6xl{font-size:3.75rem;line-height:1}
            .font-medium{font-weight:500}
            .font-semibold{font-weight:600}
            .font-bold{font-weight:700}
            
            /* Spacing */
            .m-0{margin:0}
            .mx-auto{margin-left:auto;margin-right:auto}
            .mb-2{margin-bottom:0.5rem}
            .mb-4{margin-bottom:1rem}
            .mb-6{margin-bottom:1.5rem}
            .mb-8{margin-bottom:2rem}
            .mt-2{margin-top:0.5rem}
            .mt-6{margin-top:1.5rem}
            .p-3{padding:0.75rem}
            .p-4{padding:1rem}
            .px-4{padding-left:1rem;padding-right:1rem}
            .px-6{padding-left:1.5rem;padding-right:1.5rem}
            .px-8{padding-left:2rem;padding-right:2rem}
            .py-2{padding-top:0.5rem;padding-bottom:0.5rem}
            .py-3{padding-top:0.75rem;padding-bottom:0.75rem}
            .py-4{padding-top:1rem;padding-bottom:1rem}
            .py-8{padding-top:2rem;padding-bottom:2rem}
            .py-10{padding-top:2.5rem;padding-bottom:2.5rem}
            .py-12{padding-top:3rem;padding-bottom:3rem}
            .pl-3{padding-left:0.75rem}
            .pr-3{padding-right:0.75rem}
            
            /* Borders & Radius */
            .border{border-width:1px}
            .border-2{border-width:2px}
            .border-gray-200{border-color:rgb(229 231 235)}
            .border-gray-300{border-color:rgb(209 213 219)}
            .border-gray-600{border-color:rgb(75 85 99)}
            .border-blue-200{border-color:rgb(191 219 254)}
            .border-blue-500{border-color:rgb(59 130 246)}
            .border-white{border-color:rgb(255 255 255)}
            .rounded{border-radius:0.25rem}
            .rounded-lg{border-radius:0.5rem}
            .rounded-xl{border-radius:0.75rem}
            .rounded-2xl{border-radius:1rem}
            .rounded-3xl{border-radius:1.5rem}
            .rounded-full{border-radius:9999px}
            
            /* Shadows & Effects */
            .shadow-lg{box-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1),0 4px 6px -4px rgb(0 0 0 / 0.1)}
            .shadow-xl{box-shadow:0 20px 25px -5px rgb(0 0 0 / 0.1),0 8px 10px -6px rgb(0 0 0 / 0.1)}
            .shadow-2xl{box-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25)}
            .backdrop-blur-sm{backdrop-filter:blur(4px)}
            .backdrop-blur-xl{backdrop-filter:blur(24px)}
            
            /* Positioning */
            .relative{position:relative}
            .absolute{position:absolute}
            .fixed{position:fixed}
            .inset-0{top:0;right:0;bottom:0;left:0}
            .top-4{top:1rem}
            .right-4{right:1rem}
            .w-full{width:100%}
            .w-4{width:1rem}
            .w-5{width:1.25rem}
            .w-6{width:1.5rem}
            .w-24{width:6rem}
            .h-4{height:1rem}
            .h-5{height:1.25rem}
            .h-6{height:1.5rem}
            .h-24{height:6rem}
            .h-full{height:100%}
            .min-h-screen{min-height:100vh}
            .max-w-md{max-width:28rem}
            .max-w-lg{max-width:32rem}
            
            /* Transitions & Animations */
            .transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms}
            .transition-colors{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms}
            .duration-300{transition-duration:300ms}
            .duration-500{transition-duration:500ms}
            .hover\\:bg-gray-100:hover{background-color:rgb(243 244 246)}
            .hover\\:bg-blue-700:hover{background-color:rgb(29 78 216)}
            .hover\\:to-purple-700:hover{--tw-gradient-to:rgb(126 34 206)}
            .hover\\:text-blue-800:hover{color:rgb(30 64 175)}
            .hover\\:scale-105:hover{transform:scale(1.05)}
            .active\\:scale-95:active{transform:scale(0.95)}
            
            /* Forms */
            .focus\\:outline-none:focus{outline:2px solid transparent;outline-offset:2px}
            .focus\\:ring-2:focus{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow,0 0 #0000)}
            .focus\\:ring-4:focus{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow,0 0 #0000)}
            .focus\\:ring-blue-500:focus{--tw-ring-opacity:1;--tw-ring-color:rgb(59 130 246 / var(--tw-ring-opacity))}
            .focus\\:border-blue-500:focus{border-color:rgb(59 130 246)}
            
            /* Utility Classes */
            .cursor-pointer{cursor:pointer}
            .select-none{user-select:none}
            .overflow-hidden{overflow:hidden}
            .pointer-events-none{pointer-events:none}
            .antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
            .text-center{text-align:center}
            .uppercase{text-transform:uppercase}
            .opacity-10{opacity:0.1}
            .opacity-15{opacity:0.15}
            .opacity-20{opacity:0.2}
            .opacity-25{opacity:0.25}
            .opacity-30{opacity:0.3}
            
            /* Custom Glass Effect */
            .glass-card{background:rgba(255,255,255,0.8);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.3)}
            .glass-card-dark{background:rgba(17,24,39,0.8);backdrop-filter:blur(16px);border:1px solid rgba(55,65,81,0.3)}
            
            /* Custom Animations */
            @keyframes float{0%,100%{transform:translateY(0px)}50%{transform:translateY(-10px)}}
            @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.5}}
            @keyframes ping{75%,100%{transform:scale(2);opacity:0}}
            @keyframes spin{to{transform:rotate(360deg)}}
            .animate-fade-in{animation:fadeIn 0.8s ease-out}
            .animate-pulse{animation:pulse 2s cubic-bezier(0.4,0,0.6,1) infinite}
            .animate-ping{animation:ping 1s cubic-bezier(0,0,0.2,1) infinite}
            .animate-spin{animation:spin 1s linear infinite}
            
            @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
            
            /* Gradient Text */
            .gradient-text{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
            
            /* Dark Mode Support */
            .dark .bg-gray-700{background-color:rgb(55 65 81)}
            .dark .bg-gray-800{background-color:rgb(31 41 55)}
            .dark .bg-gray-900{background-color:rgb(17 24 39)}
            .dark .text-white{color:rgb(255 255 255)}
            .dark .text-gray-300{color:rgb(209 213 219)}
            .dark .text-gray-400{color:rgb(156 163 175)}
            .dark .border-gray-600{border-color:rgb(75 85 99)}
            .dark .border-gray-700{border-color:rgb(55 65 81)}
            .dark .from-gray-900{--tw-gradient-from:rgb(17 24 39)}
            .dark .via-gray-800{--tw-gradient-to:rgb(31 41 55 / 0);--tw-gradient-stops:var(--tw-gradient-from),rgb(31 41 55),var(--tw-gradient-to)}
            .dark .to-gray-900{--tw-gradient-to:rgb(17 24 39)}
            
            /* Responsive */
            @media (min-width: 640px) {
                .sm\\:max-w-lg{max-width:32rem}
                .sm\\:px-6{padding-left:1.5rem;padding-right:1.5rem}
                .sm\\:px-8{padding-left:2rem;padding-right:2rem}
                .sm\\:py-10{padding-top:2.5rem;padding-bottom:2.5rem}
                .sm\\:rounded-3xl{border-radius:1.5rem}
            }
            
            @media (min-width: 1024px) {
                .lg\\:px-8{padding-left:2rem;padding-right:2rem}
            }
        </style>
        
        <script>
            console.log('🎨 AUTH PAGE - Production CSS Loading with Manifest');
            console.log('CSS File:', '{{ $cssFile }}');
            console.log('JS File:', '{{ $jsFile }}');
            console.log('Environment:', '{{ app()->environment() }}');
            console.log('Debug Mode:', {{ config('app.debug') ? 'true' : 'false' }});
        </script>
    @else
        <!-- Development: Use Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>console.log('🚀 AUTH PAGE - Development Vite Assets Loaded');</script>
    @endif
    
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
