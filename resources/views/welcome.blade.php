<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Déployer Laravel sur un serveur mutualisé – Guide complet (Parties 1 à 3)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme {
                :root, :host {
                    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                    --color-primary: oklch(.627 .265 303.9); /* purple-500 */
                    --color-secondary: oklch(.448 .119 151.328); /* green-800 */
                    --color-bg-light: #fdfdfc;
                    --color-bg-dark: #0a0a0a;
                    --color-text-light: #1b1b18;
                    --color-text-dark: #ededec;
                }
            }
            @layer base {
                body {
                    @apply bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC];
                }
            }
        </style>
    @endif
</head>
<body class="min-h-screen flex flex-col items-center p-6 lg:p-8 bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
    <header class="w-full max-w-4xl mb-8 text-center">
       
         @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
         @endif
        
         <h1 class="text-3xl lg:text-4xl font-semibold text-[#7917f9] dark:text-[#EDEDEC] mb-2">
            Déployer Laravel sur un serveur mutualisé
        </h1>
        
            <p class="text-[#706f6c] dark:text-[#A1A09A] text-lg">
            Guide complet – Parties 1 à 5 (Focus Hostinger - Laravel)
        </p>
    </header>

    <main class="w-full max-w-4xl space-y-10">
        <!-- --Partie 1 -->
        <section class="bg-white dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] dark:bg-[#3E3E3A] text-white dark:text-[#EDEDEC] font-medium">1</span>
                <h2 class="text-xl font-medium text-[#7917f9] dark:text-[#EDEDEC]">Comprendre les contraintes du mutualisé</h2>
            </div>
            <div class="prose prose-sm dark:prose-invert max-w-none text-[#1b1b18] dark:text-[#A1A09A] space-y-3">
                <p>Laravel est un framework moderne qui nécessite PHP 8.1+, Composer, et une structure de dossiers sécurisée. Les hébergements mutualisés (comme Hostinger Business) imposent des limites : pas d’accès SSH, pas de personnalisation serveur, et la racine web est fixe (`public_html`).</p>
                <p><strong>Objectif</strong> : adapter Laravel pour qu’il fonctionne sans exposer les dossiers sensibles (`app/`, `.env`, `vendor/`).</p>
            </div>
        </section>

        <!-- Partie 2 -->
        <section class="bg-white dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] dark:bg-[#3E3E3A] text-white dark:text-[#EDEDEC] font-medium">2</span>
                <h2 class="text-xl font-medium text-[#7917f9] dark:text-[#EDEDEC]">Préparer l’environnement sur Hostinger</h2>
            </div>
            <div class="space-y-3 text-[#1b1b18] dark:text-[#A1A09A]">
                <p>Avant tout transfert, créez un espace propre dans <strong>hPanel</strong> :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Supprimez tout contenu de <code class="bg-[#f5f5f4] dark:bg-[#2a2a29] px-1 rounded">public_html/</code> (pas d’auto-installation !)</li>
                    <li>Créez un dossier <code class="bg-[#f5f5f4] dark:bg-[#2a2a29] px-1 rounded">laravel_app/</code> <strong>en dehors de</strong> <code>public_html/</code></li>
                    <li>Vérifiez que PHP 8.1+ est activé (<strong>Hosting → Manage → PHP Configuration</strong>)</li>
                </ul>
                <p>Cette structure garantit que seul le contenu de <code>public/</code> est accessible publiquement.</p>
            </div>
        </section>

        <!-- Partie 3 -->
        <section class="bg-white dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] dark:bg-[#3E3E3A] text-white dark:text-[#EDEDEC] font-medium">3</span>
                <h2 class="text-xl font-medium text-[#7917f9] dark:text-[#EDEDEC]">Transférer et configurer votre projet</h2>
            </div>
            <div class="space-y-3 text-[#1b1b18] dark:text-[#A1A09A]">
                <p>Sur un mutualisé standard (sans SSH), le déploiement se fait manuellement :</p>
                <ol class="list-decimal pl-5 space-y-1">
                    <li>En local, exécutez :
                        <code class="block bg-[#f5f5f4] dark:bg-[#2a2a29] px-2 py-1 rounded mt-1">composer install --no-dev --optimize-autoloader</code>
                    </li>
                    <li>Téléversez tout le projet (sauf <code>public/</code>) dans <code>laravel_app/</code> via le gestionnaire de fichiers</li>
                    <li>Copiez le contenu de <code>public/</code> dans <code>public_html/</code></li>
                    <li>Modifiez <code>public_html/index.php</code> pour pointer vers <code>../laravel_app/</code></li>
                    <li>Créez un fichier <code>.env</code> dans <code>laravel_app/</code> avec vos paramètres de production</li>
                </ol>
                <p class="mt-2 text-[#7917f9]"><strong>⚠️ Important</strong> : les offres Hostinger « Web Hosting » ne permettent <strong>ni SSH ni Git</strong>. Le clonage direct n’est possible que sur les offres Cloud.</p>
            </div>
        </section>
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
    </main>

    <footer class="mt-12 text-center text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-4xl">
        <p>Prochaines étapes : configuration de la base de données, gestion des permissions, et résolution des erreurs courantes.</p>
    </footer>
</body>
</html>