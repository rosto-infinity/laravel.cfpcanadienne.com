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
        <h1 class="text-3xl lg:text-4xl font-semibold text-[#7917f9] dark:text-[#EDEDEC] mb-2">
            Déployer Laravel sur un serveur mutualisé
        </h1>
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
    </main>

    <footer class="mt-12 text-center text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-4xl">
        <p>Prochaines étapes : configuration de la base de données, gestion des permissions, et résolution des erreurs courantes.</p>
    </footer>
</body>
</html>