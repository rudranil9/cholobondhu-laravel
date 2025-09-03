@extends('layouts.admin')

@section('title', 'Booking Management')
@section('page-title', 'Booking Management')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    📋 Booking Management
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Manage all customer bookings and update their status
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Total Bookings: <span class="font-bold text-blue-600">{{ $stats['total'] }}</span>
                </p>
            </div>
        </div>
    </div>

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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="text-blue-600 dark:text-blue-400 text-2xl font-bold">{{ $stats['total'] }}</div>
            <div class="text-blue-700 dark:text-blue-300 text-sm font-medium">Total Bookings</div>
        </div>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
            <div class="text-yellow-600 dark:text-yellow-400 text-2xl font-bold">{{ $stats['pending'] }}</div>
            <div class="text-yellow-700 dark:text-yellow-300 text-sm font-medium">Pending</div>
        </div>
        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="text-blue-600 dark:text-blue-400 text-2xl font-bold">{{ $stats['in_process'] }}</div>
            <div class="text-blue-700 dark:text-blue-300 text-sm font-medium">In Process</div>
        </div>
        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
            <div class="text-green-600 dark:text-green-400 text-2xl font-bold">{{ $stats['confirmed'] }}</div>
            <div class="text-green-700 dark:text-green-300 text-sm font-medium">Confirmed</div>
        </div>
        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
            <div class="text-red-600 dark:text-red-400 text-2xl font-bold">{{ $stats['cancelled'] }}</div>
            <div class="text-red-700 dark:text-red-300 text-sm font-medium">Cancelled</div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="text-gray-600 dark:text-gray-400 text-2xl font-bold">{{ $stats['rejected'] }}</div>
            <div class="text-gray-700 dark:text-gray-300 text-sm font-medium">Rejected</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search bookings (name, email, destination, ticket)..." 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_process" {{ request('status') === 'in_process' ? 'selected' : '' }}>In Process</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    🔍 Filter
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                    Clear
                </a>
            </div>
        </form>
    </div>

    @if($bookings->count() > 0)
        <!-- Bookings Table -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Customer & Ticket
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Trip Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Travel Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Booking Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($bookings as $booking)
                            @php
                                $ticketNumber = null;
                                if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
                                    $ticketNumber = $matches[1];
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $booking->customer_name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $booking->customer_email }}
                                        </div>
                                        @if($ticketNumber)
                                            <div class="text-xs font-mono bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 px-2 py-1 rounded mt-1">
                                                🎫 {{ $ticketNumber }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            📍 {{ $booking->destination }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            👥 {{ $booking->number_of_travelers }} traveler(s)
                                        </div>
                                        @if($booking->budget_range)
                                            <div class="text-sm text-green-600 dark:text-green-400">
                                                💰 {{ $booking->budget_range }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    @if($booking->start_date)
                                        <div>{{ $booking->start_date->format('M d, Y') }}</div>
                                        @if($booking->end_date)
                                            <div class="text-gray-500 dark:text-gray-400">to {{ $booking->end_date->format('M d, Y') }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">TBD</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ 
                                        $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : (
                                        $booking->status === 'in_process' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : (
                                        $booking->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : (
                                        $booking->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 
                                        'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400')))
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $booking->booking_date->format('M d, Y') }}
                                    <div class="text-xs text-gray-400">{{ $booking->booking_date->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                        <!-- View Button -->
                                        <button onclick="viewBooking({{ $booking->id }})" 
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </button>
                                        
                                        @if($booking->status !== 'cancelled')
                                            <!-- Update Status Button -->
                                            <button onclick="openStatusModal({{ $booking->id }}, '{{ $booking->status }}')" 
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Update Status
                                            </button>
                                        @endif
                                        
                                        <!-- Delete Button -->
                                        <button onclick="openDeleteModal({{ $booking->id }}, {{ json_encode($booking->customer_name) }}, {{ json_encode($booking->destination) }})" 
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 hover:animate-pulse">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete Booking
                                        </button>
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
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Bookings Found</h3>
            <p class="text-gray-600 dark:text-gray-400">No bookings match your current filters.</p>
        </div>
    @endif
</div>

<!-- Booking Details Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full max-h-screen overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white">📋 Booking Details</h2>
                    <button onclick="closeBookingModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div id="modalContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">⚙️ Update Status</h2>
                    <button onclick="closeStatusModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <form id="statusForm" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        New Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select status...</option>
                        <option value="pending">🕐 Pending</option>
                        <option value="in_process">⚙️ In Process</option>
                        <option value="confirmed">✅ Confirmed</option>
                        <option value="rejected">❌ Rejected</option>
                        <option value="cancelled">🚫 Cancelled</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Admin Notes (Optional)
                    </label>
                    <textarea id="admin_notes" name="admin_notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Add any notes for the customer..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">These notes will be sent to the customer and added to booking history.</p>
                </div>
                
                <div class="flex space-x-4 mt-6">
                    <button type="button" onclick="closeStatusModal()" 
                            class="flex-1 px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium text-center">
                        ❌ Cancel
                    </button>
                    <button type="submit" id="statusSubmitBtn"
                            class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium text-center">
                        ✅ Update Status
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
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-600 to-pink-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">🗑️ Delete Booking</h2>
                    <button onclick="closeDeleteModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Are you sure?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        You are about to permanently delete this booking:
                    </p>
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg mb-4">
                        <p class="font-medium text-gray-900 dark:text-white" id="deleteBookingDetails">
                            <!-- Details will be populated by JavaScript -->
                        </p>
                    </div>
                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">
                        ⚠️ This action cannot be undone!
                    </p>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium text-center">
                        ❌ Cancel
                    </button>
                    <button type="button" onclick="confirmDelete()" id="deleteSubmitBtn"
                            class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium text-center">
                        🗑️ Delete Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Booking data for modal
    @php
        $bookingData = $bookings->map(function($booking) {
            $ticketNumber = null;
            if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
                $ticketNumber = $matches[1];
            }
            return [
                'id' => $booking->id,
                'ticket_number' => $ticketNumber,
                'customer_name' => $booking->customer_name,
                'customer_email' => $booking->customer_email,
                'customer_phone' => $booking->customer_phone,
                'destination' => $booking->destination,
                'start_date' => $booking->start_date ? $booking->start_date->format('M d, Y') : null,
                'end_date' => $booking->end_date ? $booking->end_date->format('M d, Y') : null,
                'number_of_travelers' => $booking->number_of_travelers,
                'budget_range' => $booking->budget_range,
                'special_requirements' => $booking->special_requirements,
                'booking_date' => $booking->booking_date->format('M d, Y \\a\\t g:i A'),
                'status' => $booking->status,
                'notes' => $booking->notes
            ];
        });
    @endphp
    const bookings = @json($bookingData);
    
    function viewBooking(bookingId) {
        const booking = bookings.find(b => b.id === bookingId);
        if (!booking) return;
        
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Ticket Number -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">🎫 Ticket Information</h3>
                        <p class="text-2xl font-mono font-bold text-blue-600 dark:text-blue-400">${booking.ticket_number || 'N/A'}</p>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">👤 Customer Information</h3>
                        <div class="space-y-2">
                            <div><span class="font-medium">Name:</span> ${booking.customer_name}</div>
                            <div><span class="font-medium">Email:</span> ${booking.customer_email}</div>
                            <div><span class="font-medium">Phone:</span> ${booking.customer_phone}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Trip Information -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">🏖️ Trip Information</h3>
                        <div class="space-y-2">
                            <div><span class="font-medium">Destination:</span> ${booking.destination}</div>
                            <div><span class="font-medium">Travelers:</span> ${booking.number_of_travelers} people</div>
                            ${booking.budget_range ? `<div><span class="font-medium">Budget:</span> ${booking.budget_range}</div>` : ''}
                            ${booking.start_date ? `<div><span class="font-medium">Travel Dates:</span> ${booking.start_date}${booking.end_date ? ' to ' + booking.end_date : ''}</div>` : ''}
                            <div><span class="font-medium">Booking Date:</span> ${booking.booking_date}</div>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">📊 Current Status</h3>
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-bold ${
                            booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            booking.status === 'in_process' ? 'bg-blue-100 text-blue-800' :
                            booking.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                            booking.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                            'bg-gray-100 text-gray-800'
                        }">
                            ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1).replace('_', ' ')}
                        </span>
                    </div>
                </div>
                
                ${booking.special_requirements ? `
                <!-- Special Requirements -->
                <div class="lg:col-span-2">
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200 mb-2">📝 Special Requirements</h3>
                        <p class="text-amber-700 dark:text-amber-300">${booking.special_requirements}</p>
                    </div>
                </div>
                ` : ''}
                
                <!-- Booking Notes -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">📋 Booking Notes</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">${booking.notes || 'No notes available'}</p>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('bookingModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeBookingModal() {
        document.getElementById('bookingModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function openStatusModal(bookingId, currentStatus) {
        console.log('Opening status modal for booking:', bookingId, 'current status:', currentStatus);
        
        const form = document.getElementById('statusForm');
        form.action = `{{ url('/admin/bookings') }}/${bookingId}/status`;
        
        console.log('Form action set to:', form.action);
        
        // Set current status as selected
        const statusSelect = document.getElementById('status');
        statusSelect.value = currentStatus;
        
        // Clear any previous notes
        const notesTextarea = document.getElementById('admin_notes');
        if (notesTextarea) {
            notesTextarea.value = '';
        }
        
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('statusForm').reset();
    }
    
    // Close modals when clicking outside
    document.getElementById('bookingModal').addEventListener('click', function(e) {
        if (e.target === this) closeBookingModal();
    });
    
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBookingModal();
            closeStatusModal();
            closeDeleteModal();
        }
    });

    // Delete Modal Functions
    let currentDeleteBookingId = null;
    
    function openDeleteModal(bookingId, customerName, destination) {
        console.log('Opening delete modal for booking:', bookingId, customerName, destination);
        
        currentDeleteBookingId = bookingId;
        
        // Update modal content with booking details
        const deleteDetails = document.getElementById('deleteBookingDetails');
        deleteDetails.innerHTML = `
            <strong>Customer:</strong> ${customerName}<br>
            <strong>Destination:</strong> ${destination}<br>
            <strong>Booking ID:</strong> #${bookingId}
        `;
        
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteBookingId = null;
    }
    
    function confirmDelete() {
        if (!currentDeleteBookingId) {
            console.error('No booking ID set for deletion');
            return;
        }
        
        const deleteBtn = document.getElementById('deleteSubmitBtn');
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '⏳ Deleting...';
        
        // Create form for DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/admin/bookings') }}/${currentDeleteBookingId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        console.log('Submitting delete form for booking:', currentDeleteBookingId);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBookingModal();
            closeStatusModal();
        }
    });
    
    // Add form submission debugging
    document.getElementById('statusForm').addEventListener('submit', function(e) {
        console.log('Status form submitted');
        console.log('Form action:', this.action);
        console.log('Form data:', new FormData(this));
        
        const statusValue = document.getElementById('status').value;
        if (!statusValue) {
            e.preventDefault();
            alert('Please select a status');
            return false;
        }
        
        console.log('Selected status:', statusValue);
        // Form will submit normally
    });
</script>
@endsection
