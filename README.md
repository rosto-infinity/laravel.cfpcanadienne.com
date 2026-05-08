
# Gestion des Partenaires

Application web Laravel pour la gestion de partenaires avec système de rôles (SuperAdmin/Admin), workflow d'approbation, et authentification.

## Fonctionnalités

### Pages Publiques
- Page d'accueil avec liste paginée des partenaires approuvés
- Liste et détail des partenaires

### Utilisateurs Authentifiés
- CRUD complet des partenaires (création, édition, suppression)
- "Mes partenaires" : vue personnalisée de ses propres soumissions
- Gestion du profil (modification, suppression de compte)
- Workflow de soumission : un partenaire créé/édité repasse en statut "en_attente"

### SuperAdmin
- Dashboard d'administration
- Approbation / rejet des partenaires soumis
- Suppression de tout partenaire
- Protection contre la révocation du dernier SuperAdmin

## Stack Technique

### Backend (PHP)
| Package | Description |
|---|---|
| `laravel/framework` ^13.6 | Framework Laravel 13 |
| `laravel/tinker` ^3.0 | REPL interactif |
| `laravel/breeze` ^2.3 | Scaffolding d'authentification (Blade) |
| `laravel/pint` ^1.24 | Correcteur de style PHP |
| `laravel/sail` ^1.41 | Environnement Docker |
| `laravel/pail` ^1.2.2 | Logs en temps réel |
| `pestphp/pest` ^4.1 | Framework de tests |
| `pestphp/pest-plugin-laravel` ^4.0 | Intégration Pest pour Laravel |
| `fakerphp/faker` ^1.23 | Générateur de données factices |
| `mockery/mockery` ^1.6 | Mocking pour les tests |
| `nunomaduro/collision` ^8.6 | Gestion d'erreurs enrichie |

### Frontend (Node.js)
| Package | Description |
|---|---|
| `vite` ^7.0.7 | Bundler et serveur de développement |
| `laravel-vite-plugin` ^2.0 | Intégration Vite pour Laravel |
| `tailwindcss` ^4.1.17 | Framework CSS utilitaire |
| `@tailwindcss/vite` ^4.1.17 | Plugin Tailwind pour Vite |
| `@tailwindcss/forms` ^0.5.2 | Styles par défaut pour formulaires |
| `alpinejs` ^3.4.2 | Framework JS léger pour l'interactivité |
| `axios` ^1.11.0 | Client HTTP |
| `concurrently` ^9.0.1 | Exécution parallèle de commandes |

## Structure du Code

```
app/
├── Enums/
│   └── Role.php              # Enum des rôles (superadmin, admin)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   └── PartenaireAdminController.php
│   │   ├── Auth/              # Contrôleurs Breeze
│   │   ├── PartenaireController.php
│   │   └── ProfileController.php
│   └── Requests/
│       └── PartenaireRequest.php
├── Models/
│   ├── Partenaire.php         # Modèle avec scopes (approuves, enAttente, rejetes)
│   └── User.php               # Modèle avec système de rôles et permissions
├── ...
routes/
├── web.php                    # Routes publiques, auth, superadmin
└── auth.php                   # Routes d'authentification Breeze
```

## Installation

1. **Cloner le projet**
2. **Installer les dépendances PHP** :
   ```bash
   composer install
   ```
3. **Installer les dépendances Node.js** :
   ```bash
   npm install
   ```
4. **Configurer l'environnement** : copier `.env.example` → `.env`
5. **Générer la clé d'application** :
   ```bash
   php artisan key:generate
   ```
6. **Migrer la base de données** :
   ```bash
   php artisan migrate
   ```
7. **Compiler les assets** :
   ```bash
   npm run build
   ```
8. **Démarrer le serveur** :
   ```bash
   php artisan serve
   ```
   Ou avec la stack complète (serveur + queue + logs + Vite) :
   ```bash
   composer dev
   ```

## Tests

```bash
composer test
```

## Licence

MIT