<section class="space-y-8">
    <header class="mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white font-poppins">
                    {{ __('Profile Information') }}
                </h2>
                <p class="mt-1 text-gray-300 font-medium">
                    {{ __("Update your personal details and contact information") }}
                </p>
            </div>
        </div>
    </header>

    <!-- Success Message -->
    @if (session('status') === 'profile-updated')
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            x-init="setTimeout(() => show = false, 5000)"
            class="mb-8 p-5 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-2 border-blue-200 dark:border-blue-700 rounded-xl shadow-lg"
        >
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200 font-poppins">{{ __('Profile Updated Successfully!') }}</h3>
                    <p class="text-blue-600 dark:text-blue-300 font-medium">{{ __('Your profile information has been saved successfully.') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="space-y-3">
            <x-input-label for="name" :value="__('Full Name')" class="text-lg font-bold text-white font-poppins" />
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl border-2 border-blue-200 dark:border-blue-600">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <x-text-input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full pl-5 pr-5 py-4 text-lg border-3 border-blue-200 dark:border-blue-600 focus:border-blue-500 dark:focus:border-blue-400 rounded-xl shadow-lg focus:shadow-xl transition-all duration-300 bg-gray-700 dark:bg-gray-700 text-white font-medium hover:border-blue-300 dark:hover:border-blue-500" 
                    :value="old('name', $user->name)" 
                    required 
                    autofocus 
                    autocomplete="name" 
                    placeholder="Enter your full name"
                />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-3">
            <x-input-label for="email" :value="__('Email Address')" class="text-lg font-bold text-white font-poppins" />
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800/30 dark:to-gray-700/30 rounded-xl border-2 border-gray-300 dark:border-gray-600">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <x-text-input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="mt-1 block w-full pl-5 pr-5 py-4 text-lg border-3 border-gray-300 dark:border-gray-600 rounded-xl shadow-lg bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-medium cursor-not-allowed opacity-75" 
                    :value="old('email', $user->email)" 
                    readonly
                    autocomplete="username" 
                    placeholder="Enter your email address"
                />
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>{{ __('Email address cannot be changed for security reasons') }}</span>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <div class="p-1 bg-amber-100 dark:bg-amber-900/30 rounded-full">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                {{ __('Your email address is unverified.') }}
                            </p>
                            <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">
                                <button form="send-verification" class="underline hover:text-amber-800 dark:hover:text-amber-200 transition-colors duration-200">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ __('Changes will be saved automatically') }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <x-primary-button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Update Profile') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</section>
