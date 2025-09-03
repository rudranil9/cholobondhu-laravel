@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Welcome Header -->
<div class="mb-8">
    <div class="stats-card rounded-3xl p-8 text-white shadow-2xl hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-white/80 text-lg">Here's what's happening with your Cholo Bondhu platform today</p>
                <div class="mt-4 flex items-center space-x-6 text-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full pulse-slow"></div>
                        <span class="text-white/70">System Status: Online</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-white/70">Last login: {{ Auth::user()->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="w-32 h-32 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <!-- Total Bookings -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Bookings</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $bookingStats['total'] }}</p>
                <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                    <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ $bookingStats['recent'] }} this week
                    </span>
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Bookings -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Bookings</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $bookingStats['pending'] }}</p>
                <p class="text-sm text-orange-600 dark:text-orange-400 mt-1">
                    <span class="inline-flex items-center">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 pulse-slow"></div>
                        Needs attention
                    </span>
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $userStats['total'] }}</p>
                <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                    <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ $userStats['recent'] }} new this week
                    </span>
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Users</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $userStats['active'] }}</p>
                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                    <span class="inline-flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 pulse-slow"></div>
                        {{ round(($userStats['active'] / $userStats['total']) * 100) }}% active rate
                    </span>
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Booking Status Chart -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Booking Status Overview</h3>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Live Data</span>
            </div>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Confirmed</span>
                </div>
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $bookingStats['confirmed'] }}</span>
            </div>
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-gradient-to-r from-orange-500 to-red-500 rounded-full pulse-slow"></div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Pending</span>
                </div>
                <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $bookingStats['pending'] }}</span>
            </div>
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full"></div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">In Process</span>
                </div>
                <span class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $bookingStats['in_process'] }}</span>
            </div>
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-gradient-to-r from-red-500 to-rose-500 rounded-full"></div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Cancelled/Rejected</span>
                </div>
                <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $bookingStats['cancelled'] + $bookingStats['rejected'] }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Activity</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-full hover:shadow-lg transition-all duration-300">
                View All
            </a>
        </div>
        <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
            @forelse($recentBookings as $booking)
                <div class="flex items-start space-x-4 p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20 hover:bg-white/70 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <span class="text-white text-sm font-bold">{{ substr($booking->customer_name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $booking->customer_name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $booking->destination }} • {{ $booking->created_at->diffForHumans() }}</p>
                        <div class="mt-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ 
                                $booking->status === 'confirmed' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
                                ($booking->status === 'pending' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' :
                                ($booking->status === 'in_process' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white' : 'bg-gradient-to-r from-gray-500 to-gray-600 text-white'))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No recent bookings</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Manage Bookings -->
    <a href="{{ route('admin.bookings.index') }}" 
       class="stats-card rounded-2xl p-6 hover-lift group text-center transition-all duration-300 hover:scale-105">
        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-all duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
            Manage Bookings
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">View and update booking status</p>
        <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-full inline-block">
            <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $bookingStats['pending'] }} pending</span>
        </div>
    </a>

    <!-- Manage Users -->
    <a href="{{ route('admin.users.index') }}" 
       class="stats-card rounded-2xl p-6 hover-lift group text-center transition-all duration-300 hover:scale-105">
        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-all duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
            Manage Users
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">User accounts and permissions</p>
        <div class="mt-4 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-full inline-block">
            <span class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $userStats['total'] }} users</span>
        </div>
    </a>

    <!-- Tour Packages -->
    <a href="{{ route('admin.tour-packages.index') }}" 
       class="stats-card rounded-2xl p-6 hover-lift group text-center transition-all duration-300 hover:scale-105">
        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-all duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
            Tour Packages
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Manage destinations and packages</p>
        <div class="mt-4 bg-purple-50 dark:bg-purple-900/20 px-3 py-1 rounded-full inline-block">
            <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">Manage packages</span>
        </div>
    </a>
</div>

<!-- Recent Users -->
<div class="stats-card rounded-2xl p-6 hover-lift">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Users</h3>
        <a href="{{ route('admin.users.index') }}" class="text-sm bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-full hover:shadow-lg transition-all duration-300">
            View All
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($recentUsers as $user)
            <div class="flex items-center space-x-4 p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20 hover:bg-white/70 dark:hover:bg-gray-700/50 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                    <span class="text-white text-sm font-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    <div class="mt-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ 
                            $user->role === 'admin' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white'
                        }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="ml-1 px-2 py-1 text-xs font-semibold rounded-full {{ 
                            $user->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' : 'bg-gradient-to-r from-gray-500 to-gray-600 text-white'
                        }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8">
                <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">No recent users</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
