<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-[#7917f9]/10 text-[#7917f9] dark:bg-[#7917f9]/20 dark:text-[#7917f9]/90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </span>
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#161615] rounded-2xl border border-gray-200 dark:border-[#3E3E3A] overflow-hidden shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] transition-all duration-300 hover:shadow-[0px_0px_1px_0px_rgba(0,0,0,0.05),0px_2px_4px_0px_rgba(0,0,0,0.1)]">
                <div class="p-6 sm:p-8">
                    <div class="text-center max-w-2xl mx-auto">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-[#7917f9]/10 dark:bg-[#7917f9]/20 mb-6 mx-auto">
                            <svg class="w-8 h-8 text-[#7917f9] dark:text-[#7917f9]/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __("Vous êtes connecté !") }}
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto leading-relaxed">
                            Bienvenue sur votre tableau de bord personnalisé. Ici, vous pouvez gérer vos partenariats, suivre vos performances et accéder à tous vos outils en un seul endroit.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('partenaires.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-[#7917f9] hover:bg-[#7917f9]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7917f9]/50 transition-all duration-200 shadow-[0_2px_4px_0_rgba(121,23,249,0.2)]">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Commencer
                            </a>
                            <a href="{{ route('partenaires.mes-partenaires') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-700 text-base font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-[#1e1e1d] hover:bg-gray-50 dark:hover:bg-[#252524] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7917f9]/50 transition-all duration-200">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                 Mes Partenariats
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>