<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 dark:from-gray-900 dark:to-black py-8 px-6 rounded-xl shadow-2xl border border-gray-700 dark:border-gray-800">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-white font-poppins">
                        {{ __('My Profile') }}
                    </h2>
                    <p class="text-gray-300 font-medium">
                        {{ __('Manage your account settings and preferences') }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Information Section -->
            <div class="bg-gradient-to-br from-gray-800 via-gray-800 to-blue-900/20 shadow-2xl dark:shadow-gray-900/50 rounded-2xl border border-gray-700 dark:border-blue-800 transition-all duration-300 hover:shadow-3xl">
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Security Section -->
            <div class="bg-gradient-to-br from-gray-800 via-gray-800 to-indigo-900/20 shadow-2xl dark:shadow-gray-900/50 rounded-2xl border border-gray-700 dark:border-indigo-800 transition-all duration-300 hover:shadow-3xl">
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Management Section -->
            <div class="bg-gradient-to-br from-gray-800 via-gray-800 to-red-900/20 shadow-2xl dark:shadow-gray-900/50 rounded-2xl border border-gray-700 dark:border-red-800 transition-all duration-300 hover:shadow-3xl">
                <div class="p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
