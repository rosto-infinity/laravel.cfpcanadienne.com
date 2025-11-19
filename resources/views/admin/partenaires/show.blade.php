@extends('layoutsapp.app')

@section('title', 'Détails du Partenaire - SuperAdmin')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Bouton retour -->
    <div class="mb-6">
        <a href="{{ route('superadmin.partenaires.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-[#7917f9] dark:hover:text-purple-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>
    </div>

    <!-- Carte principale -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <!-- Header avec statut -->
        <div class="bg-gradient-to-r from-purple-600 to-[#7917f9] p-8 text-white">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $partenaire->nom }}</h1>
                    <p class="text-purple-100">Soumis le {{ $partenaire->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <span class="px-4 py-2 rounded-xl text-sm font-bold {{ $partenaire->badge_statut['class'] }}">
                    {{ $partenaire->badge_statut['text'] }}
                </span>
            </div>
        </div>

        <!-- Corps -->
        <div class="p-8 space-y-8">
            <!-- Logo -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Logo</h3>
                <div class="flex items-center justify-center bg-gray-50 dark:bg-gray-800 rounded-2xl p-8">
                    @if($partenaire->logo)
                        <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="max-h-48 object-contain">
                    @else
                        <div class="h-48 w-48 rounded-2xl bg-gradient-to-br from-[#7917f9] to-pink-500 flex items-center justify-center">
                            <span class="text-6xl font-bold text-white">{{ substr($partenaire->nom, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Utilisateur</h3>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $partenaire->user->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $partenaire->user->email }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Site Web</h3>
                    @if($partenaire->siteweb)
                        <a href="{{ $partenaire->siteweb }}" target="_blank" class="inline-flex items-center gap-2 text-[#7917f9] hover:text-purple-700 font-medium">
                            {{ $partenaire->siteweb }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Non renseigné</p>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($partenaire->description)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Description</h3>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $partenaire->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Métadonnées -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations supplémentaires</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Date de soumission</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $partenaire->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dernière modification</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $partenaire->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">ID</p>
                        <p class="font-semibold text-gray-900 dark:text-white">#{{ $partenaire->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex flex-wrap gap-4">
                @if($partenaire->statut !== 'approuve')
                    <form action="{{ route('superadmin.partenaires.approuver', $partenaire) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-all hover:scale-105 shadow-lg">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Approuver ce partenaire
                        </button>
                    </form>
                @endif

                @if($partenaire->statut !== 'rejete')
                    <button onclick="document.getElementById('rejetModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-all hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Rejeter ce partenaire
                    </button>
                @endif

                <form action="{{ route('superadmin.partenaires.destroy', $partenaire) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire définitivement ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 rounded-xl font-semibold transition-all">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div id="rejetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl max-w-md w-full mx-4 p-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Rejeter le partenaire</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Vous pouvez ajouter une raison pour le rejet (optionnel).</p>
        
        <form action="{{ route('superadmin.partenaires.rejeter', $partenaire) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-6">
                <label for="raison" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Raison du rejet</label>
                <textarea name="raison" id="raison" rows="4" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-[#7917f9] focus:border-transparent" placeholder="Ex: Le logo ne respecte pas les critères de qualité..."></textarea>
            </div>
            
            <div class="flex gap-4">
                <button type="button" onclick="document.getElementById('rejetModal').classList.add('hidden')" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all">
                    Annuler
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-all">
                    Confirmer le rejet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection