@extends('layouts.admin')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div class="p-6">
    <!-- Success Messages -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="text-blue-600 dark:text-blue-400 text-2xl font-bold">{{ $stats['total'] }}</div>
            <div class="text-blue-700 dark:text-blue-300 text-sm font-medium">Total Users</div>
        </div>
        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
            <div class="text-green-600 dark:text-green-400 text-2xl font-bold">{{ $stats['active'] }}</div>
            <div class="text-green-700 dark:text-green-300 text-sm font-medium">Active</div>
        </div>
        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
            <div class="text-red-600 dark:text-red-400 text-2xl font-bold">{{ $stats['inactive'] }}</div>
            <div class="text-red-700 dark:text-red-300 text-sm font-medium">Inactive</div>
        </div>
        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-800">
            <div class="text-purple-600 dark:text-purple-400 text-2xl font-bold">{{ $stats['admins'] }}</div>
            <div class="text-purple-700 dark:text-purple-300 text-sm font-medium">Admins</div>
        </div>
        <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg border border-indigo-200 dark:border-indigo-800">
            <div class="text-indigo-600 dark:text-indigo-400 text-2xl font-bold">{{ $stats['users'] }}</div>
            <div class="text-indigo-700 dark:text-indigo-300 text-sm font-medium">Regular Users</div>
        </div>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
            <div class="text-yellow-600 dark:text-yellow-400 text-2xl font-bold">{{ $stats['total_bookings'] }}</div>
            <div class="text-yellow-700 dark:text-yellow-300 text-sm font-medium">Total Bookings</div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">User Management</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage user accounts, roles, and permissions</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="refreshUserData()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
            <button onclick="openCreateUserModal()" 
                    class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New User
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search users (name, email, phone)..." 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <select name="role" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admins</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Users</option>
                </select>
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    🔍 Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    @if($users->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                User Info
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Role & Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bookings
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Joined Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->email }}
                                            </div>
                                            @if($user->phone)
                                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                                    📞 {{ $user->phone }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ 
                                            $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'
                                        }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                        <br>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ 
                                            $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                                        }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center space-x-1">
                                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $user->bookings_count }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">bookings</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <!-- Status Toggle Button -->
                                            <button type="button" 
                                                    class="status-toggle-btn inline-flex items-center px-4 py-2 {{ $user->is_active ? 'bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600' : 'bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600' }} text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}"
                                                    data-current-status="{{ $user->is_active ? '1' : '0' }}"
                                                    onclick="showStatusModal({{ json_encode($user->name) }}, '{{ $user->is_active ? 'deactivate' : 'activate' }}', {{ $user->id }}, {{ $user->is_active ? '0' : '1' }})">
                                                    @if($user->is_active)
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        </svg>
                                                        Deactivate
                                                    @else
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Activate
                                                    @endif
                                                </button>
                                            
                                            <!-- Admin Badge - Only show badge for existing admins, no promotion available -->
                                            @if($user->role === 'admin')
                                                <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800 text-sm font-medium rounded-lg border border-purple-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                    </svg>
                                                    Administrator
                                                </span>
                                            @endif
                                            
                                            <!-- Delete Button -->
                                            <button type="button" 
                                                    class="delete-user-btn inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 hover:animate-pulse"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}"
                                                    onclick="showDeleteModal({{ json_encode($user->name) }}, {{ $user->id }})">>
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete User
                                            </button>
                                        @else
                                            <!-- Current User Indicator -->
                                            <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 text-sm font-medium rounded-lg border border-yellow-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Current User (You)
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No users found</h3>
            <p class="text-gray-600 dark:text-gray-400">No users match your current filters.</p>
        </div>
    @endif

    <!-- Create User Modal -->
    <div id="createUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Create New User</h3>
                    </div>
                    <button onclick="closeCreateUserModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                            <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                            <select name="role" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="closeCreateUserModal()" 
                                class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Status Change Confirmation Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div id="statusIcon" class="w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <h3 id="statusTitle" class="text-xl font-bold text-gray-900 dark:text-white">Change User Status</h3>
                </div>
                <p id="statusMessage" class="text-gray-600 dark:text-gray-400 mb-6"></p>
                <div class="flex gap-3">
                    <button onclick="closeStatusModal()" 
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button id="statusConfirmBtn" onclick="confirmStatusChange()" 
                            class="flex-1 px-4 py-2.5 text-white rounded-lg transition-all duration-200 font-medium">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Delete User Account</h3>
                </div>
                <p id="deleteMessage" class="text-gray-600 dark:text-gray-400 mb-4"></p>
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                    <p class="text-red-800 dark:text-red-200 text-sm font-medium mb-2">
                        ⚠️ This action cannot be undone. This will permanently delete:
                    </p>
                    <ul class="text-red-700 dark:text-red-300 text-sm space-y-1 list-disc list-inside">
                        <li>User account and profile</li>
                        <li>All associated bookings</li>
                        <li>All user data and history</li>
                    </ul>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type <strong id="deleteUserName"></strong> to confirm:
                    </label>
                    <input type="text" id="deleteConfirmInput" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter user name to confirm deletion">
                </div>
                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button id="deleteConfirmBtn" onclick="confirmDelete()" disabled
                            class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white rounded-lg transition-all duration-200 font-medium">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Success!</h3>
                </div>
                <p id="successMessage" class="text-gray-600 dark:text-gray-400 mb-6"></p>
                <div class="flex justify-end">
                    <button onclick="closeSuccessModal()" 
                            class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white rounded-lg transition-all duration-200 font-medium">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Error</h3>
                </div>
                <p id="errorMessage" class="text-gray-600 dark:text-gray-400 mb-6"></p>
                <div class="flex justify-end">
                    <button onclick="closeErrorModal()" 
                            class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-200 font-medium">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced button animations and interactions */
    .action-button {
        position: relative;
        overflow: hidden;
    }
    
    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .action-button:hover::before {
        left: 100%;
    }
    
    /* Delete button special effects */
    .delete-button {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .delete-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .delete-button:active {
        transform: translateY(0);
    }
    
    /* Status toggle button effects */
    .status-button {
        transition: all 0.2s ease;
    }
    
    .status-button:hover {
        transform: scale(1.05);
    }
    
    /* Role button effects */
    .role-button {
        transition: all 0.2s ease;
    }
    
    .role-button:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* Pulse animation for critical actions */
    @keyframes pulse-red {
        0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
    }
    
    .delete-button:focus {
        animation: pulse-red 1.5s infinite;
    }
    
    /* Shake animation for error modals */
    @keyframes shake {
        0%, 100% { transform: translateX(0) scale(1); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px) scale(1); }
        20%, 40%, 60%, 80% { transform: translateX(3px) scale(1); }
    }
    
    /* Success modal entrance animation */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<script>
    // CSRF Token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function refreshUserData() {
        // Show loading state
        const refreshBtn = event.target.closest('button');
        const originalContent = refreshBtn.innerHTML;
        refreshBtn.innerHTML = `
            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Refreshing...
        `;
        refreshBtn.disabled = true;
        
        // Reload the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 800);
    }
    
    // Status change modal functions
    let currentUserId = null;
    let currentNewStatus = null;
    
    function showStatusModal(userName, action, userId, newStatus) {
        currentUserId = userId;
        currentNewStatus = newStatus;
        
        const modal = document.getElementById('statusModal');
        const icon = document.getElementById('statusIcon');
        const title = document.getElementById('statusTitle');
        const message = document.getElementById('statusMessage');
        const confirmBtn = document.getElementById('statusConfirmBtn');
        
        if (action === 'activate') {
            icon.className = 'w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-4';
            icon.innerHTML = `<svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>`;
            title.textContent = 'Activate User Account';
            message.textContent = `Are you sure you want to activate ${userName}? This will allow them to access the system.`;
            confirmBtn.className = 'flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 font-medium';
            confirmBtn.textContent = 'Activate User';
        } else {
            icon.className = 'w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mr-4';
            icon.innerHTML = `<svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>`;
            title.textContent = 'Deactivate User Account';
            message.textContent = `Are you sure you want to deactivate ${userName}? This will prevent them from accessing the system.`;
            confirmBtn.className = 'flex-1 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-all duration-200 font-medium';
            confirmBtn.textContent = 'Deactivate User';
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentUserId = null;
        currentNewStatus = null;
    }
    
    function confirmStatusChange() {
        if (!currentUserId || currentNewStatus === null) return;
        
        // Show loading state
        const confirmBtn = document.getElementById('statusConfirmBtn');
        const originalText = confirmBtn.textContent;
        confirmBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Updating...';
        confirmBtn.disabled = true;
        
        // Make AJAX request
        fetch(`/admin/users/${currentUserId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_active: currentNewStatus
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            closeStatusModal();
            if (data.success) {
                // Update the button in the table immediately
                updateUserStatusInTable(currentUserId, currentNewStatus);
                // Update the status badge
                updateUserStatusBadge(currentUserId, currentNewStatus);
                // Show success message
                const actionText = currentNewStatus == '1' ? 'activated' : 'deactivated';
                showSuccessModal(`User has been successfully ${actionText}!`);
            } else {
                showErrorModal(data.message || 'An error occurred while updating user status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            closeStatusModal();
            showErrorModal('An error occurred while updating user status. Please try again.');
        })
        .finally(() => {
            confirmBtn.textContent = originalText;
            confirmBtn.disabled = false;
        });
    }
    
    // Delete modal functions
    let currentDeleteUserId = null;
    let expectedUserName = '';
    
    function showDeleteModal(userName, userId) {
        currentDeleteUserId = userId;
        expectedUserName = userName;
        
        const modal = document.getElementById('deleteModal');
        const message = document.getElementById('deleteMessage');
        const userNameSpan = document.getElementById('deleteUserName');
        const input = document.getElementById('deleteConfirmInput');
        const confirmBtn = document.getElementById('deleteConfirmBtn');
        
        message.textContent = `Are you sure you want to permanently delete ${userName}?`;
        userNameSpan.textContent = userName;
        input.value = '';
        confirmBtn.disabled = true;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Focus on input
        setTimeout(() => input.focus(), 100);
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteUserId = null;
        expectedUserName = '';
    }
    
    function confirmDelete() {
        if (!currentDeleteUserId) {
            return;
        }
        
        // Show loading state
        const confirmBtn = document.getElementById('deleteConfirmBtn');
        confirmBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Deleting...';
        confirmBtn.disabled = true;
        
        console.log('Making DELETE request to:', `/admin/users/${currentDeleteUserId}`);
        
        // Make AJAX request
        fetch(`/admin/users/${currentDeleteUserId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response received:', response.status, response.statusText);
            
            // Log the full response text for debugging
            return response.text().then(text => {
                console.log('Response body:', text);
                
                // Try to parse as JSON
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    throw new Error('Invalid JSON response');
                }
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status} - ${data.message || text}`);
                }
                
                return data;
            });
        })
        .then(data => {
            console.log('Parsed response data:', data);
            closeDeleteModal();
            if (data.success) {
                // Get user name before removing from table
                const button = document.querySelector(`button[data-user-id="${currentDeleteUserId}"]`);
                const userName = button ? button.dataset.userName : 'User';
                
                // Remove the user row from the table with animation
                removeUserFromTable(currentDeleteUserId);
                
                // Show success message
                showSuccessModal(`${userName} has been successfully deleted!`);
            } else {
                console.error('Deletion failed:', data.message);
                showErrorModal(data.message || 'An error occurred while deleting user.');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            closeDeleteModal();
            showErrorModal('An error occurred while deleting user. Please try again. Check console for details.');
        })
        .finally(() => {
            confirmBtn.innerHTML = 'Delete User';
            confirmBtn.disabled = false;
        });
    }
    
    // Success modal functions
    function showSuccessModal(message) {
        const modal = document.getElementById('successModal');
        const messageEl = document.getElementById('successMessage');
        messageEl.textContent = message;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Add entrance animation
        const modalContent = modal.querySelector('.bg-white');
        modalContent.style.transform = 'scale(0.8)';
        modalContent.style.opacity = '0';
        modalContent.style.transition = 'all 0.3s ease-out';
        
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }, 10);
        
        // Auto close after 4 seconds with countdown
        let countdown = 4;
        const okButton = modal.querySelector('button');
        const originalText = okButton.textContent;
        
        const countdownInterval = setInterval(() => {
            countdown--;
            okButton.textContent = `OK (${countdown})`;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                closeSuccessModal();
            }
        }, 1000);
        
        // Store interval ID to clear it if user closes manually
        modal.dataset.countdownInterval = countdownInterval;
    }
    
    function closeSuccessModal() {
        const modal = document.getElementById('successModal');
        
        // Clear countdown interval if exists
        if (modal.dataset.countdownInterval) {
            clearInterval(modal.dataset.countdownInterval);
            delete modal.dataset.countdownInterval;
        }
        
        // Reset button text
        const okButton = modal.querySelector('button');
        okButton.textContent = 'OK';
        
        // Add exit animation
        const modalContent = modal.querySelector('.bg-white');
        modalContent.style.transform = 'scale(0.8)';
        modalContent.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset for next time
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }, 300);
    }
    
    // Error modal functions
    function showErrorModal(message) {
        const modal = document.getElementById('errorModal');
        const messageEl = document.getElementById('errorMessage');
        messageEl.textContent = message;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Add entrance animation with shake effect for error
        const modalContent = modal.querySelector('.bg-white');
        modalContent.style.transform = 'scale(0.8)';
        modalContent.style.opacity = '0';
        modalContent.style.transition = 'all 0.3s ease-out';
        
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
            
            // Add shake animation for error emphasis
            modalContent.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                modalContent.style.animation = '';
            }, 500);
        }, 10);
    }
    
    function closeErrorModal() {
        const modal = document.getElementById('errorModal');
        const modalContent = modal.querySelector('.bg-white');
        
        // Add exit animation
        modalContent.style.transform = 'scale(0.8)';
        modalContent.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset for next time
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }, 300);
    }
    
    // Helper functions to update the UI
    function updateUserStatusInTable(userId, newStatus) {
        const button = document.querySelector(`button[data-user-id="${userId}"]`);
        if (!button) return;
        
        const userName = button.dataset.userName;
        
        if (newStatus == '1') {
            // User is now active
            button.className = 'status-toggle-btn inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105';
            button.innerHTML = `<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>Deactivate`;
            button.setAttribute('onclick', `showStatusModal(${JSON.stringify(userName)}, 'deactivate', ${userId}, 0)`);
        } else {
            // User is now inactive
            button.className = 'status-toggle-btn inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105';
            button.innerHTML = `<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>Activate`;
            button.setAttribute('onclick', `showStatusModal(${JSON.stringify(userName)}, 'activate', ${userId}, 1)`);
        }
    }
    
    function updateUserStatusBadge(userId, newStatus) {
        const button = document.querySelector(`button[data-user-id="${userId}"]`);
        if (!button) return;
        
        const row = button.closest('tr');
        const statusBadge = row.querySelector('.status-badge');
        
        if (statusBadge) {
            if (newStatus == '1') {
                // User is now active
                statusBadge.className = 'status-badge inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200';
                statusBadge.innerHTML = `
                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Active
                `;
            } else {
                // User is now inactive
                statusBadge.className = 'status-badge inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200';
                statusBadge.innerHTML = `
                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    Inactive
                `;
            }
            
            // Add a brief highlight animation to show the change
            statusBadge.style.transform = 'scale(1.1)';
            statusBadge.style.transition = 'transform 0.2s ease-in-out';
            setTimeout(() => {
                statusBadge.style.transform = 'scale(1)';
            }, 200);
        }
    }
    
    function removeUserFromTable(userId) {
        const button = document.querySelector(`button[data-user-id="${userId}"]`);
        if (button) {
            const row = button.closest('tr');
            
            // Add removal animation
            row.style.transition = 'all 0.5s ease-out';
            row.style.transform = 'translateX(100px)';
            row.style.opacity = '0';
            row.style.backgroundColor = '#fef2f2'; // Light red background
            
            // Remove the row after animation completes
            setTimeout(() => {
                row.remove();
                
                // If no more rows, show empty state
                const tbody = document.querySelector('table tbody');
                if (tbody && tbody.children.length === 0) {
                    // Reload the page to show the "no users found" message
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            }, 500);
        }
    }
    
    // Enable/disable delete button based on input
    document.addEventListener('DOMContentLoaded', function() {
        const deleteInput = document.getElementById('deleteConfirmInput');
        const deleteBtn = document.getElementById('deleteConfirmBtn');
        
        if (deleteInput && deleteBtn) {
            deleteInput.addEventListener('input', function() {
                // Get the current expected user name from the modal
                const expectedName = document.getElementById('deleteUserName').textContent;
                if (this.value.trim() === expectedName) {
                    deleteBtn.disabled = false;
                    deleteBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
                } else {
                    deleteBtn.disabled = true;
                    deleteBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
                }
            });
        }
    });
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateUserModal();
            closeStatusModal();
            closeDeleteModal();
            closeSuccessModal();
            closeErrorModal();
        }
    });
</script>
@endsection