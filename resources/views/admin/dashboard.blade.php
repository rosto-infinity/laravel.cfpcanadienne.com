@extends('layoutsapp.app')

@section('title', 'Dashboard SuperAdmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard SuperAdmin</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Vue d'ensemble de la plateforme</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-purple-500 to-[#7917f9] rounded-3xl shadow-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1">{{ $stats['users_total'] }}</p>
            <p class="text-purple-100">Utilisateurs inscrits</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl shadow-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1">{{ $stats['partenaires_total'] }}</p>
            <p class="text-blue-100">Total partenaires</p>
        </div>

        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl shadow-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1">{{ $stats['partenaires_attente'] }}</p>
            <p class="text-yellow-100">En attente</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl shadow-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1">{{ $stats['partenaires_approuves'] }}</p>
            <p class="text-green-100">Approuvés</p>
        </div>
    </div>

    <!-- Partenaires en attente -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-800 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Partenaires en attente de validation</h2>
            <a href="{{ route('superadmin.partenaires.index', ['statut' => 'en_attente']) }}" class="text-[#7917f9] hover:text-purple-700 font-medium">
                Voir tout →
            </a>
        </div>

        @if($partenaires_recents->count() > 0)
            <div class="space-y-4">
                @foreach($partenaires_recents as $partenaire)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        @if($partenaire->logo)
                            <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="h-16 w-16 object-contain rounded-xl">
                        @else
                            <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-[#7917f9] to-pink-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl font-bold text-white">{{ substr($partenaire->nom, 0, 1) }}</span>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $partenaire->nom }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $partenaire->user->name }} • {{ $partenaire->created_at->diffForHumans() }}</p>
                        </div>

                        <a href="{{ route('superadmin.partenaires.show', $partenaire) }}" class="px-4 py-2 bg-[#7917f9] hover:bg-purple-700 text-white rounded-xl font-medium transition-all flex-shrink-0">
                            Examiner
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800 mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Aucun partenaire en attente</p>
            </div>
        @endif
    </div>
</div>
@endsection