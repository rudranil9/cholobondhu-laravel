@extends('layouts.app')

@section('title', 'Contact Us - Cholo Bondhu')
@section('description', 'Get in touch with Cholo Bondhu for your travel needs. We are here to help you plan your perfect vacation.')

@section('content')
<section id="contact" class="py-20 bg-gray-50 dark:bg-gray-800 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Get in Touch
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Ready to start your journey? Contact us today and let us help you plan your perfect vacation
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    Send us a Message
                </h3>
                
                <form id="contactForm" class="space-y-6">
                    @csrf
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Full Name *
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors"
                            placeholder="Enter your full name"
                            value="{{ old('name') }}">
                        <div class="text-red-500 text-sm mt-1 hidden" id="name-error"></div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address *
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors"
                            placeholder="Enter your email address"
                            value="{{ old('email') }}">
                        <div class="text-red-500 text-sm mt-1 hidden" id="email-error"></div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number *
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors"
                            placeholder="Enter your phone number"
                            value="{{ old('phone') }}">
                        <div class="text-red-500 text-sm mt-1 hidden" id="phone-error"></div>
                    </div>

                    <!-- Destination -->
                    <div>
                        <label for="destination" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Preferred Destination
                        </label>
                        <select
                            id="destination"
                            name="destination"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors">
                            <option value="">Select a destination</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest }}" {{ old('destination') == $dest ? 'selected' : '' }}>{{ $dest }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Travel Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Date
                            </label>
                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors"
                                value="{{ old('start_date') }}">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                End Date
                            </label>
                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors"
                                value="{{ old('end_date') }}">
                        </div>
                    </div>

                    <!-- Travelers -->
                    <div>
                        <label for="number_of_travelers" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Number of Travelers
                        </label>
                        <select
                            id="number_of_travelers"
                            name="number_of_travelers"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors">
                            <option value="1" {{ old('number_of_travelers', '2') == '1' ? 'selected' : '' }}>1 Traveler</option>
                            <option value="2" {{ old('number_of_travelers', '2') == '2' ? 'selected' : '' }}>2 Travelers</option>
                            <option value="3" {{ old('number_of_travelers', '2') == '3' ? 'selected' : '' }}>3 Travelers</option>
                            <option value="4" {{ old('number_of_travelers', '2') == '4' ? 'selected' : '' }}>4 Travelers</option>
                            <option value="5+" {{ old('number_of_travelers', '2') == '5+' ? 'selected' : '' }}>5+ Travelers</option>
                        </select>
                    </div>

                    <!-- Budget -->
                    <div>
                        <label for="budget_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Budget Range
                        </label>
                        <select
                            id="budget_range"
                            name="budget_range"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors">
                            <option value="">Select budget range</option>
                            <option value="under-3k" {{ old('budget_range') == 'under-3k' ? 'selected' : '' }}>Under ₹3,000</option>
                            <option value="3k-10k" {{ old('budget_range') == '3k-10k' ? 'selected' : '' }}>₹3,000 - ₹10,000</option>
                            <option value="10k-25k" {{ old('budget_range') == '10k-25k' ? 'selected' : '' }}>₹10,000 - ₹25,000</option>
                            <option value="25k-50k" {{ old('budget_range') == '25k-50k' ? 'selected' : '' }}>₹25,000 - ₹50,000</option>
                            <option value="50k-100k" {{ old('budget_range') == '50k-100k' ? 'selected' : '' }}>₹50,000 - ₹1,00,000</option>
                            <option value="above-100k" {{ old('budget_range') == 'above-100k' ? 'selected' : '' }}>Above ₹1,00,000</option>
                            <option value="custom" {{ old('budget_range') == 'custom' ? 'selected' : '' }}>Custom Package</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Message *
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors resize-none"
                            placeholder="Tell us about your travel preferences, special requirements, or any questions...">{{ old('message', $selectedPackage ? 'I am interested in booking: ' . $selectedPackage['name'] : '') }}</textarea>
                        <div class="text-red-500 text-sm mt-1 hidden" id="message-error"></div>
                    </div>

                    <input type="hidden" name="inquiry_type" value="{{ request('request', 'general') }}">

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-semibold text-lg">
                        <span id="submitText">Send Message</span>
                        <span id="loadingText" class="hidden">Sending...</span>
                    </button>

                    <!-- Success Message -->
                    <div id="successMessage" class="hidden text-center p-4 bg-green-100 text-green-800 rounded-lg">
                        <span class="text-2xl">✅</span>
                        <p class="font-semibold">Message sent successfully!</p>
                        <p class="text-sm">We'll get back to you within 24 hours.</p>
                    </div>
                </form>

                @if(session('success'))
                    <div class="mt-4 text-center p-4 bg-green-100 text-green-800 rounded-lg">
                        <span class="text-2xl">✅</span>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                @endif
            </div>

            <!-- Contact Information -->
            @include('partials.contact-info')
        </div>
    </div>
</section>

<!-- Success Popup Modal -->
<div id="successPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md mx-4 transform transition-all duration-300 scale-100">
        <div class="text-center">
            <!-- Success Icon with Animation -->
            <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center animate-bounce">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <!-- Success Message -->
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Message Sent Successfully! 🎉
            </h3>
            
            <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                Thank you for contacting <span class="font-semibold text-blue-600">Cholo Bondhu</span>! 
                We've received your travel inquiry and our team will get back to you within 
                <span class="font-semibold">24 hours</span>.
            </p>
            
            <!-- Contact Information -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <span class="font-semibold">📧 Email:</span> cholobondhutour@gmail.com<br>
                    <span class="font-semibold">📱 Phone:</span> +91 81002 82665
                </p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button 
                    onclick="closeSuccessPopup()" 
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Continue Exploring
                </button>
                <a 
                    href="{{ route('tour-packages') }}"
                    class="flex-1 border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors font-semibold text-center">
                    View Packages
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingText = document.getElementById('loadingText');
    const successMessage = document.getElementById('successMessage');
    const successPopup = document.getElementById('successPopup');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        loadingText.classList.remove('hidden');
        
        const formData = new FormData(form);
        
        try {
            const response = await fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                form.reset();
                document.getElementById('number_of_travelers').value = '2'; // Reset to default
                showSuccessPopup();
            } else {
                // Show validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const errorDiv = document.getElementById(field + '-error');
                        if (errorDiv) {
                            errorDiv.textContent = data.errors[field][0];
                            errorDiv.classList.remove('hidden');
                        }
                    });
                } else {
                    alert('Failed to send message: ' + (data.message || 'Unknown error'));
                }
            }
        } catch (error) {
            console.error('Error:', error);
            console.error('Full error details:', {
                message: error.message,
                stack: error.stack,
                url: '{{ route("contact.store") }}'
            });
            alert('Failed to send message. Please try again or contact us directly. Error: ' + error.message);
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            loadingText.classList.add('hidden');
        }
    });
});

function showSuccessPopup() {
    document.getElementById('successPopup').classList.remove('hidden');
}

function closeSuccessPopup() {
    document.getElementById('successPopup').classList.add('hidden');
}

// Close popup when clicking outside
document.getElementById('successPopup').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSuccessPopup();
    }
});
</script>
@endpush

<style>
    input:focus, select:focus, textarea:focus {
        outline: none;
    }

    /* Popup Animation */
    .fixed.inset-0 {
        animation: fadeIn 0.3s ease-out;
    }

    .fixed.inset-0 > div {
        animation: slideUp 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Success icon bounce animation */
    .animate-bounce {
        animation: bounce 1s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Hover effects for buttons */
    button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Smooth transitions */
    * {
        transition: all 0.2s ease;
    }
</style>
@endsection
