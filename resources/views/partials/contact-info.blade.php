@php
$contactInfo = [
    [
        'icon' => '📍',
        'title' => 'Address',
        'value' => 'Bagnan, Howrah',
        'subtitle' => 'Pin: 711303, West Bengal, India'
    ],
    [
        'icon' => '📞',
        'title' => 'Phone',
        'value' => '+91 81002 82665',
        'subtitle' => 'Mon-Sat 9AM-7PM'
    ],
    [
        'icon' => '📧',
        'title' => 'Email',
        'value' => 'cholobondhutour@gmail.com',
        'subtitle' => 'We reply within 24 hours'
    ],
    [
        'icon' => '💬',
        'title' => 'WhatsApp',
        'value' => '+91 81002 82665',
        'subtitle' => 'Quick support via WhatsApp'
    ]
];

$officeHours = [
    ['day' => 'Monday - Friday', 'time' => '9:00 AM - 7:00 PM'],
    ['day' => 'Saturday', 'time' => '9:00 AM - 5:00 PM'],
    ['day' => 'Sunday', 'time' => 'Closed']
];

$socialMedia = [
    [
        'name' => 'Facebook', 
        'icon' => 'facebook', 
        'url' => 'https://www.facebook.com/CholoBondhuTravelAgency',
        'color' => '#1877F2' 
    ],
    [
        'name' => 'Instagram', 
        'icon' => 'instagram', 
        'url' => 'https://instagram.com/cholobondhutourandtravels',
        'color' => '#E4405F' 
    ],
    [
        'name' => 'WhatsApp', 
        'icon' => 'whatsapp', 
        'url' => 'https://wa.me/918100282665',
        'color' => '#25D366' 
    ]
];
@endphp

<div class="space-y-8">
    <!-- Contact Details -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8">
        <!-- Company Logo -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 bg-white rounded-full shadow-lg overflow-hidden">
                <img 
                    src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                    alt="Cholo Bondhu Logo" 
                    class="w-full h-full object-contain"
                />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                Cholo Bondhu
            </h3>
            <p class="text-gray-600 dark:text-gray-300">Your Travel Companion</p>
        </div>

        <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
            Contact Information
        </h4>
        
        <div class="space-y-6">
            @foreach($contactInfo as $contact)
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400 text-xl">
                    {{ $contact['icon'] }}
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $contact['title'] }}</h4>
                    <p class="text-gray-600 dark:text-gray-300">{{ $contact['value'] }}</p>
                    @if(isset($contact['subtitle']))
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contact['subtitle'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Office Hours -->
    <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white">
        <h3 class="text-2xl font-bold mb-6">Office Hours</h3>
        <div class="space-y-3">
            @foreach($officeHours as $hour)
            <div class="flex justify-between items-center">
                <span class="font-medium">{{ $hour['day'] }}</span>
                <span class="text-blue-100">{{ $hour['time'] }}</span>
            </div>
            @endforeach
        </div>
        <div class="mt-6 p-4 bg-white/10 backdrop-blur-sm rounded-lg">
            <p class="text-sm text-blue-100">
                <span class="text-yellow-300">📞</span>
                Emergency support available 24/7 for travelers
            </p>
        </div>
    </div>

    <!-- Social Media -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            Follow Us
        </h3>
        <div class="grid grid-cols-3 gap-4">
            @foreach($socialMedia as $social)
            <a href="{{ $social['url'] }}"
               target="_blank"
               rel="noopener noreferrer"
               class="flex items-center space-x-3 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 transform hover:scale-105 hover:shadow-lg group">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white dark:bg-gray-800 shadow-lg border-2 border-gray-100 dark:border-gray-700 group-hover:border-white group-hover:shadow-xl transition-all duration-300">
                    @if($social['icon'] === 'facebook')
                        <!-- Facebook Icon -->
                        <svg class="w-6 h-6" style="color: {{ $social['color'] }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    @elseif($social['icon'] === 'instagram')
                        <!-- Instagram Icon -->
                        <svg class="w-6 h-6" style="color: {{ $social['color'] }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    @elseif($social['icon'] === 'whatsapp')
                        <!-- WhatsApp Icon -->
                        <svg class="w-6 h-6" style="color: {{ $social['color'] }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                        </svg>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ $social['name'] }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $social['icon'] === 'whatsapp' ? 'Quick chat' : 'Follow us' }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
