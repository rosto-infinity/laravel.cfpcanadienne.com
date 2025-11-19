
# Projet Laravel : Gestion des Partenaires

Ce projet est une application web développée avec le framework Laravel. Il permet de gérer des partenaires, avec des fonctionnalités pour les utilisateurs authentifiés et les administrateurs. L'application inclut également un système de gestion des profils et des partenaires approuvés.

## Fonctionnalités

### Pages Publiques
- **Page d'accueil** : Affiche une liste paginée des partenaires approuvés.
- **Liste des partenaires** : Permet de visualiser tous les partenaires.
- **Détails d'un partenaire** : Affiche les détails d'un partenaire spécifique.

### Utilisateurs Authentifiés
- **Création de partenaires** : Les utilisateurs peuvent créer de nouveaux partenaires.
- **Édition de partenaires** : Les utilisateurs peuvent modifier leurs partenaires existants.
- **Suppression de partenaires** : Les utilisateurs peuvent supprimer leurs partenaires.
- **Mes partenaires** : Affiche une liste des partenaires créés par l'utilisateur.
- **Gestion du profil** : Les utilisateurs peuvent modifier ou supprimer leur profil.

### SuperAdmin
- **Dashboard SuperAdmin** : Interface de gestion pour les super administrateurs.
- **Approbation/Rejet de partenaires** : Les super administrateurs peuvent approuver ou rejeter les partenaires.
- **Suppression de partenaires** : Les super administrateurs peuvent supprimer des partenaires.

## Structure des Routes

### Routes Publiques
- `GET /` : Page d'accueil avec les partenaires approuvés.
- `GET /partenaires` : Liste des partenaires.
- `GET /partenaires/{partenaire}` : Détails d'un partenaire.

### Routes Authentifiées
- `GET /dashboard` : Tableau de bord utilisateur.
- `GET /partenaires/create` : Formulaire de création de partenaire.
- `POST /partenaires` : Stocke un nouveau partenaire.
- `GET /partenaires/{partenaire}/edit` : Formulaire d'édition de partenaire.
- `PUT /partenaires/{partenaire}` : Met à jour un partenaire.
- `DELETE /partenaires/{partenaire}` : Supprime un partenaire.
- `GET /mes-partenaires` : Liste des partenaires de l'utilisateur.
- `GET /profile` : Formulaire d'édition du profil.
- `PATCH /profile` : Met à jour le profil.
- `DELETE /profile` : Supprime le profil.

### Routes SuperAdmin
- `GET /superadmin/dashboard` : Tableau de bord SuperAdmin.
- `GET /superadmin/partenaires` : Liste des partenaires pour approbation.
- `GET /superadmin/partenaires/{partenaire}` : Détails d'un partenaire pour approbation.
- `PATCH /superadmin/partenaires/{partenaire}/approuver` : Approuve un partenaire.
- `PATCH /superadmin/partenaires/{partenaire}/rejeter` : Rejette un partenaire.
- `DELETE /superadmin/partenaires/{partenaire}` : Supprime un partenaire.

## Installation

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/votre-utilisateur/votre-projet.git
   ```

2. **Installer les dépendances** :
   ```bash
   composer install
   ```

3. **Configurer l'environnement** :
   Copier le fichier `.env.example` en `.env` et configurer les variables d'environnement.

4. **Générer la clé d'application** :
   ```bash
   php artisan key:generate
   ```

5. **Migrer la base de données** :
   ```bash
   php artisan migrate
   ```

6. **Démarrer le serveur** :
   ```bash
   php artisan serve
   ```

## Dépendances

- **PHP** : ^8.3
- **Laravel** : ^12.0
- **Autres dépendances** : Voir le fichier `composer.json`.


## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

-