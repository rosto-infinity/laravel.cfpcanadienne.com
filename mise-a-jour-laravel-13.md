# Mise à jour Laravel 13 : comment j'ai tout updaté sans tout casser

Vous utilisez encore Laravel 12 ? Vous hésitez à faire le grand saut vers **Laravel 13** ? Je vous comprends. Chaque mise à jour majeure, c'est un peu comme rénover votre cuisine : vous avez peur de tout casser et de vous retrouver à manger des pâtes pendant un mois.

Pourtant, la mise à jour de Laravel vers la version 13 est plus douce qu'elle en a l'air. Et avec les bonnes commandes, vous pouvez passer de Laravel 12 à 13 en quelques minutes. Je viens de le faire. Voici comment.

---

## Pourquoi mettre à jour vers Laravel 13 ?

Laravel 13 n'est pas juste un chiffre de plus. C'est une vraie évolution. Vous savez, ce sentiment quand votre téléphone commence à rameuter et que la batterie fond ? C'est pareil pour une vieille version de Laravel.

**Les avantages concrets :**

- **Performances optimisées** — Votre application répond plus vite, vos utilisateurs sont plus heureux.
- **Nouvelles fonctionnalités** — Laravel 13 apporte des améliorations sur les queues, les notifications, et le routing.
- **Sécurité renforcée** — Les failles des versions précédentes sont corrigées.
- **Support à long terme** — Vous partez sur des bases solides pour les mois à venir.

> **Question rhétorique** : Pourquoi se priver des dernières avancées de l'écosystème Laravel ?

## Les problèmes que j'ai rencontrés (et comment je les ai résolus)

Spoiler : tout ne s'est pas passé comme dans un rêve. Voici le vrai du faux.

### Laravel Tinker ne supportait pas Laravel 13

**Le problème :** Mon `composer.json` demandait `laravel/tinker ^2.10.1`. Problème : cette version ne supporte que les illuminate/support jusqu'à la v12. Laravel 13 utilise illuminate/support v13. Résultat ? Impossible d'installer.

**La solution :** Passer à `laravel/tinker ^3.0`. La v3 de Tinker supporte Laravel 13 sans sourciller.

```bash
composer require laravel/tinker:^3.0
```

### Pest Plugin Laravel refusait de coopérer

**Le problème :** La version `4.0.0` de `pestphp/pest-plugin-laravel` ne supporte que Laravel 11 et 12. Pas de 13.

**La solution :** La version `4.1.0` règle le problème. Avec un simple `composer update`, tout s'est résolu tout seul. C'est beau, la vie.

### Symfony passe en v8

Et oui. Tous les packages Symfony (console, http-foundation, var-dumper, etc.) sont passés de la v7 à la v8. C'est un changement majeur, mais sans breaking change pour vos applications — si vous n'utilisez pas ces composants directement.

## Comment j'ai procédé (la méthode pas à pas)

Vous voulez reproduire l'opération chez vous ? Voici la recette.

### 1. Mettez à jour votre constraint Laravel

Dans votre `composer.json` :

```json
"laravel/framework": "^13.6"
```

### 2. Vérifiez vos autres dépendances

Regardez chaque package qui pourrait bloquer. Les principaux coupables sont souvent :

- `laravel/tinker` — doit être en ^3.0
- `pestphp/pest-plugin-laravel` — doit être en ^4.1
- `laravel/breeze`, `laravel/sail`, `laravel/pail` — généralement compatibles, mais vérifiez

### 3. Lancez la commande magique

```bash
composer update
```

**Astuce :** Si vous avez des dépendances bloquées, utilisez `composer update -W` (with-all-dependencies). Cette option force composer à trouver une solution, quitte à downgrader des packages.

### 4. Profitez du résultat

Mon terminal m'a affiché :

- 78 packages mis à jour
- 3 nouveaux packages installés
- 1 package supprimé
- 0 erreur

## Les packages qui ont changé de version majeure

Voici la liste des changements importants :

| Package | Avant | Après |
|---|---|---|
| **laravel/framework** | v12.32.5 | **v13.8.0** |
| **laravel/tinker** | v2.10.1 | **v3.0.2** |
| **pestphp/pest-plugin-laravel** | v4.0.0 | **v4.1.0** |
| **nunomaduro/collision** | v8.8.2 | **v8.9.4** |
| **psy/psysh** | v0.12.12 | **v0.12.22** |
| **pestphp/pest** | v4.1.1 | **v4.7.0** |

## Questions fréquentes (FAQ)

### Est-ce que Laravel 13 est une version stable ?

Oui, Laravel 13 est une version stable et supportée officiellement par l'équipe Laravel.

### Dois-je modifier mon code après la mise à jour ?

Dans mon cas, aucun code n'a eu besoin d'être modifié. Mais lisez toujours les notes de version (release notes) pour vérifier les éventuels breaking changes.

### Et si une mise à jour casse mon application ?

Utilisez Git ! Faites un commit avant de lancer `composer update`. Si quelque chose se casse, `git checkout .` et vous revenez en arrière en une seconde.

### Laravel 12 est-il encore supporté ?

Laravel 12 reçoit encore des correctifs de sécurité, mais Laravel 13 est la version recommandée pour les nouveaux projets.

### Combien de temps prend une mise à jour comme celle-ci ?

Compter 15 à 30 minutes max si vous suivez cette méthode. Le temps que composer télécharge et installe les packages.

## Conclusion : lancez-vous !

Mettre à jour Laravel n'est pas un supplice. C'est une opportunité. Vous offrez à votre application les dernières technologies, les meilleures performances, et une sécurité renforcée.

**Rappelez-vous :**
- Vérifiez vos contraintes de version dans composer.json
- Utilisez `composer update -W` si besoin
- Testez votre application après la mise à jour
- Et surtout, faites un commit avant de commencer !

Alors, prêt à faire le grand saut vers Laravel 13 ? Votre application vous remerciera. Et vous, vous dormirez mieux.
