@extends('layouts.app')

@section('title', 'Tour Packages Management - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Tour Packages Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage your tour packages and destinations</p>
        </div>

        <!-- Coming Soon Notice -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <div class="text-6xl mb-4">🚧</div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Coming Soon</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Tour package management functionality is under development.</p>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
