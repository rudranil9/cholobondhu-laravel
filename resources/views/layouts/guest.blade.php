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
                body{margin:0;line-height:inherit}
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
