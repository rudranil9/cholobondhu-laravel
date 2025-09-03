<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- PRODUCTION CSS LOADING - MULTIPLE STRATEGIES -->
        @php
            $isProduction = app()->environment('production') || !config('app.debug');
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
            
            <!-- Inline critical CSS for guest pages -->
            <style>
                /* Essential Tailwind Classes for Guest Pages */
                *,::before,::after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}
                html{line-height:1.5;font-family:Figtree,ui-sans-serif,system-ui,sans-serif}
                body{margin:0;line-height:inherit;padding-top:4rem}
                .font-sans{font-family:ui-sans-serif,system-ui,sans-serif}
                .text-gray-900{color:rgb(17 24 39)}
                .antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
                .min-h-screen{min-height:100vh}
                .flex{display:flex}
                .flex-col{flex-direction:column}
                .items-center{align-items:center}
                .pt-6{padding-top:1.5rem}
                .bg-gray-100{background-color:rgb(243 244 246)}
                .w-full{width:100%}
                .w-20{width:5rem}
                .h-20{height:5rem}
                .fill-current{fill:currentColor}
                .text-gray-500{color:rgb(107 114 128)}
                .mt-6{margin-top:1.5rem}
                .px-6{padding-left:1.5rem;padding-right:1.5rem}
                .py-4{padding-top:1rem;padding-bottom:1rem}
                
                /* Navigation Styles for Guest Layout */
                nav{background:#fff;box-shadow:0 4px 6px -1px rgb(0 0 0/0.1);position:fixed;top:0;left:0;right:0;z-index:50;transition:all 0.3s ease}
                .dark nav{background:#1f2937;border-bottom:1px solid #374151}
                .max-w-7xl{max-width:80rem}
                .mx-auto{margin-left:auto;margin-right:auto}
                .px-4{padding-left:1rem;padding-right:1rem}
                .sm\\:px-6{padding-left:1.5rem;padding-right:1.5rem}
                .lg\\:px-8{padding-left:2rem;padding-right:2rem}
                .justify-between{justify-content:space-between}
                .items-center{align-items:center}
                .h-16{height:4rem}
                .space-x-3>*+*{margin-left:0.75rem}
                .space-x-8>*+*{margin-left:2rem}
                .w-12{width:3rem}
                .h-12{height:3rem}
                .bg-white{background-color:#fff}
                .rounded-full{border-radius:9999px}
                .shadow-lg{box-shadow:0 10px 15px -3px rgb(0 0 0/0.1),0 4px 6px -4px rgb(0 0 0/0.1)}
                .overflow-hidden{overflow:hidden}
                .border-2{border-width:2px}
                .border-gray-100{border-color:#f3f4f6}
                .object-contain{object-fit:contain}
                .text-xl{font-size:1.25rem}
                .font-bold{font-weight:700}
                .text-gray-900{color:#111827}
                .dark\\:text-white{color:#fff}
                .hidden{display:none}
                .md\\:flex{display:flex}
                .hover\\:opacity-80:hover{opacity:0.8}
                .transition-opacity{transition-property:opacity}
                .nav-link{color:#374151;text-decoration:none;font-weight:500;transition:all 0.3s ease;padding:0.5rem 0.75rem;border-radius:0.375rem;font-size:0.875rem}
                .nav-link:hover{color:#3b82f6;transform:translateY(-1px)}
                .dark .nav-link{color:#d1d5db}
                .dark .nav-link:hover{color:#60a5fa}
                .text-blue-600{color:#2563eb}
                .dark\\:text-blue-400{color:#60a5fa}
                .text-gray-700{color:#374151}
                .dark\\:text-gray-300{color:#d1d5db}
                .hover\\:text-blue-600:hover{color:#2563eb}
                .dark\\:hover\\:text-blue-400:hover{color:#60a5fa}
                .rounded-md{border-radius:0.375rem}
                .text-sm{font-size:0.875rem}
                .font-medium{font-weight:500}
                .transition-colors{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke}
                .bg-blue-600{background-color:#2563eb}
                .text-white{color:#fff}
                .py-2{padding-top:0.5rem;padding-bottom:0.5rem}
                .rounded-lg{border-radius:0.5rem}
                .hover\\:bg-blue-700:hover{background-color:#1d4ed8}
                
                /* Mobile Navigation */
                .md\\:hidden{display:block}
                @media (min-width: 768px) {
                    .md\\:flex{display:flex!important}
                    .md\\:hidden{display:none!important}
                }
                .bg-white{background-color:rgb(255 255 255)}
                .shadow-md{box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1),0 2px 4px -2px rgb(0 0 0 / 0.1)}
                .overflow-hidden{overflow:hidden}
                
                /* Responsive */
                @media (min-width: 640px) {
                    .sm\\:justify-center{justify-content:center}
                    .sm\\:pt-0{padding-top:0}
                    .sm\\:max-w-md{max-width:28rem}
                    .sm\\:rounded-lg{border-radius:0.5rem}
                }
            </style>
            
            <script>
                console.log('🎨 GUEST PAGE - Production CSS Loading with Manifest');
                console.log('CSS File:', '{{ $cssFile }}');
            </script>
        @else
            <!-- Development: Use Vite -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            <script>console.log('🚀 GUEST PAGE - Development Vite Assets Loaded');</script>
        @endif
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
