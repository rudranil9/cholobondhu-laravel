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
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
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

    <!-- Header with Add User Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">👥 User Management</h2>
        <button onclick="openCreateUserModal()" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            ➕ Add New User
        </button>
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

    @if($users->count() > 0)
        <!-- Users Table -->
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="viewUser({{ $user->id }})" 
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            View
                                        </button>
                                        <button onclick="openStatusModal({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})" 
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                        @if($user->role !== 'admin' || $user->id !== auth()->id())
                                            <button onclick="openRoleModal({{ $user->id }}, '{{ $user->role }}')" 
                                                    class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                                Role
                                            </button>
                                        @endif
                                        @if($user->id !== auth()->id())
                                            <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
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
        <div class="mt-6">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Users Found</h3>
            <p class="text-gray-600 dark:text-gray-400">No users match your current filters.</p>
        </div>
    @endif
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full max-h-screen overflow-y-auto">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white">👤 User Details</h2>
                    <button onclick="closeUserModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="userModalContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white" id="statusModalTitle">⚙️ Update Status</h2>
                    <button onclick="closeStatusModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="statusForm" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                
                <input type="hidden" id="statusIsActive" name="is_active">
                
                <div class="mb-6">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Admin Notes (Optional)
                    </label>
                    <textarea id="admin_notes" name="admin_notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Add any notes for the user..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">These notes will be sent to the user via email.</p>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeStatusModal()" 
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" id="statusSubmitBtn"
                            class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Role Update Modal -->
<div id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">👑 Update Role</h2>
                    <button onclick="closeRoleModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="roleForm" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        New Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role" name="role" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                        <option value="user">👤 User</option>
                        <option value="admin">👑 Admin</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label for="role_admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Admin Notes (Optional)
                    </label>
                    <textarea id="role_admin_notes" name="admin_notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Reason for role change..."></textarea>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeRoleModal()" 
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors font-medium">
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-green-600 to-blue-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">➕ Create New User</h2>
                    <button onclick="closeCreateUserModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="createUserForm" method="POST" action="{{ route('admin.users.store') }}" class="p-6">
                @csrf
                
                <div class="mb-4">
                    <label for="create_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input id="create_name" name="name" type="text" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="create_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input id="create_email" name="email" type="email" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="create_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Phone (Optional)
                    </label>
                    <input id="create_phone" name="phone" type="tel" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="create_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input id="create_password" name="password" type="password" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="create_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input id="create_password_confirmation" name="password_confirmation" type="password" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="create_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="create_role" name="role" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <option value="user">👤 User</option>
                        <option value="admin">👑 Admin</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label for="create_is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="create_is_active" name="is_active" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <option value="1">✅ Active</option>
                        <option value="0">❌ Inactive</option>
                    </select>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeCreateUserModal()" 
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-red-600 to-pink-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">🗑️ Delete User</h2>
                    <button onclick="closeDeleteModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Are you sure?</h3>
                    <p class="text-gray-600 dark:text-gray-400">You are about to delete user "<span id="deleteUserName" class="font-semibold"></span>". This action cannot be undone.</p>
                </div>
                
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeDeleteModal()" 
                                class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium">
                            Delete User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // User data for modal
    const users = @json($users->map(function($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'bookings_count' => $user->bookings_count,
            'created_at' => $user->created_at->format('M d, Y g:i A'),
            'created_diff' => $user->created_at->diffForHumans()
        ];
    }));
    
    function viewUser(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;
        
        const modalContent = document.getElementById('userModalContent');
        modalContent.innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <!-- User Info -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">👤 User Information</h3>
                        <div class="space-y-2">
                            <div><span class="font-medium">Name:</span> ${user.name}</div>
                            <div><span class="font-medium">Email:</span> ${user.email}</div>
                            <div><span class="font-medium">Phone:</span> ${user.phone || 'Not provided'}</div>
                            <div><span class="font-medium">Member Since:</span> ${user.created_at}</div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <!-- Status & Role -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">📊 Status & Role</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span>Role:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium ${
                                    user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'
                                }">${user.role === 'admin' ? '👑 Admin' : '👤 User'}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Status:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium ${
                                    user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                }">${user.is_active ? '✅ Active' : '❌ Inactive'}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Total Bookings:</span>
                                <span class="font-bold text-blue-600">${user.bookings_count}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('userModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function openStatusModal(userId, isActive) {
        console.log('Opening status modal for user:', userId, 'is active:', isActive);
        
        const user = users.find(u => u.id === userId);
        if (!user) {
            console.error('User not found with ID:', userId);
            return;
        }
        
        const form = document.getElementById('statusForm');
        const title = document.getElementById('statusModalTitle');
        const submitBtn = document.getElementById('statusSubmitBtn');
        const statusInput = document.getElementById('statusIsActive');
        
        form.action = `{{ url('/admin/users') }}/${userId}/status`;
        
        console.log('User status form action set to:', form.action);
        
        // Reset button classes
        submitBtn.className = 'flex-1 px-4 py-2 text-white rounded-lg transition-colors font-medium';
        
        if (isActive) {
            title.textContent = '❌ Deactivate User';
            submitBtn.textContent = 'Deactivate User';
            submitBtn.className += ' bg-red-600 hover:bg-red-700';
            statusInput.value = '0';
        } else {
            title.textContent = '✅ Activate User';
            submitBtn.textContent = 'Activate User';
            submitBtn.className += ' bg-green-600 hover:bg-green-700';
            statusInput.value = '1';
        }
        
        // Clear previous admin notes
        const adminNotesTextarea = document.getElementById('admin_notes');
        if (adminNotesTextarea) {
            adminNotesTextarea.value = '';
        }
        
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('statusForm').reset();
    }
    
    function openRoleModal(userId, currentRole) {
        const form = document.getElementById('roleForm');
        const roleSelect = document.getElementById('role');
        
        form.action = `{{ url('/admin/users') }}/${userId}/role`;
        roleSelect.value = currentRole;
        
        document.getElementById('roleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeRoleModal() {
        document.getElementById('roleModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('roleForm').reset();
    }
    
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('createUserForm').reset();
    }
    
    function openDeleteModal(userId, userName) {
        const form = document.getElementById('deleteForm');
        const nameSpan = document.getElementById('deleteUserName');
        
        form.action = `{{ url('/admin/users') }}/${userId}`;
        nameSpan.textContent = userName;
        
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close modals when clicking outside
    ['userModal', 'statusModal', 'roleModal', 'createUserModal', 'deleteModal'].forEach(modalId => {
        document.getElementById(modalId).addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            ['userModal', 'statusModal', 'roleModal', 'createUserModal', 'deleteModal'].forEach(modalId => {
                document.getElementById(modalId).classList.add('hidden');
            });
            document.body.style.overflow = 'auto';
        }
    });
    
    // Add form submission debugging
    document.getElementById('statusForm').addEventListener('submit', function(e) {
        console.log('User status form submitted');
        console.log('Form action:', this.action);
        const formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        const isActiveValue = document.getElementById('statusIsActive').value;
        console.log('is_active value:', isActiveValue);
        // Form will submit normally
    });
    
    document.getElementById('roleForm').addEventListener('submit', function(e) {
        console.log('User role form submitted');
        console.log('Form action:', this.action);
        const formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
    });
    
    document.getElementById('createUserForm').addEventListener('submit', function(e) {
        console.log('Create user form submitted');
        console.log('Form action:', this.action);
        const formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
    });
    
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        console.log('Delete user form submitted');
        console.log('Form action:', this.action);
        const formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
    });
</script>
@endsection
