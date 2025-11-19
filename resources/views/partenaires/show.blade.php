@section('title', $partenaire->nom)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-purple-700 p-12 text-center">
            <div class="inline-flex h-32 w-32 items-center justify-center rounded-3xl bg-white/10 backdrop-blur-lg border-4 border-white/20 mb-6">
                @if($partenaire->logo)
                    <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="max-h-24 max-w-24 object-contain">
                @else
                    <span class="text-6xl font-bold text-white">{{ substr($partenaire->nom, 0, 1) }}</span>
                @endif
            </div>
            <h1 class="text-4xl font-black text-white mb-2">{{ $partenaire->nom }}</h1>
            @if($partenaire->siteweb)
                <a href="{{ $partenaire->siteweb }}" target="_blank" class="inline-flex items-center gap-2 text-white/90 hover:text-white font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    <span>{{ $partenaire->siteweb }}</span>
                </a>
            @endif
        </div>

        <!-- Content -->
        <div class="p-8 lg:p-12">
            @if($partenaire->description)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">À propos</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                        {{ $partenaire->description }}
                    </p>
                </div>
            @endif

            <!-- CTA -->
            @if($partenaire->siteweb)
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-6 border-2 border-purple-200 dark:border-purple-800">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Visitez notre site web</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Découvrez tous nos produits et services</p>
                        </div>
                        <a href="{{ $partenaire->siteweb }}" target="_blank" 
                            class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 inline-flex items-center gap-2">
                            Visiter le site
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('partenaires.index') }}" 
                    class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour aux partenaires
                </a>
            </div>
        </div>
    </div>
</div>
@endsection