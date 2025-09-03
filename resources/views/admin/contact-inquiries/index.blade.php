@extends('layouts.admin')

@section('title', 'Contact Inquiries Management')
@section('page-title', 'Contact Inquiries')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="stats-card rounded-2xl p-6 hover-lift">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Contact Inquiries Management</h2>
                <p class="text-gray-600 dark:text-gray-400">Manage and respond to customer inquiries</p>
            </div>
            
            <!-- Search and Filters -->
            <div class="flex flex-col sm:flex-row gap-3">
                <form method="GET" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search inquiries..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    
                    <select name="inquiry_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Types</option>
                        <option value="general" {{ request('inquiry_type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="booking" {{ request('inquiry_type') == 'booking' ? 'selected' : '' }}>Booking</option>
                        <option value="custom-quote" {{ request('inquiry_type') == 'custom-quote' ? 'selected' : '' }}>Custom Quote</option>
                    </select>
                    
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all duration-300">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Inquiries Table -->
    <div class="stats-card rounded-2xl overflow-hidden hover-lift">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Inquiry Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                        <span class="text-white text-sm font-bold">{{ substr($inquiry->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $inquiry->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $inquiry->email }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $inquiry->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    @if($inquiry->destination)
                                        <span class="font-medium">{{ $inquiry->destination }}</span>
                                    @else
                                        <span class="text-gray-500">General Inquiry</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ Str::limit($inquiry->message, 80) }}
                                </div>
                                @if($inquiry->start_date)
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        Travel: {{ $inquiry->start_date->format('M d') }} - {{ $inquiry->end_date ? $inquiry->end_date->format('M d, Y') : 'TBD' }}
                                        | {{ $inquiry->number_of_travelers }} travelers
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div>{{ $inquiry->created_at->format('M d, Y') }}</div>
                                <div class="text-xs">{{ $inquiry->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center justify-end">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.contact-inquiries.show', $inquiry->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <button onclick="openDeleteModal({{ $inquiry->id }}, {{ json_encode($inquiry->name) }}, {{ json_encode($inquiry->email) }})" 
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 hover:animate-pulse">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Inquiry
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No contact inquiries found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($inquiries->hasPages())
        <div class="stats-card rounded-2xl p-6 hover-lift">
            {{ $inquiries->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Status Update Modal (Hidden by default) -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Update Status</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">Status updated successfully!</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeModal" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-base font-medium rounded-md hover:shadow-lg transition-all duration-300">
                    OK
                </button>
            </div>
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
                    <h2 class="text-xl font-bold text-white">🗑️ Delete Contact Inquiry</h2>
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
                        You are about to permanently delete this contact inquiry:
                    </p>
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg mb-4">
                        <p class="font-medium text-gray-900 dark:text-white" id="deleteInquiryDetails">
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
                        🗑️ Delete Inquiry
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status changes
    document.querySelectorAll('.status-select').forEach(function(select) {
        select.addEventListener('change', function() {
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
                    select.className = `status-select px-2 py-1 text-xs font-semibold rounded-full border-0 focus:ring-0 ${
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
    });
    
    // Close modal
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('statusModal').classList.add('hidden');
    });

    // Delete Modal Functions
    let currentDeleteInquiryId = null;
    
    window.openDeleteModal = function(inquiryId, customerName, customerEmail) {
        console.log('Opening delete modal for inquiry:', inquiryId, customerName, customerEmail);
        
        currentDeleteInquiryId = inquiryId;
        
        // Update modal content with inquiry details
        const deleteDetails = document.getElementById('deleteInquiryDetails');
        deleteDetails.innerHTML = `
            <strong>Customer:</strong> ${customerName}<br>
            <strong>Email:</strong> ${customerEmail}<br>
            <strong>Inquiry ID:</strong> #${inquiryId}
        `;
        
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteInquiryId = null;
    }
    
    window.confirmDelete = function() {
        if (!currentDeleteInquiryId) {
            console.error('No inquiry ID set for deletion');
            return;
        }
        
        const deleteBtn = document.getElementById('deleteSubmitBtn');
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '⏳ Deleting...';
        
        // Create form for DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/contact-inquiries/${currentDeleteInquiryId}`;
        
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
        
        console.log('Submitting delete form for inquiry:', currentDeleteInquiryId);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
});
</script>
@endpush
