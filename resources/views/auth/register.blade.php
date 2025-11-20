<x-guest-layout>
    <div class="flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-950 p-4">
        <div class="w-full max-w-2xl">
            <!-- Logo/Header compact -->
            <div class="text-center mb-6">
                
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Créez votre compte
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                    Rejoignez notre communauté en quelques secondes
                </p>
            </div>

            <!-- Formulaire compact -->
            <div class="  bg-white dark:bg-[#161615] rounded-xl border border-gray-200 dark:border-[#3E3E3A] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.05),0px_1px_4px_0px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="p-5 sm:p-6">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nom')" class="text-xs font-medium text-gray-700 dark:text-gray-200 mb-1.5 block" />
                            <x-text-input 
                                id="name" 
                                class="block w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#7917f9]/50 focus:border-[#7917f9] transition-all duration-200"
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name"
                                placeholder="Jean Dupont"
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500 dark:text-red-400" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" class="text-xs font-medium text-gray-700 dark:text-gray-200 mb-1.5 block" />
                            <x-text-input 
                                id="email" 
                                class="block w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#7917f9]/50 focus:border-[#7917f9] transition-all duration-200"
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username"
                                placeholder="votre@email.com"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500 dark:text-red-400" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Mot de passe')" class="text-xs font-medium text-gray-700 dark:text-gray-200 mb-1.5 block" />
                            <x-text-input 
                                id="password" 
                                class="block w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#7917f9]/50 focus:border-[#7917f9] transition-all duration-200"
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500 dark:text-red-400" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-5">
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-xs font-medium text-gray-700 dark:text-gray-200 mb-1.5 block" />
                            <x-text-input 
                                id="password_confirmation" 
                                class="block w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#7917f9]/50 focus:border-[#7917f9] transition-all duration-200"
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-500 dark:text-red-400" />
                        </div>

                        <!-- Terms & Register Button -->
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex items-center h-4">
                                    <input id="terms" type="checkbox" class="w-3.5 h-3.5 rounded border-gray-300 dark:border-[#3E3E3A] text-[#7917f9] focus:ring-[#7917f9]/50" required>
                                </div>
                                <label for="terms" class="ms-2 text-xs text-gray-600 dark:text-gray-300">
                                    J'accepte les <a href="#" class="text-[#7917f9] hover:text-[#7917f9]/80 font-medium underline">conditions d'utilisation</a>
                                </label>
                            </div>

                            <x-primary-button class="w-full bg-[#7917f9] hover:bg-[#7917f9]/90 text-white font-medium py-2.5 px-4 rounded-lg shadow-[0_1px_3px_0_rgba(121,23,249,0.2)] transition-all duration-200 flex items-center justify-center gap-1.5 text-sm">
                                <span>{{ __('S\'inscrire') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </x-primary-button>

                            <div class="text-center text-xs text-gray-500 dark:text-gray-400 pt-2 border-t border-gray-200 dark:border-[#3E3E3A]">
                                <span>{{ __("Vous avez déjà un compte ?") }}</span>
                                <a href="{{ route('login') }}" class="font-medium text-[#7917f9] hover:text-[#7917f9]/80 ms-1 transition-colors duration-200">
                                    {{ __('Connectez-vous') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>