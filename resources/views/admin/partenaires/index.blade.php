@extends('layoutsapp.app')

@section('title', 'Gestion des Partenaires - SuperAdmin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestion des Partenaires</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Approuvez ou rejetez les demandes de partenariat</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">En attente</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $stats['en_attente'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-yellow-500 flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Approuvés</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $stats['approuves'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-green-500 flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Rejetés</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $stats['rejetes'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-red-500 flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 mb-8">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('superadmin.partenaires.index', ['statut' => 'all']) }}" 
               class="px-4 py-2 rounded-xl font-medium transition-all {{ $statut === 'all' ? 'bg-[#7917f9] text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                Tous ({{ $stats['total'] }})
            </a>
            <a href="{{ route('superadmin.partenaires.index', ['statut' => 'en_attente']) }}" 
               class="px-4 py-2 rounded-xl font-medium transition-all {{ $statut === 'en_attente' ? 'bg-yellow-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                En attente ({{ $stats['en_attente'] }})
            </a>
            <a href="{{ route('superadmin.partenaires.index', ['statut' => 'approuve']) }}" 
               class="px-4 py-2 rounded-xl font-medium transition-all {{ $statut === 'approuve' ? 'bg-green-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                Approuvés ({{ $stats['approuves'] }})
            </a>
            <a href="{{ route('superadmin.partenaires.index', ['statut' => 'rejete']) }}" 
               class="px-4 py-2 rounded-xl font-medium transition-all {{ $statut === 'rejete' ? 'bg-red-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                Rejetés ({{ $stats['rejetes'] }})
            </a>
        </div>
    </div>

    <!-- Liste des partenaires -->
    @if($partenaires->count() > 0)
        <div class="space-y-4">
            @foreach($partenaires as $partenaire)
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-start gap-6">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            @if($partenaire->logo)
                                <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="h-24 w-24 object-contain rounded-xl">
                            @else
                                <div class="h-24 w-24 rounded-xl bg-gradient-to-br from-[#7917f9] to-pink-500 flex items-center justify-center">
                                    <span class="text-3xl font-bold text-white">{{ substr($partenaire->nom, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Informations -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $partenaire->nom }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Par {{ $partenaire->user->name }} • {{ $partenaire->created_at->format('d/m/Y') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $partenaire->badge_statut['class'] }}">
                                    {{ $partenaire->badge_statut['text'] }}
                                </span>
                            </div>

                            @if($partenaire->description)
                                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ Str::limit($partenaire->description, 200) }}</p>
                            @endif

                            @if($partenaire->siteweb)
                                <a href="{{ $partenaire->siteweb }}" target="_blank" class="inline-flex items-center gap-2 text-[#7917f9] hover:text-purple-700 text-sm font-medium mb-4">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Visiter le site web
                                </a>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('superadmin.partenaires.show', $partenaire) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all">
                                    Voir détails
                                </a>

                                @if($partenaire->statut !== 'approuve')
                                    <form action="{{ route('superadmin.partenaires.approuver', $partenaire) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl font-medium transition-all">
                                            ✓ Approuver
                                        </button>
                                    </form>
                                @endif

                                @if($partenaire->statut !== 'rejete')
                                    <form action="{{ route('superadmin.partenaires.rejeter', $partenaire) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition-all">
                                            ✗ Rejeter
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('superadmin.partenaires.destroy', $partenaire) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire définitivement ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 rounded-xl font-medium transition-all">
                                        🗑 Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $partenaires->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-800 p-12 text-center">
            <p class="text-gray-600 dark:text-gray-400">Aucun partenaire trouvé pour ce filtre.</p>
        </div>
    @endif
</div>
@endsection