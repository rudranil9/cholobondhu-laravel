<section class="space-y-8">
    <header class="mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg></svg>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2m0 0V7a2 2 0 712-2m6 0V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2m12 0v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6m12 0H3"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white font-poppins">
                    {{ __('Password Security') }}
                </h2>
                <p class="mt-1 text-gray-300 font-medium">
                    {{ __('Keep your account secure with a strong password') }}
                </p>
            </div>
        </div>
    </header>

    <!-- Success Message -->
    @if (session('status') === 'password-updated')
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
            class="mb-8 p-5 bg-gradient-to-r from-green-900/30 to-emerald-900/30 border-2 border-green-600 dark:border-green-700 rounded-xl shadow-lg"
        >
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-200 font-poppins">{{ __('Password Updated Successfully!') }}</h3>
                    <p class="text-green-300 font-medium">{{ __('Your account is now more secure with the new password.') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div class="space-y-3">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-lg font-bold text-white font-poppins" />
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl border-2 border-blue-200 dark:border-indigo-600">
                    <svg class="w-6 h-6 text-blue-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <x-text-input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="mt-1 block w-full pl-5 pr-5 py-4 text-lg border-3 border-blue-200 dark:border-indigo-600 focus:border-blue-500 dark:focus:border-indigo-400 rounded-xl shadow-lg focus:shadow-xl transition-all duration-300 bg-gray-700 dark:bg-gray-700 text-white font-medium hover:border-blue-300 dark:hover:border-indigo-500" 
                    autocomplete="current-password" 
                    placeholder="Enter your current password"
                />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password Field -->
        <div class="space-y-3">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-lg font-bold text-white font-poppins" />
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl border-2 border-blue-200 dark:border-indigo-600">
                    <svg class="w-6 h-6 text-blue-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 712 2m0 0a2 2 0 712 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 712-2m0 0V7a2 2 0 712-2m6 0V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2m12 0v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6m12 0H3"></path>
                    </svg>
                </div>
                <x-text-input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="mt-1 block w-full pl-5 pr-5 py-4 text-lg border-3 border-blue-200 dark:border-indigo-600 focus:border-blue-500 dark:focus:border-indigo-400 rounded-xl shadow-lg focus:shadow-xl transition-all duration-300 bg-gray-700 dark:bg-gray-700 text-white font-medium hover:border-blue-300 dark:hover:border-indigo-500" 
                    autocomplete="new-password" 
                    placeholder="Create a new strong password"
                />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password Field -->
        <div class="space-y-3">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-lg font-bold text-white font-poppins" />
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl border-2 border-blue-200 dark:border-indigo-600">
                    <svg class="w-6 h-6 text-blue-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <x-text-input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="mt-1 block w-full pl-5 pr-5 py-4 text-lg border-3 border-blue-200 dark:border-indigo-600 focus:border-blue-500 dark:focus:border-indigo-400 rounded-xl shadow-lg focus:shadow-xl transition-all duration-300 bg-gray-700 dark:bg-gray-700 text-white font-medium hover:border-blue-300 dark:hover:border-indigo-500" 
                    autocomplete="new-password" 
                    placeholder="Confirm your new password"
                />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Update Button -->
        <div class="flex items-center justify-center pt-8 border-t-2 border-indigo-800">            
            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white font-bold text-lg rounded-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-indigo-500 font-poppins">
                <div class="flex items-center justify-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ __('Update Password') }}</span>
                </div>
            </button>
        </div>
    </form>
</section>