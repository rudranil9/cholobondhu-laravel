@extends('layouts.app')

@section('title', 'My Bookings - Cholo Bondhu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                🎫 My Travel Bookings
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                Track and manage all your travel bookings
            </p>
        </div>

        <!-- Success Messages -->
        @if (session('success'))
            <div class="mb-8 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg animate-slide-down">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                @if (session('ticket_number'))
                    <div class="mt-2 p-3 bg-white dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded text-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Your Ticket Number:</span>
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400 tracking-wider">
                            {{ session('ticket_number') }}
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if($bookings->count() > 0)
            <!-- Bookings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <!-- Booking Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1">
                                        📍 {{ $booking->destination }}
                                    </h3>
                                    @php
                                        $ticketNumber = null;
                                        if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
                                            $ticketNumber = $matches[1];
                                        }
                                    @endphp
                                    @if($ticketNumber)
                                        <p class="text-blue-100 text-sm font-mono">
                                            🎫 {{ $ticketNumber }}
                                        </p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    @if($booking->start_date)
                                        <span>{{ $booking->start_date->format('M d, Y') }}</span>
                                        @if($booking->end_date)
                                            <span class="mx-2">→</span>
                                            <span>{{ $booking->end_date->format('M d, Y') }}</span>
                                        @endif
                                    @else
                                        <span>Date to be confirmed</span>
                                    @endif
                                </div>

                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <span>{{ $booking->number_of_travelers }} Traveler(s)</span>
                                </div>

                                @if($booking->budget_range)
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <span>{{ $booking->budget_range }}</span>
                                </div>
                                @endif

                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Booked {{ $booking->booking_date->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                                <button 
                                    onclick="openBookingModal({{ $booking->id }})"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition-colors duration-300 font-medium"
                                >
                                    View Details
                                </button>
                                
                                @if($booking->status === 'pending')
                                <button 
                                    onclick="openCancellationModal({{ $booking->id }})"
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 font-medium"
                                >
                                    Cancel Booking
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 animate-fade-in">
                <div class="w-32 h-32 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    No Bookings Yet
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                    You haven't made any bookings yet. Start planning your next adventure!
                </p>
                <a 
                    href="{{ route('tours.index') }}" 
                    class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Explore Tours</span>
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Booking Details Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="mr-2">🎫</span>
                        Booking Details
                    </h2>
                    <button onclick="closeBookingModal()" class="text-white hover:text-gray-200 transition-colors">
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

<!-- Cancellation Reason Modal -->
<div id="cancellationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="mr-2">⚠️</span>
                        Cancel Booking
                    </h2>
                    <button onclick="closeCancellationModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <form id="cancellationForm" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                
                <div class="mb-6">
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        Please provide a reason for cancelling this booking. This information helps us improve our services.
                    </p>
                    
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cancellation Reason <span class="text-red-500">*</span>
                    </label>
                    
                    <select id="cancellation_reason" name="cancellation_reason" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select a reason...</option>
                        <option value="change_of_plans">Change of Plans</option>
                        <option value="financial_reasons">Financial Reasons</option>
                        <option value="emergency">Emergency/Unforeseen Circumstances</option>
                        <option value="found_better_option">Found a Better Option</option>
                        <option value="health_issues">Health Issues</option>
                        <option value="work_commitments">Work Commitments</option>
                        <option value="family_reasons">Family Reasons</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="mb-6" id="otherReasonDiv" style="display: none;">
                    <label for="other_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Please specify:
                    </label>
                    <textarea id="other_reason" name="other_reason" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Please provide more details..."></textarea>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeCancellationModal()" 
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300 font-medium">
                        Keep Booking
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-300 font-medium">
                        Cancel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide-down {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out forwards;
        opacity: 0;
    }

    .animate-slide-down {
        animation: slide-down 0.6s ease-out forwards;
        opacity: 0;
    }
</style>

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
                'status' => $booking->status
            ];
        });
    @endphp
    const bookings = @json($bookingData);
    
    function openBookingModal(bookingId) {
        const booking = bookings.find(b => b.id === bookingId);
        if (!booking) return;
        
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="space-y-6">
                <!-- Ticket Number -->
                <div class="text-center bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Your Ticket Number</p>
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 font-mono tracking-wider">
                        ${booking.ticket_number || 'N/A'}
                    </div>
                </div>
                
                <!-- Customer Information -->
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <span class="mr-2">👤</span>
                        Customer Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Name</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.customer_name}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.customer_email}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Phone</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.customer_phone}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Travelers</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.number_of_travelers} people</p>
                        </div>
                    </div>
                </div>
                
                <!-- Trip Information -->
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <span class="mr-2">🏖️</span>
                        Trip Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Destination</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.destination}</p>
                        </div>
                        ${booking.start_date ? `
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Travel Dates</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.start_date}${booking.end_date ? ' to ' + booking.end_date : ''}</p>
                        </div>
                        ` : ''}
                        ${booking.budget_range ? `
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Budget Range</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.budget_range}</p>
                        </div>
                        ` : ''}
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Booking Date</p>
                            <p class="font-medium text-gray-900 dark:text-white">${booking.booking_date}</p>
                        </div>
                    </div>
                </div>
                
                ${booking.special_requirements ? `
                <!-- Special Requirements -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200 mb-2 flex items-center">
                        <span class="mr-2">📝</span>
                        Special Requirements
                    </h3>
                    <p class="text-amber-700 dark:text-amber-300">${booking.special_requirements}</p>
                </div>
                ` : ''}
                
                <!-- Status -->
                <div class="text-center">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-bold ${
                        booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                        booking.status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                        booking.status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                        'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'
                    }">
                        ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)} Booking
                    </span>
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
    
    // Close modal when clicking outside
    document.getElementById('bookingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBookingModal();
            closeCancellationModal();
        }
    });
    
    // Cancellation Modal Functions
    function openCancellationModal(bookingId) {
        const form = document.getElementById('cancellationForm');
        form.action = `{{ url('/my-bookings') }}/${bookingId}/cancel`;
        
        document.getElementById('cancellationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCancellationModal() {
        document.getElementById('cancellationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('cancellationForm').reset();
        document.getElementById('otherReasonDiv').style.display = 'none';
    }
    
    // Show/hide other reason input
    document.getElementById('cancellation_reason').addEventListener('change', function() {
        const otherReasonDiv = document.getElementById('otherReasonDiv');
        const otherReasonInput = document.getElementById('other_reason');
        
        if (this.value === 'other') {
            otherReasonDiv.style.display = 'block';
            otherReasonInput.required = true;
        } else {
            otherReasonDiv.style.display = 'none';
            otherReasonInput.required = false;
            otherReasonInput.value = '';
        }
    });
    
    // Close cancellation modal when clicking outside
    document.getElementById('cancellationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCancellationModal();
        }
    });
</script>

@endsection
