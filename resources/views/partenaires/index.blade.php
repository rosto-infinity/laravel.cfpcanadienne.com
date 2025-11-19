@extends('layoutsapp.app')

@section('title', 'Nos Partenaires')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-white mb-4">
            Nos <span class="bg-gradient-to-r from-purple-600 to-[#7917f9] bg-clip-text text-transparent">Partenaires</span>
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            Découvrez les entreprises et organisations qui nous font confiance
        </p>
    </div>

    <!-- Partenaires Grid -->
    @if($partenaires->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($partenaires as $partenaire)
                <div class="group bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <!-- Logo -->
                    <div class="aspect-video bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-850 p-8 flex items-center justify-center">
                        @if($partenaire->logo)
                            <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="max-h-32 w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="h-32 w-32 rounded-2xl bg-gradient-to-br from-purple-600 to-[#7917f9] flex items-center justify-center">
                                <span class="text-4xl font-bold text-white">{{ substr($partenaire->nom, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $partenaire->nom }}
                        </h3>
                        
                        @if($partenaire->description)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $partenaire->description }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between">
                            @if($partenaire->siteweb)
                                <a href="{{ $partenaire->siteweb }}" target="_blank" class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 hover:text-[#7917f9] dark:hover:text-purple-300 font-medium text-sm group">
                                    <span>Visiter le site</span>
                                    <svg class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @endif
                            
                            <a href="{{ route('partenaires.show', $partenaire) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm font-medium">
                                Voir plus
                            </a>
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
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800 mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucun partenaire pour le moment</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Soyez le premier à rejoindre notre réseau !</p>
            @auth
                <a href="{{ route('partenaires.create') }}" class="inline-flex bg-gradient-to-r from-purple-600 to-[#7917f9] hover:from-[#7917f9] hover:to-[#7917f9] text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 hover:scale-105 shadow-lg">
                    Devenir Partenaire
                </a>
            @endauth
        </div>
    @endif
</div>
@endsection