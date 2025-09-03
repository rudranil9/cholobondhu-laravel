<section class="bg-gradient-to-br from-gray-800 via-gray-800 to-red-900/20 shadow-2xl dark:shadow-gray-900/50 rounded-2xl p-8 border border-red-600 dark:border-red-800 transition-all duration-300 hover:shadow-3xl">
    <header class="mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white font-poppins">
                    {{ __('Delete Account') }}
                </h2>
                <p class="mt-1 text-gray-300 font-medium">
                    {{ __('Permanently remove your account and all associated data') }}
                </p>
            </div>
        </div>
    </header>

    <div class="bg-gradient-to-r from-red-900/30 to-pink-900/30 border-2 border-red-600 dark:border-red-700 rounded-xl p-6 mb-8">
        <div class="flex items-start space-x-4">
            <div class="p-2 bg-red-600/20 rounded-full">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-200 font-poppins">{{ __('Warning: This action cannot be undone') }}</h3>
                <p class="text-red-300 font-medium mt-2">{{ __('All your data, bookings, and account information will be permanently removed from our system.') }}</p>
            </div>
        </div>
    </div>

    <div class="flex justify-center pt-6 border-t-2 border-red-800">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-10 py-4 bg-gradient-to-r from-red-600 via-red-700 to-pink-700 hover:from-red-700 hover:via-red-800 hover:to-pink-800 text-white font-bold text-lg rounded-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-500 font-poppins"
        >
            <div class="flex items-center justify-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>{{ __('Delete Account') }}</span>
            </div>
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                @csrf
                @method('delete')

                <div class="text-center mb-8">
                    <div class="mx-auto flex items-center justify-center w-20 h-20 bg-gradient-to-r from-red-500 to-pink-600 rounded-full mb-6 shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-white font-poppins mb-3">
                        {{ __('Are you absolutely sure?') }}
                    </h2>

                    <p class="text-gray-300 font-medium">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                </div>

                <div class="mb-8">
                    <x-input-label for="password" value="{{ __('Password')" class="sr-only" />
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 p-3 bg-gradient-to-r from-red-100 to-pink-100 dark:from-red-900/30 dark:to-pink-900/30 rounded-xl border-2 border-red-200 dark:border-red-600">
                            <svg class="w-6 h-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full pl-5 pr-5 py-4 text-lg border-3 border-red-200 dark:border-red-600 focus:border-red-500 dark:focus:border-red-400 rounded-xl shadow-lg focus:shadow-xl transition-all duration-300 bg-white dark:bg-gray-700 font-medium hover:border-red-300 dark:hover:border-red-500"
                            placeholder="{{ __('Enter your password to confirm deletion') }}"
                        />
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center space-x-6">
                    <button
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="px-8 py-3 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <button
                        type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-bold rounded-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-red-300"
                    >
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>{{ __('Delete Account') }}</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
