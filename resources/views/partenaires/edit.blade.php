@extends('layoutsapp.app')

@section('title', 'Modifier le partenariat')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-8 text-white">
            <h1 class="text-3xl font-black mb-2">Modifier le partenariat</h1>
            <p class="text-purple-100">Mettez à jour les informations de votre partenariat</p>
        </div>

        <!-- Form -->
        <form action="{{ route('partenaires.update', $partenaire) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                    Nom de l'entreprise <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nom" name="nom" value="{{ old('nom', $partenaire->nom) }}" required
                    class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition-all">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo actuel -->
            @if($partenaire->logo)
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                        Logo actuel
                    </label>
                    <div class="flex items-center gap-4">
                        <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="h-24 w-24 object-contain rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Téléchargez une nouvelle image pour remplacer le logo actuel
                        </p>
                    </div>
                </div>
            @endif

            <!-- Nouveau Logo -->
            <div>
                <label for="logo" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                    {{ $partenaire->logo ? 'Nouveau logo' : 'Logo' }} 
                    @if(!$partenaire->logo)<span class="text-red-500">*</span>@endif
                </label>
                <div class="flex items-center gap-4">
                    <label for="logo" class="cursor-pointer flex-1">
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 text-center hover:border-purple-600 dark:hover:border-purple-400 transition-colors">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-semibold text-purple-600 dark:text-purple-400">Cliquez pour uploader</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF, SVG, WEBP (max. 2MB)</p>
                        </div>
                        <input type="file" id="logo" name="logo" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </label>
                </div>
                <div id="preview" class="mt-4 hidden">
                    <img id="preview-image" class="h-32 w-auto object-contain rounded-xl border-2 border-gray-200 dark:border-gray-700">
                </div>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Site Web -->
            <div>
                <label for="siteweb" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                    Site Web
                </label>
                <input type="url" id="siteweb" name="siteweb" value="{{ old('siteweb', $partenaire->siteweb) }}" placeholder="https://example.com"
                    class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition-all">
                @error('siteweb')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="4" placeholder="Décrivez votre entreprise et votre activité..."
                    class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition-all resize-none">{{ old('description', $partenaire->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info -->
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-amber-800 dark:text-amber-400">
                        Après modification, votre partenariat sera remis en attente d'approbation.
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <a href="{{ route('partenaires.mes-partenaires') }}" 
                    class="flex-1 text-center px-6 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-750 transition-all">
                    Annuler
                </a>
                <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('preview-image');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection