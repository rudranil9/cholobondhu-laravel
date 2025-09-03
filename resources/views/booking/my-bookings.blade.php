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

        <!-- Error Messages -->
        @if (session('error'))
            <div class="mb-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg animate-slide-down">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg animate-slide-down">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                    @if($booking->booking_number)
                                        <p class="text-blue-100 text-sm font-mono">
                                            🎫 {{ $booking->booking_number }}
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
                                    <span>Booked {{ $booking->created_at->diffForHumans() }}</span>
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
                    href="{{ route('tour-packages') }}" 
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

<!-- Booking Details Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Booking Details</h3>
                <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="bookingDetails">
                <!-- Booking details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Cancellation Modal -->
<div id="cancellationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Cancel Booking</h3>
                <button onclick="closeCancellationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="cancellationForm" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Are you sure you want to cancel this booking? Please provide a reason for cancellation.
                    </p>
                    
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cancellation Reason *
                    </label>
                    <textarea 
                        id="cancellation_reason" 
                        name="cancellation_reason" 
                        rows="4" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                        placeholder="Please explain why you want to cancel this booking..."
                    ></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button 
                        type="button" 
                        onclick="closeCancellationModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                    >
                        Keep Booking
                    </button>
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                    >
                        Cancel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentBookingId = null;

// Booking data for modals
const bookings = @json($bookings->items());

function openBookingModal(bookingId) {
    const booking = bookings.find(b => b.id === bookingId);
    if (!booking) return;
    
    const modal = document.getElementById('bookingModal');
    const detailsContainer = document.getElementById('bookingDetails');
    
    // Format dates
    const startDate = booking.start_date ? new Date(booking.start_date).toLocaleDateString('en-US', { 
        year: 'numeric', month: 'long', day: 'numeric' 
    }) : 'To be confirmed';
    
    const endDate = booking.end_date ? new Date(booking.end_date).toLocaleDateString('en-US', { 
        year: 'numeric', month: 'long', day: 'numeric' 
    }) : 'To be confirmed';
    
    const createdDate = new Date(booking.created_at).toLocaleDateString('en-US', { 
        year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
    });
    
    detailsContainer.innerHTML = `
        <div class="space-y-6">
            <!-- Ticket Number -->
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                <h4 class="text-lg font-bold text-blue-800 dark:text-blue-200">🎫 ${booking.booking_number || 'N/A'}</h4>
                <p class="text-sm text-blue-600 dark:text-blue-400">Ticket Number</p>
            </div>
            
            <!-- Customer Info -->
            <div>
                <h5 class="font-semibold text-gray-900 dark:text-white mb-3">Customer Information</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Name:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${booking.customer_name}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Email:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${booking.customer_email}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${booking.customer_phone}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Travelers:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${booking.number_of_travelers} person(s)</p>
                    </div>
                </div>
            </div>
            
            <!-- Trip Info -->
            <div>
                <h5 class="font-semibold text-gray-900 dark:text-white mb-3">Trip Information</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Destination:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${booking.destination}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        <p class="font-medium ${booking.status === 'pending' ? 'text-yellow-600' : booking.status === 'confirmed' ? 'text-green-600' : 'text-red-600'}">${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Start Date:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${startDate}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">End Date:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${endDate}</p>
                    </div>
                    ${booking.budget_range ? `
                    <div class="md:col-span-2">
                        <span class="text-gray-600 dark:text-gray-400">Budget Range:</span>
                        <p class="font-medium text-gray-900 dark:text-white">${booking.budget_range}</p>
                    </div>
                    ` : ''}
                </div>
            </div>
            
            ${booking.special_requirements ? `
            <div>
                <h5 class="font-semibold text-gray-900 dark:text-white mb-3">Special Requirements</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${booking.special_requirements}</p>
            </div>
            ` : ''}
            
            <div>
                <h5 class="font-semibold text-gray-900 dark:text-white mb-3">Booking Information</h5>
                <div class="text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Booked on:</span>
                    <p class="font-medium text-gray-900 dark:text-white">${createdDate}</p>
                </div>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openCancellationModal(bookingId) {
    currentBookingId = bookingId;
    const form = document.getElementById('cancellationForm');
    form.action = `/my-bookings/${bookingId}/cancel`;
    
    document.getElementById('cancellationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCancellationModal() {
    document.getElementById('cancellationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('cancellation_reason').value = '';
    currentBookingId = null;
}

// Close modals when clicking outside
document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});

document.getElementById('cancellationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancellationModal();
    }
});

// Handle form submission
document.getElementById('cancellationForm').addEventListener('submit', function(e) {
    const reason = document.getElementById('cancellation_reason').value.trim();
    if (!reason) {
        e.preventDefault();
        alert('Please provide a reason for cancellation.');
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Cancelling...';
    submitBtn.disabled = true;
    
    // Form will submit normally, but we can add loading state
    setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>

@endsection