# Negre Shop

Application web de présentation et de gestion d'une boutique artistique. Le site met en avant des peintures, des créations de design et des produits de marques, et propose une galerie d'activités ainsi que des formulaires de contact et de demande de commande.

> Les demandes sont enregistrées dans la base de données. Le projet ne contient pas de paiement en ligne.

## Fonctionnalités

- **Vitrine publique** : accueil, peintures, design, marques, galerie/workshop et contact.
- **Catalogue administrable** : catégories, produits, disponibilité, mise en avant et ordre d'affichage.
- **Demandes de commande** : formulaire associé à un produit et suivi du statut dans l'administration.
- **Contact** : formulaire de contact et consultation des messages depuis l'administration.
- **Contenu du site** : gestion des activités, du carrousel et de plusieurs contenus de page.
- **Administration avec rôles** : comptes administrateur et super-administrateur ; les réglages développeur sont réservés au super-administrateur.
- **Intégrations facultatives** : EmailJS pour les courriels côté navigateur et WhatsApp pour les liens de contact.

## Technologies

- PHP 8.2 ou ultérieur
- Laravel 12
- MySQL (configuration proposée par défaut) ; SQLite est configuré pour les tests
- Node.js et npm, Vite et Tailwind CSS

## Installation locale

Prérequis : PHP et Composer, Node.js et npm, ainsi qu'un serveur de base de données MySQL si vous conservez la configuration par défaut.

1. Récupérer le projet et installer les dépendances :

   ```sh
   git clone <URL_DU_DEPOT>
   cd negre-shop-laravel
   composer install
   npm install
   ```

2. Créer le fichier d'environnement et la clé Laravel :

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   Dans un terminal Bash, utilisez `cp .env.example .env` à la place de `Copy-Item`.

3. Configurer `.env` :

   - Renseignez `APP_NAME` et `APP_URL`.
   - Pour MySQL, créez une base de données puis renseignez `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD`.
   - Pour SQLite, créez `database/database.sqlite`, puis réglez `DB_CONNECTION=sqlite` et `DB_DATABASE=database/database.sqlite`.
   - Renseignez les paramètres EmailJS et WhatsApp si vous souhaitez activer ces intégrations (voir ci-dessous).
   - Pour créer le premier super-administrateur pendant l'initialisation, renseignez `SEED_ADMIN_EMAIL` et un `SEED_ADMIN_PASSWORD` unique d'au moins 12 caractères. `SEED_ADMIN_NAME` est facultatif. Ces valeurs ne doivent jamais être publiées.

4. Créer les tables et les données de démonstration, puis compiler les ressources :

   ```sh
   php artisan migrate --seed
   php artisan storage:link
   npm run build
   ```

5. Démarrer l'application :

   ```sh
   composer run dev
   ```

   L'application est généralement accessible à l'adresse indiquée par `php artisan serve`, par défaut `http://127.0.0.1:8000`.

Pour le développement front-end seul, `npm run dev` démarre Vite. La commande `composer run dev` lance les processus de développement Laravel, de file d'attente, de logs et de Vite en parallèle.

## Configuration des intégrations

Les paramètres sont lus depuis `.env` et déclarés dans `config/services.php` :

| Variable | Utilisation |
| --- | --- |
| `WHATSAPP_NUMBER` | Numéro utilisé pour les liens WhatsApp, au format international sans `+` ni espaces |
| `EMAILJS_PUBLIC_KEY` | Clé publique EmailJS utilisée par le navigateur |
| `EMAILJS_SERVICE_ID` | Service EmailJS |
| `EMAILJS_TEMPLATE_ID` | Modèle EmailJS des messages envoyés depuis le site |
| `EMAILJS_TEMPLATE_ADMIN_ID` | Modèle facultatif pour la notification à l'administration |
| `ADMIN_EMAIL` | Adresse destinataire des notifications administrateur |
| `ADMIN_NAME` | Nom associé à l'administration dans les modèles |
| `SEED_ADMIN_NAME` | Nom du compte super-administrateur initial (facultatif) |
| `SEED_ADMIN_EMAIL` | Adresse de connexion du compte initial ; à renseigner avec le mot de passe |
| `SEED_ADMIN_PASSWORD` | Mot de passe initial, requis avec l'adresse e-mail et long d'au moins 12 caractères |

EmailJS est appelé côté navigateur : configurez et restreignez la clé publique depuis votre compte EmailJS. Ne placez jamais de clé privée ou de secret serveur dans le code front-end. Les formulaires enregistrent aussi leurs données côté Laravel ; l'envoi d'e-mails dépend de la configuration de l'intégration.

Le seeder ne crée aucun compte administrateur par défaut. Si `SEED_ADMIN_EMAIL` et `SEED_ADMIN_PASSWORD` sont renseignés, `php artisan migrate --seed` crée le compte super-administrateur initial. Ne réutilisez pas ces identifiants dans un dépôt public.

## Pages et accès

| Adresse | Contenu |
| --- | --- |
| `/` | Accueil |
| `/peinture` | Peintures |
| `/design` | Design |
| `/marques` | Produits de marques |
| `/gallery` | Galerie, activités et événements |
| `/contact` | Informations et formulaire de contact |
| `/login` | Connexion |
| `/admin/dashboard` | Tableau de bord d'administration (après connexion) |

Les routes d'administration sont protégées par authentification et rôle. L'inscription publique est désactivée. Les routes de gestion des contenus développeur sont réservées au super-administrateur.

## Tests et compilation

```sh
php artisan test
npm run build
```

Les tests utilisent SQLite en mémoire via `phpunit.xml`.

## Avant tout déploiement

- Configurez un compte super-administrateur avec un mot de passe unique et robuste ; aucun identifiant administrateur par défaut n'est créé.
- Générez une clé `APP_KEY` propre à chaque environnement et vérifiez qu'aucune donnée sensible ne se trouve dans les fichiers suivis par Git.
- Configurez une base de données, les sauvegardes, HTTPS, les paramètres de courrier et les restrictions EmailJS adaptés à l'environnement de production.
- N'activez pas `APP_DEBUG` en production.
- Le dépôt ne définit pas encore de licence. Choisissez-en une avant de présenter le code comme un logiciel libre ou open source.

## Licence

Aucune licence n'est actuellement définie dans ce dépôt.
