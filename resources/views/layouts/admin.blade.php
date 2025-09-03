<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') - Cholo Bondhu Tour & Travels</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Modern Admin Styles */
        .admin-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .admin-sidebar {
            width: 280px;
            flex-shrink: 0;
            background: #f8fafc;
            border-right: 1px solid #e2e8f0;
        }
        
        .dark .admin-sidebar {
            background: #1f2937;
            border-right: 1px solid #374151;
        }
        
        .admin-main {
            flex: 1;
            min-width: 0;
            background: #ffffff;
        }
        
        .dark .admin-main {
            background: #111827;
        }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.5);
        }
        
        @media (max-width: 1024px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                height: 100vh;
                z-index: 50;
                transition: left 0.3s ease;
            }
            .admin-sidebar.show {
                left: 0;
            }
            .admin-main {
                margin-left: 0;
            }
        }
        
        /* Card Styles */
        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .dark .stats-card {
            background: linear-gradient(135deg, rgba(17, 24, 39, 0.6), rgba(55, 65, 81, 0.3));
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="admin-container animated-bg">
        <!-- Sidebar -->
        <aside class="admin-sidebar custom-scrollbar overflow-y-auto" :class="{ 'show': sidebarOpen }">
            <!-- Logo -->
            <div class="flex items-center justify-center h-20 border-b border-gray-200 dark:border-gray-600">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg overflow-hidden">
                        <img src="{{ asset('assets/cholobondhu-logo.jpg') }}" alt="Cholo Bondhu Logo" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div>
                        <span class="text-gray-800 dark:text-white font-bold text-xl">Cholo Bondhu</span>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Tour & Travels</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8 px-6">
                <div class="space-y-3">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 dark:bg-gray-700 text-blue-800 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="mr-3 p-2 rounded-lg bg-blue-100 dark:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                        </div>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Booking Management -->
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-800 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="mr-3 p-2 rounded-lg bg-blue-100 dark:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span>Bookings</span>
                        <span class="ml-auto bg-blue-100 dark:bg-gray-700 text-blue-800 dark:text-white text-xs font-medium px-2 py-1 rounded-full">
                            {{ \App\Models\Booking::where('status', 'pending')->count() }}
                        </span>
                    </a>
                    
                    <!-- User Management -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-800 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="mr-3 p-2 rounded-lg bg-blue-100 dark:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <span>Users</span>
                        <span class="ml-auto bg-blue-100 dark:bg-gray-700 text-blue-800 dark:text-white text-xs font-medium px-2 py-1 rounded-full">
                            {{ \App\Models\User::where('role', 'user')->count() }}
                        </span>
                    </a>
                    
                    <!-- Contact Inquiries -->
                    <a href="{{ route('admin.contact-inquiries.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.contact-inquiries.*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-800 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="mr-3 p-2 rounded-lg bg-blue-100 dark:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span>Contact Inquiries</span>
                    </a>
                </div>
                
                <!-- Spacer to push settings down -->
                <div class="flex-1"></div>
                
                <!-- Divider -->
                <div class="my-6 border-t border-gray-200 dark:border-gray-600"></div>
                
                <!-- Settings Section -->
                <div class="space-y-3">
                    <p class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Settings & Tools</p>
                    
                    <!-- Back to Site -->
                    <a href="{{ route('home') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="mr-3 p-2 rounded-lg bg-blue-100 dark:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </div>
                        <span>Back to Site</span>
                    </a>
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" 
                                class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 w-full text-left">
                            <div class="mr-3 p-2 rounded-lg bg-blue-100 dark:bg-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </div>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
            
            <!-- User Info -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-600">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-300 truncate">Admin - Cholo Bondhu</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Mobile Sidebar Overlay -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"
        ></div>
        
        <!-- Main Content -->
        <div class="admin-main custom-scrollbar overflow-y-auto">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 sticky top-0 z-30 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <!-- Mobile menu button -->
                        <button 
                            @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-3 rounded-xl text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white/10 transition-all duration-300"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Page Title -->
                        <div class="flex items-center space-x-4">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                @yield('page-title', 'Dashboard')
                            </h1>
                            <div class="hidden sm:block text-sm text-gray-500 dark:text-gray-400 bg-white/20 px-3 py-1 rounded-full">
                                {{ now()->format('M d, Y') }}
                            </div>
                        </div>
                        
                        <!-- Top Right Actions -->
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button 
                                @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                                class="p-3 rounded-xl bg-white/20 text-gray-600 dark:text-gray-300 hover:bg-white/30 dark:hover:bg-gray-600/50 transition-all duration-300 hover-lift"
                            >
                                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </button>
                            
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-3 rounded-xl bg-white/20 text-gray-600 dark:text-gray-300 hover:bg-white/30 dark:hover:bg-gray-600/50 transition-all duration-300 hover-lift relative">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5v5zM4 17h8m0-3l3-3"></path>
                                    </svg>
                                    @if(\App\Models\Booking::where('status', 'pending')->count() > 0)
                                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-red-500 to-pink-500 rounded-full text-xs font-bold text-white flex items-center justify-center pulse-slow">
                                            {{ \App\Models\Booking::where('status', 'pending')->count() }}
                                        </span>
                                    @endif
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition 
                                     class="absolute right-0 mt-3 w-96 glass-effect rounded-2xl shadow-2xl border border-white/20 z-50">
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Notifications</h3>
                                        <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
                                            @php $pendingBookings = \App\Models\Booking::where('status', 'pending')->latest()->take(5)->get(); @endphp
                                            @forelse($pendingBookings as $booking)
                                                <div class="flex items-start space-x-4 p-3 rounded-xl hover:bg-white/10 transition-all duration-300">
                                                    <div class="w-3 h-3 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mt-2 pulse-slow"></div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">New booking from {{ $booking->customer_name }}</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                                                        <div class="mt-2">
                                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1 rounded-full hover:shadow-lg transition-all duration-300">
                                                                View Details
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-6">
                                                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">All caught up!</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No new notifications</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Admin Profile -->
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <span class="text-white text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Admin - Cholo Bondhu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 min-h-0 p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 glass-effect border border-green-200 rounded-2xl">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-green-800 dark:text-green-200 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 glass-effect border border-red-200 rounded-2xl">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-gradient-to-r from-red-500 to-rose-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <p class="text-red-800 dark:text-red-200 font-semibold">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
