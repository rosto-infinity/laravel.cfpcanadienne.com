@extends('layoutsapp.app')

@section('title', 'Devenir Partenaire')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-8 text-white">
            <h1 class="text-3xl font-black mb-2">Devenir Partenaire</h1>
            <p class="text-purple-100">Rejoignez notre réseau et développez votre visibilité</p>
        </div>

        <!-- Form -->
        <form action="{{ route('partenaires.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                    Nom de l'entreprise <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                    class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition-all">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div>
                <label for="logo" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                    Logo <span class="text-red-500">*</span>
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
                        <input type="file" id="logo" name="logo" accept="image/*" class="hidden" required onchange="previewImage(event)">
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
                <input type="url" id="siteweb" name="siteweb" value="{{ old('siteweb') }}" placeholder="https://example.com"
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
                    class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition-all resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-blue-800 dark:text-blue-400">
                        Votre demande sera examinée par notre équipe avant d'être publiée. Vous recevrez une notification une fois votre partenariat approuvé.
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <a href="{{ route('partenaires.index') }}" 
                    class="flex-1 text-center px-6 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-750 transition-all">
                    Annuler
                </a>
                <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    Soumettre ma demande
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