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
    <header class="w-full max-w-7xl  mb-8 text-center">
      
           @if (Route::has('login'))
                <nav class="flex items-center justify-center gap-4">
                    <a href="/" class="inline-block ">
                    <x-application-logo class="w-12 h-12 fill-current text-[#7917f9] " /> 
                   
                </a>
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Tableau de bord
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Se connecter
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] bg-[#7917f9] text-white hover:border-[#1915014a] border dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                </nav>
           @endif
      
      
        
         <h1 class="text-3xl lg:text-4xl font-semibold text-[#7917f9] dark:text-[#EDEDEC] mt-10 mb-2">
            Déployer Laravel sur un serveur mutualisé
        </h1>
        
            <p class="text-[#706f6c] dark:text-[#A1A09A] text-lg">
            Guide complet – Parties 1 à 5 (Focus Hostinger - Laravel)
        </p>
    </header>

    <main class="w-full max-w-7xl space-y-10">
       <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-[#7917f9] to-[#7917f9] text-white">
            <h1 class="text-2xl font-bold">Guide de Déploiement Laravel sur serveur mutualisé</h1>
            <p class="mt-2">Cliquez sur les sections pour dévoiler les détails</p>
        </div>

        <!-- Sommaire -->
        <div class="p-6 bg-gray-100 border-b">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Sommaire</h2>
            <ul class="list-decimal list-inside space-y-2">
                <li class="cursor-pointer text-[#7917f9] hover:underline" onclick="scrollToSection('section1')">Comprendre les contraintes du mutualisé</li>
                <li class="cursor-pointer text-[#7917f9] hover:underline" onclick="scrollToSection('section2')">Préparer l'environnement sur Hostinger</li>
                <li class="cursor-pointer text-[#7917f9] hover:underline" onclick="scrollToSection('section3')">Transférer et configurer votre projet</li>
            </ul>
        </div>

        <!-- Accordéon -->
        <div class="divide-y divide-gray-200">
            <!-- Partie 1 -->
            <div class="accordion-item" id="section1">
                <input class="accordion-toggle hidden" type="checkbox" id="toggle1">
                <label for="toggle1" class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] text-white font-medium">1</span>
                        <h2 class="text-xl font-medium text-gray-800">Comprendre les contraintes du mutualisé</h2>
                    </div>
                    <svg class="accordion-icon w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </label>
                <div class="accordion-content">
                    <div class="px-6 pb-6 prose max-w-none text-gray-700 space-y-3">
                        <p>Laravel est un framework moderne qui nécessite PHP 8.1+, Composer, et une structure de dossiers sécurisée. Les hébergements mutualisés (comme Hostinger Business) imposent des limites : pas d'accès SSH, pas de personnalisation serveur, et la racine web est fixe (<code>public_html</code>).</p>
                        <p><strong>Objectif</strong> : adapter Laravel pour qu'il fonctionne sans exposer les dossiers sensibles (<code>app/</code>, <code>.env</code>, <code>vendor/</code>).</p>
                    </div>
                </div>
            </div>

            <!-- Partie 2 -->
            <div class="accordion-item" id="section2">
                <input class="accordion-toggle hidden" type="checkbox" id="toggle2">
                <label for="toggle2" class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] text-white font-medium">2</span>
                        <h2 class="text-xl font-medium text-gray-800">Préparer l'environnement sur Hostinger</h2>
                    </div>
                    <svg class="accordion-icon w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </label>
                <div class="accordion-content">
                    <div class="px-6 pb-6 text-gray-700 space-y-3">
                        <p>Avant tout transfert, créez un espace propre dans <strong>hPanel</strong> :</p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Supprimez tout contenu de <code class="bg-gray-100 px-1 rounded">public_html/</code> (pas d'auto-installation !)</li>
                            <li>Créez un dossier <code class="bg-gray-100 px-1 rounded">laravel_app/</code> <strong>en dehors de</strong> <code>public_html/</code></li>
                            <li>Vérifiez que PHP 8.1+ est activé (<strong>Hosting → Manage → PHP Configuration</strong>)</li>
                        </ul>
                        <p>Cette structure garantit que seul le contenu de <code>public/</code> est accessible publiquement.</p>
                    </div>
                </div>
            </div>

            <!-- Partie 3 -->
            <div class="accordion-item" id="section3">
                <input class="accordion-toggle hidden" type="checkbox" id="toggle3">
                <label for="toggle3" class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] text-white font-medium">3</span>
                        <h2 class="text-xl font-medium text-gray-800">Transférer et configurer votre projet</h2>
                    </div>
                    <svg class="accordion-icon w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </label>
                <div class="accordion-content">
                    <div class="px-6 pb-6 text-gray-700 space-y-3">
                        <p>Sur un mutualisé standard (sans SSH), le déploiement se fait manuellement :</p>
                        <ol class="list-decimal pl-5 space-y-1">
                            <li>En local, exécutez :
                                <code class="block bg-gray-100 px-2 py-1 rounded mt-1">composer install --no-dev --optimize-autoloader</code>
                            </li>
                            <li>Téléversez tout le projet (sauf <code>public/</code>) dans <code>laravel_app/</code> via le gestionnaire de fichiers</li>
                            <li>Copiez le contenu de <code>public/</code> dans <code>public_html/</code></li>
                            <li>Modifiez <code>public_html/index.php</code> pour pointer vers <code>../laravel_app/</code></li>
                            <li>Créez un fichier <code>.env</code> dans <code>laravel_app/</code> avec vos paramètres de production</li>
                        </ol>
                        <p class="mt-2 text-[#7917f9]"><strong>⚠️ Important</strong> : les offres Hostinger « Web Hosting » ne permettent <strong>ni SSH ni Git</strong>. Le clonage direct n'est possible que sur les offres Cloud.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
       
          

 <section class="bg-white dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7917f9] dark:bg-[#3E3E3A] text-white dark:text-[#EDEDEC] font-medium">★</span>
                <h2 class="text-xl font-medium text-[#7917f9] dark:text-[#EDEDEC]">Nos Partenaires</h2>
            </div>
            <div class="prose prose-sm dark:prose-invert max-w-none text-[#1b1b18] dark:text-[#A1A09A] space-y-4">
                <p>Découvrez notre réseau de partenaires experts en développement Laravel et hébergement web. Ces professionnels partagent leur expertise et contribuent à enrichir notre communauté.</p>
                <p>Vous proposez des services complémentaires ? Rejoignez notre écosystème de partenaires privilégiés.</p>
                
                <!-- Bouton d'inscription -->
                {{-- <div class="mt-6">
                    @auth
                        <a href="{{ route('partenaires.create') }}" class="inline-flex items-center px-6 py-3 bg-[#7917f9] hover:bg-[#6a14e0] text-white rounded-lg font-medium transition-colors duration-200 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Proposer un partenariat
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-[#7917f9] hover:bg-[#6a14e0] text-white rounded-lg font-medium transition-colors duration-200 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            S'inscrire et proposer un partenariat
                        </a>
                    @endauth
                </div> --}}
            </div>
        </section>

 <!-- Partenaires Grid -->
@if($partenaires->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($partenaires as $partenaire)
            <div class="group bg-white dark:bg-[#161615] rounded-2xl border border-gray-200 dark:border-[#3E3E3A] overflow-hidden transition-all duration-300 hover:border-[#7917f9]/30 hover:shadow-lg hover:-translate-y-1">
                <!-- Logo Header -->
                <div class="bg-gradient-to-br from-[#7917f9]/10 to-[#7917f9]/5 dark:from-[#7917f9]/20 dark:to-[#7917f9]/10 p-6 flex items-center justify-center min-h-[160px]">
                    @if($partenaire->logo)
                        <img src="{{ $partenaire->logo_url }}" alt="{{ $partenaire->nom }}" class="max-h-28 max-w-full object-contain transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="flex items-center justify-center w-24 h-24 rounded-xl bg-gradient-to-br from-[#7917f9] to-[#7917f9] shadow-lg">
                            <span class="text-3xl font-bold text-white">{{ substr($partenaire->nom, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#7917f9] transition-colors">
                            {{ $partenaire->nom }}
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#7917f9]/10 text-[#7917f9] dark:bg-[#7917f9]/20 dark:text-[#7917f9]">
                            Partenaire
                        </span>
                    </div>
                    
                    @if($partenaire->description)
                        <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm mb-5 line-clamp-3 leading-relaxed">
                            {{ $partenaire->description }}
                        </p>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-3 border-t border-[#f5f5f4] dark:border-[#2a2a29]">
                        @if($partenaire->siteweb)
                            <a href="{{ $partenaire->siteweb }}" target="_blank" class="inline-flex items-center gap-2 text-[#7917f9] hover:text-[#7917f9]/80 font-medium text-sm transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                <span class="group-hover:underline">Site web</span>
                            </a>
                        @endif
                        
                        <a href="{{ route('partenaires.show', $partenaire) }}" class="inline-flex items-center gap-1.5 text-[#7917f9] hover:text-[#7917f9]/80 font-medium text-sm transition-colors group/button">
                            <span>Voir détails</span>
                            <svg class="h-4 w-4 transition-transform group-hover/button:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination - Design modernisé -->
    <div class="mt-8">
        <div class="bg-white dark:bg-[#161615] rounded-xl border border-gray-200 dark:border-[#3E3E3A] p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Affichage de {{ $partenaires->firstItem() }} à {{ $partenaires->lastItem() }} sur {{ $partenaires->total() }} partenaires
                </div>
                <div class="flex flex-wrap justify-center gap-2">
                    {{ $partenaires->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="bg-white dark:bg-[#161615] rounded-2xl border border-dashed border-gray-300 dark:border-[#3E3E3A] p-10 text-center">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7917f9]/10 to-[#7917f9]/5 dark:from-[#7917f9]/20 dark:to-[#7917f9]/10 mb-5">
            <svg class="h-8 w-8 text-[#7917f9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Aucun partenaire pour le moment</h3>
        <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6 max-w-md mx-auto">
            Rejoignez notre réseau de partenaires et bénéficiez d'une visibilité accrue auprès de notre communauté de développeurs Laravel.
        </p>
        @auth
            <a href="{{ route('partenaires.create') }}" class="inline-flex items-center justify-center bg-gradient-to-r from-[#7917f9] to-[#7917f9] hover:from-[#7917f9]/90 hover:to-[#7917f9]/90 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 hover:scale-[1.02] shadow-lg hover:shadow-[#7917f9]/20">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Devenir Partenaire
            </a>
        @endauth
    </div>
@endif
               <!-- Section d'inscription partenaires -->
<section class="bg-white dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] p-6 lg:p-8 mb-10">
    <div class="text-center max-w-3xl mx-auto">
        <div class="flex justify-center mb-4">
            <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#7917f9] dark:bg-[#3E3E3A] text-white dark:text-[#EDEDEC] font-bold text-lg">
                ✨
            </div>
        </div>
        
        <h2 class="text-2xl lg:text-3xl font-bold text-[#7917f9] dark:text-[#EDEDEC] mb-4">
            Devenez un partenaire officiel
        </h2>
        
        <p class="text-[#1b1b18] dark:text-[#A1A09A] text-lg mb-6">
            Rejoignez notre réseau d'experts et bénéficiez d'une visibilité accrue auprès de notre communauté de développeurs Laravel. Partagez vos services, votre expertise et collaborez sur des projets innovants.
        </p>
        
        <div class="flex justify-center">
            @auth
                <a href="{{ route('partenaires.create') }}" 
                   class="inline-flex items-center justify-center bg-gradient-to-r from-[#7917f9] to-[#7917f9] hover:from-[#7917f9]/90 hover:to-[#7917f9]/90 text-white px-8 py-3 rounded-xl font-medium text-lg transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-[#7917f9]/30">
                    <span>Inscrivez votre entreprise</span>
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center justify-center bg-gradient-to-r from-[#7917f9] to-[#7917f9] hover:from-[#7917f9]/90 hover:to-[#7917f9]/90 text-white px-8 py-3 rounded-xl font-medium text-lg transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-[#7917f9]/30">
                    <span>Créez un compte puis devenez partenaire</span>
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            @endauth
        </div>
        
        <div class="mt-8 pt-6 border-t border-[#f5f5f4] dark:border-[#2a2a29]">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                <span class="font-medium text-[#7917f9] dark:text-[#EDEDEC]">Avantages partenaires :</span> 
                Visibilité sur notre plateforme, accès à des projets exclusifs, support technique prioritaire et possibilité de collaboration sur des tutoriels et formations.
            </p>
        </div>
    </div>
</section>
   
    </main>
<script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
            
            // Ouvrir la section
            const toggle = document.querySelector(`#${sectionId} .accordion-toggle`);
            if (toggle) {
                toggle.checked = true;
            }
        }
    </script>

     <style>
        
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-toggle:checked ~ .accordion-content {
            max-height: 500px;
        }
        .accordion-toggle:checked + label .accordion-icon {
            transform: rotate(180deg);
        }
    </style>
    <footer class="mt-12 text-center text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-4xl">
        <p>Prochaines étapes : configuration de la base de données, gestion des permissions, et résolution des erreurs courantes.</p>
    </footer>
</body>
</html>