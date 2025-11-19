<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Partenaires') - {{ config('app.name') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-gray-950 dark:to-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-xl font-bold text-[#7917f9] ">
                        Accueil
                    </a>
                    <a href="{{ route('partenaires.index') }}" class="text-xl font-bold text-[#7917f9]">
                        Partenaires
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-[#7917f9] dark:hover:text-purple-400 font-medium">
                            Tableau de bord
                        </a>
                        
                        {{-- Lien SuperAdmin --}}
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('superadmin.partenaires.index') }}" class="inline-flex items-center gap-2 text-purple-700 dark:text-purple-400 hover:text-[#7917f9] dark:hover:text-purple-300 font-bold">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Admin Partenaires
                                @if(\App\Models\Partenaire::enAttente()->count() > 0)
                                    <span class="px-2 py-0.5 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                        {{ \App\Models\Partenaire::enAttente()->count() }}
                                    </span>
                                @endif
                            </a>
                        @endif
                    @endauth
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('partenaires.mes-partenaires') }}" class="text-gray-700 dark:text-gray-300 hover:text-[#7917f9] dark:hover:text-purple-400 font-medium">
                            Mes Partenariats
                        </a>
                        <a href="{{ route('partenaires.create') }}" class="bg-gradient-to-r from-purple-600 to-[#7917f9] hover:from-purple-700 hover:to-[#7917f9] text-white px-4 py-2 rounded-xl font-medium transition-all duration-300 hover:scale-105 shadow-lg">
                            Devenir Partenaire
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-[#7917f9] dark:hover:text-purple-400 font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-[#7917f9] text-white px-4 py-2 rounded-xl font-medium">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 h-10 w-10 rounded-xl bg-green-500 flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-green-800 dark:text-green-400 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-4">
                <p class="text-red-800 dark:text-red-400 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Content -->
    <main class="py-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>