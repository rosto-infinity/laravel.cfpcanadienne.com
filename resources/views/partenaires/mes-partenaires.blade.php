@extends('layoutsapp.app')

@section('title', 'Mes Partenariats')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">
                Mes Partenariats
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Gérez vos demandes de partenariat
            </p>
        </div>
        <a href="{{ route('partenaires.create') }}" 
            class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
            Nouveau Partenariat
        </a>
    </div>

    @if($partenaires->count() > 0)
        <div class="space-y-4">
            @foreach($partenaires as $partenaire)
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <div class="h-24 w-24 rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-850 p-3 flex items-center justify-center border-2 border-gray-100 dark:border-gray-700">
                                    @if($partenaire->logo)
                                        <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <span class="text-3xl font-bold text-purple-600">{{ substr($partenaire->nom, 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-3">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                            {{ $partenaire->nom }}
                                        </h3>
                                        @if($partenaire->siteweb)
                                            <a href="{{ $partenaire->siteweb }}" target="_blank" class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                                                {{ $partenaire->siteweb }}
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Statut Badge -->
                                    @if($partenaire->statut === 'approuve')
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Approuvé
                                        </span>
                                    @elseif($partenaire->statut === 'en_attente')
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                            <svg class="h-4 w-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            En attente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Rejeté
                                        </span>
                                    @endif
                                </div>

                                @if($partenaire->description)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                        {{ $partenaire->description }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span>Créé le {{ $partenaire->created_at->format('d/m/Y') }}</span>
                                    @if($partenaire->updated_at != $partenaire->created_at)
                                        <span>• Modifié le {{ $partenaire->updated_at->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex md:flex-col gap-2">
                                <a href="{{ route('partenaires.edit', $partenaire) }}" 
                                    class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border-2 border-purple-600 text-purple-600 hover:bg-purple-50 dark:border-purple-400 dark:text-purple-400 dark:hover:bg-purple-900/20 font-medium transition-all">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Modifier
                                </a>

                                @if($partenaire->isApprouve())
                                    <a href="{{ route('partenaires.show', $partenaire) }}" target="_blank"
                                        class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-medium transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Voir
                                    </a>
                                @endif

                                <form action="{{ route('partenaires.destroy', $partenaire) }}" method="POST" 
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenariat ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border-2 border-red-600 text-red-600 hover:bg-red-50 dark:border-red-400 dark:text-red-400 dark:hover:bg-red-900/20 font-medium transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Supprimer
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
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 p-12 text-center">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-purple-100 dark:bg-purple-900/20 mb-4">
                <svg class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucun partenariat</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Vous n'avez pas encore soumis de demande de partenariat.</p>
            <a href="{{ route('partenaires.create') }}" 
                class="inline-flex bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                Créer mon premier partenariat
            </a>
        </div>
    @endif
</div>
@endsection