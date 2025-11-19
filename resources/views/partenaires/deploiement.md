# 🚀 Système de Gestion des Partenaires - Guide Complet

## 📋 Table des Matières
1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Déploiement](#deploiement)
4. [Utilisation](#utilisation)
5. [Sécurité](#securite)

---

## 🛠️ Installation

### 1. Créer la Migration

```bash
php artisan make:migration create_partenaires_table
```

Copiez le contenu de la migration fournie dans le fichier généré.

### 2. Exécuter la Migration

```bash
php artisan migrate
```

### 3. Créer le Lien Symbolique pour le Stockage

```bash
php artisan storage:link
```

Cette commande crée un lien symbolique de `public/storage` vers `storage/app/public`, permettant l'accès public aux logos uploadés.

### 4. Créer les Fichiers

Créez les fichiers suivants avec le contenu fourni :

```
app/
├── Models/
│   └── Partenaire.php
├── Http/
│   ├── Controllers/
│   │   └── PartenaireController.php
│   └── Requests/
│       └── PartenaireRequest.php
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php
    └── partenaires/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        ├── show.blade.php
        └── mes-partenaires.blade.php
```

### 5. Ajouter les Routes

Ajoutez le contenu des routes dans `routes/web.php`

---

## ⚙️ Configuration

### 1. Configurer le Filesystem (config/filesystems.php)

Assurez-vous que le disque `public` est configuré :

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### 2. Permissions des Dossiers

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Configuration du .env

```env
APP_URL=https://votredomaine.com
FILESYSTEM_DISK=public
```

### 4. Mise à Jour du Model User (app/Models/User.php)

Ajoutez la relation dans le modèle User :

```php
public function partenaires()
{
    return $this->hasMany(Partenaire::class);
}
```

---

## 🌐 Déploiement sur Serveur Mutualisé (Hostinger)

### Structure des Dossiers

```
/home/username/
├── laravel_app/           # Votre application Laravel
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/          # Logs et fichiers uploadés
│   │   └── app/
│   │       └── public/
│   │           └── partenaires/  # Logos des partenaires
│   ├── vendor/
│   ├── .env
│   └── ...
└── public_html/          # Racine web publique
    ├── storage -> ../laravel_app/storage/app/public
    ├── index.php
    ├── .htaccess
    └── ...
```

### Étapes de Déploiement

#### 1. Préparer Localement

```bash
# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Compiler les assets
npm run build

# Créer le cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 2. Télécharger les Fichiers

- **Via FTP/SFTP** : Téléchargez tous les fichiers sauf `public/` dans `laravel_app/`
- **Dossier public** : Copiez le contenu de `public/` dans `public_html/`

#### 3. Modifier index.php (public_html/index.php)

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Modifier ces chemins pour pointer vers laravel_app/
require __DIR__.'/../laravel_app/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

#### 4. Créer le Lien Symbolique Manuellement

Via le gestionnaire de fichiers Hostinger ou SSH (si disponible) :

```bash
cd public_html
ln -s ../laravel_app/storage/app/public storage
```

**Sans SSH** : Créez un fichier `create_link.php` dans `public_html/` :

```php
<?php
symlink('../laravel_app/storage/app/public', 'storage');
echo "Lien symbolique créé !";
// Supprimez ce fichier après utilisation
```

Visitez `https://votredomaine.com/create_link.php`, puis **supprimez le fichier**.

#### 5. Configurer .htaccess (public_html/.htaccess)

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirection HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Laravel Routing
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Sécurité
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protection des fichiers sensibles
<FilesMatch "(\.env|composer\.json|composer\.lock|package\.json)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### 6. Protéger le Dossier laravel_app/

Créez `.htaccess` dans `laravel_app/` :

```apache
Order deny,allow
Deny from all
```

#### 7. Permissions

```bash
chmod -R 755 laravel_app/storage
chmod -R 755 laravel_app/bootstrap/cache
chmod -R 755 public_html/storage
```

#### 8. Configurer la Base de Données

Dans `laravel_app/.env` :

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=votre_base
DB_USERNAME=votre_user
DB_PASSWORD=votre_password
```

#### 9. Exécuter les Migrations

Via Artisan (si SSH disponible) :
```bash
cd laravel_app
php artisan migrate --force
```

**Sans SSH** : Utilisez un script temporaire `migrate.php` dans `public_html/` :

```php
<?php
require __DIR__.'/../laravel_app/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArrayInput([
        'command' => 'migrate',
        '--force' => true,
    ]),
    new Symfony\Component\Console\Output\BufferedOutput
);

echo $status === 0 ? "Migration réussie !" : "Erreur migration";
// SUPPRIMEZ CE FICHIER après utilisation !
```

---

## 📱 Utilisation

### Pour les Utilisateurs

1. **S'inscrire/Se connecter** : Authentification requise
2. **Soumettre un Partenariat** : 
   - Aller sur "Devenir Partenaire"
   - Remplir le formulaire (nom, logo, site web, description)
   - Soumettre → Statut "En attente"

3. **Gérer ses Partenariats** :
   - "Mes Partenariats" → Voir tous ses partenariats
   - Modifier, supprimer
   - Statuts : En attente / Approuvé / Rejeté

### Pour les Administrateurs

Créez un système d'administration pour approuver/rejeter :

```php
// Route admin (à ajouter)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::patch('/admin/partenaires/{partenaire}/approve', function(Partenaire $partenaire) {
        $partenaire->update(['statut' => 'approuve']);
        return back()->with('success', 'Partenaire approuvé !');
    })->name('admin.partenaires.approve');
    
    Route::patch('/admin/partenaires/{partenaire}/reject', function(Partenaire $partenaire) {
        $partenaire->update(['statut' => 'rejete']);
        return back()->with('success', 'Partenaire rejeté !');
    })->name('admin.partenaires.reject');
});
```

---

## 🔒 Sécurité

### 1. Validation des Images

Le système valide automatiquement :
- Types MIME acceptés : jpeg, png, jpg, gif, svg, webp
- Taille max : 2 MB
- Vérification que c'est bien une image

### 2. Protection CSRF

Tous les formulaires incluent `@csrf`

### 3. Autorisation

- Seul le propriétaire peut modifier/supprimer son partenariat
- Les partenaires non approuvés ne sont pas visibles publiquement

### 4. Recommandations Supplémentaires

```php
// Dans config/app.php
'debug' => env('APP_DEBUG', false),

// Dans .env (production)
APP_DEBUG=false
APP_ENV=production
```

### 5. Sauvegardes

Créez un cron pour sauvegarder régulièrement :
- Base de données
- Dossier `storage/app/public/partenaires/`

---

## 🎨 Personnalisation

### Modifier les Couleurs

Dans les vues, remplacez les classes Tailwind :
- `from-purple-600 to-pink-600` → Vos couleurs
- `text-purple-600` → Votre couleur primaire

### Ajouter des Champs

1. Créer une nouvelle migration :
```bash
php artisan make:migration add_fields_to_partenaires_table
```

2. Ajouter les champs dans la migration, le model, et le FormRequest

3. Mettre à jour les vues

---

## 🐛 Dépannage

### Erreur : "The stream or file could not be opened"
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Images non affichées
- Vérifier que le lien symbolique existe : `ls -la public_html/storage`
- Vérifier `APP_URL` dans `.env`
- Permissions : `chmod -R 755 storage/app/public`

### Erreur 500
- Activer temporairement `APP_DEBUG=true`
- Vérifier les logs : `storage/logs/laravel.log`
- Vérifier permissions des dossiers

---

## 📞 Support

Pour toute question :
1. Vérifiez les logs Laravel
2. Consultez la documentation Laravel
3. Vérifiez la configuration Hostinger

---

**Bon déploiement ! 🚀**