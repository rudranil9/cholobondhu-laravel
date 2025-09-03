@extends('layouts.admin')

@section('title', 'Contact Inquiry Details')
@section('page-title', 'Inquiry Details')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.contact-inquiries.index') }}" 
                   class="bg-gradient-to-r from-gray-500 to-gray-600 text-white p-2 rounded-full hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Contact Inquiry Details</h2>
                    <p class="text-gray-600 dark:text-gray-400">Inquiry ID: #{{ $contactInquiry->id }}</p>
                </div>
            </div>
            
            <!-- Status Update -->
            <div class="flex items-center space-x-3">
                <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label>
                <select id="status-select" class="status-select px-3 py-2 text-sm font-semibold rounded-full border-0 focus:ring-2 focus:ring-blue-500 {{ 
                    $contactInquiry->status === 'resolved' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
                    ($contactInquiry->status === 'in_progress' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white' :
                    ($contactInquiry->status === 'closed' ? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white' : 
                    'bg-gradient-to-r from-orange-500 to-red-500 text-white'))
                }}" data-inquiry-id="{{ $contactInquiry->id }}">
                    <option value="pending" {{ $contactInquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $contactInquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ $contactInquiry->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ $contactInquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Customer Information -->
        <div class="stats-card rounded-2xl p-6 hover-lift">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                Customer Information
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                        <span class="text-white text-lg font-bold">{{ substr($contactInquiry->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $contactInquiry->name }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Customer</div>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $contactInquiry->email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Email Address</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $contactInquiry->phone }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Phone Number</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inquiry Summary -->
        <div class="stats-card rounded-2xl p-6 hover-lift">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                Inquiry Summary
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Type:</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ 
                        $contactInquiry->inquiry_type === 'booking' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
                        ($contactInquiry->inquiry_type === 'custom-quote' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' :
                        'bg-gradient-to-r from-blue-500 to-indigo-500 text-white')
                    }}">
                        {{ ucfirst(str_replace('-', ' ', $contactInquiry->inquiry_type)) }}
                    </span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Submitted:</span>
                    <span class="text-sm text-gray-900 dark:text-white">{{ $contactInquiry->created_at->format('M d, Y h:i A') }}</span>
                </div>
                
                @if($contactInquiry->destination)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Destination:</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $contactInquiry->destination }}</span>
                    </div>
                @endif
                
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Travelers:</span>
                    <span class="text-sm text-gray-900 dark:text-white">{{ $contactInquiry->number_of_travelers }}</span>
                </div>
                
                @if($contactInquiry->budget_range)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Budget:</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $contactInquiry->budget_range }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($contactInquiry->start_date || $contactInquiry->end_date)
        <!-- Travel Dates -->
        <div class="stats-card rounded-2xl p-6 hover-lift">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                Travel Dates
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($contactInquiry->start_date)
                    <div class="p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20">
                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Start Date</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $contactInquiry->start_date->format('F d, Y') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500">{{ $contactInquiry->start_date->format('l') }}</div>
                    </div>
                @endif
                
                @if($contactInquiry->end_date)
                    <div class="p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20">
                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400">End Date</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $contactInquiry->end_date->format('F d, Y') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500">{{ $contactInquiry->end_date->format('l') }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Message Details -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            Customer Message
        </h3>
        
        <div class="p-6 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-white/20">
            <div class="text-gray-900 dark:text-white leading-relaxed">
                {{ $contactInquiry->message }}
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h3>
        
        <div class="flex flex-wrap gap-3">
            <a href="mailto:{{ $contactInquiry->email }}" 
               class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Send Email Reply
            </a>
            
            <a href="tel:{{ $contactInquiry->phone }}" 
               class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Call Customer
            </a>
            
            @if($contactInquiry->inquiry_type === 'booking' || $contactInquiry->inquiry_type === 'custom-quote')
                <a href="{{ route('admin.bookings.index') }}?customer={{ $contactInquiry->email }}" 
                   class="bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Create Booking
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Status Updated</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">The inquiry status has been updated successfully!</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeModal" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-base font-medium rounded-md hover:shadow-lg transition-all duration-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status changes
    document.getElementById('status-select').addEventListener('change', function() {
        const inquiryId = this.getAttribute('data-inquiry-id');
        const newStatus = this.value;
        
        fetch(`/admin/contact-inquiries/${inquiryId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update select styling based on new status
                const select = this;
                select.className = `status-select px-3 py-2 text-sm font-semibold rounded-full border-0 focus:ring-2 focus:ring-blue-500 ${
                    newStatus === 'resolved' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
                    (newStatus === 'in_progress' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white' :
                    (newStatus === 'closed' ? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white' : 
                    'bg-gradient-to-r from-orange-500 to-red-500 text-white'))
                }`;
                
                // Show success modal
                document.getElementById('statusModal').classList.remove('hidden');
            } else {
                alert('Error updating status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating status. Please try again.');
        });
    });
    
    // Close modal
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('statusModal').classList.add('hidden');
    });
});
</script>
@endpush
