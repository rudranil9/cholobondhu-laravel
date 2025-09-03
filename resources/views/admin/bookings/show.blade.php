@extends('layouts.admin')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')
<div class="p-6">
    <!-- Header ---->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    📋 Booking Details
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Detailed view of booking information
                </p>
            </div>
            <div>
                <a href="{{ route('admin.bookings.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                    ← Back to Bookings
                </a>
            </div>
        </div>
    </div>

    <!-- Booking Information Card -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <!-- Ticket Number Header -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 p-6 rounded-lg mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">🎫 {{ $ticketNumber ?? 'N/A' }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">Ticket Number</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ 
                            $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : (
                            $booking->status === 'in_process' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : (
                            $booking->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : (
                            $booking->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 
                            'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400')))
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Customer Information -->
                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">👤 Customer Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Name:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->customer_name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->customer_email }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Phone:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->customer_phone }}</span>
                        </div>
                        @if($booking->user)
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Account:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->user->name }} ({{ $booking->user->email }})</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Trip Information -->
                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🏖️ Trip Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Destination:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->destination }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Travelers:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->number_of_travelers }} person(s)</span>
                        </div>
                        @if($booking->budget_range)
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Budget:</span>
                            <span class="text-green-600 dark:text-green-400 font-medium">{{ $booking->budget_range }}</span>
                        </div>
                        @endif
                        @if($booking->start_date)
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Travel Dates:</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ $booking->start_date->format('M d, Y') }}
                                @if($booking->end_date) 
                                    to {{ $booking->end_date->format('M d, Y') }}
                                @endif
                            </span>
                        </div>
                        @else
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Travel Dates:</span>
                            <span class="text-gray-500 dark:text-gray-400">To be determined</span>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Booking Date:</span>
                            <span class="text-gray-900 dark:text-white">{{ $booking->booking_date->format('M d, Y \\a\\t g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Requirements -->
            @if($booking->special_requirements)
            <div class="mt-6">
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200 mb-3">📝 Special Requirements</h3>
                    <p class="text-amber-700 dark:text-amber-300">{{ $booking->special_requirements }}</p>
                </div>
            </div>
            @endif

            <!-- Booking Notes -->
            <div class="mt-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">📋 Booking Notes & History</h3>
                    <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $booking->notes ?? 'No notes available' }}</div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if($booking->status !== 'cancelled')
            <div class="mt-6 flex space-x-4">
                <button onclick="openStatusModal({{ $booking->id }}, '{{ $booking->status }}')" 
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    ⚙️ Update Status
                </button>
            </div>
            @endif
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
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeStatusModal()" 
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openStatusModal(bookingId, currentStatus) {
        const form = document.getElementById('statusForm');
        form.action = `{{ url('/admin/bookings') }}/${bookingId}/status`;
        
        // Set current status as selected
        document.getElementById('status').value = currentStatus;
        
        // Clear notes
        document.getElementById('admin_notes').value = '';
        
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('statusForm').reset();
    }
    
    // Close modal when clicking outside
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStatusModal();
        }
    });
</script>
@endsection
