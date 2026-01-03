# 🎄 Calendrier de l'Avent 2026 - Projet Complet

Calendrier de l'Avent familial interactif avec backend Symfony, base PostgreSQL et frontend React.

---

## 📊 État d'avancement

| Composant | Statut | Avancement |
|-----------|--------|------------|
| **Backend API (Symfony)** | ✅ Terminé | 100% |
| **Base de données (PostgreSQL)** | ✅ Terminée | 100% |
| **Maquettes mobile (Figma)** | ✅ Terminées | 100% |
| **Maquettes desktop (Figma)** | ✅ Terminées | 100% |
| **Frontend React** | ⏳ En attente | 0% |

**Dernière mise à jour :** 3 janvier 2026  
**Prochaine étape :** Développement frontend React

---

## 📋 Table des matières

- [Présentation](#présentation)
- [Architecture](#architecture)
- [Maquettes Figma](#maquettes-figma)
- [Backend - Installation](#installation)
- [Backend - Authentification](#authentification)
- [Backend - Endpoints API](#endpoints-api)
- [Backend - Modèles de données](#modèles-de-données)
- [Backend - Exemples](#exemples)
- [Backend - Sécurité](#sécurité)

---

## 🎯 Présentation

Calendrier de l'Avent familial où chaque membre de la famille peut :
- Se connecter avec un code famille partagé
- Choisir son profil personnalisé
- Ouvrir les portes du calendrier (1 par jour du 1er au 24 décembre)
- **Uploader des photos de leurs défis réalisés** 📸
- **Voir la galerie familiale** avec toutes les photos
- Bénéficier d'un thème visuel adapté à son âge

**Stack technique :**

**Backend :**
- Symfony 7.4
- PostgreSQL
- JWT (Lexik Bundle)
- API Platform
- Doctrine ORM

**Frontend (à développer) :**
- React
- Axios (API calls)
- React Router
- CSS Modules / Tailwind

**Design :**
- Figma (maquettes mobile & desktop complètes)

---

## 🏗️ Architecture

### Modèle multi-tenant par famille

```
FamilyGroup (code famille partagé: NOEL2026)
    ↓
User (pas d'email/password individuel)
    ↓
Famille (profil avec thème personnalisé)
    ↓
DoorOpening (historique des portes ouvertes)
    ↓
Photo (photos uploadées des défis)
```

### Entités principales

1. **FamilyGroup** : Représente une famille (1 code partagé)
2. **User** : Membre de la famille (authentification par sélection de profil)
3. **Famille** : Profil utilisateur avec thème visuel
4. **Theme** : Thème graphique (4 types : enfant, ado, parent, grand-parent)
5. **Door** : Porte du calendrier (24 portes du 1er au 24 décembre)
6. **DoorOpening** : Enregistrement d'ouverture de porte par user
7. **Photo** : Photo uploadée pour un défi (galerie familiale) 📸

---

## 🎨 Maquettes Figma

### ✅ Maquettes Mobile (Terminées - 9 wireframes)

**Écrans réalisés :**
1. **Écran 0 - Accueil** : Page d'accueil responsive
2. **Écran 1 - Authentification** : Formulaire code famille
3. **Écran 1a - Inscription** : Création famille
4. **Écran 2 - Sélection profils** : 6 profils en grille
5. **Écran 3 - Calendrier** : 24 portes adaptées mobile
6. **Écran 4 - Défis** : Détail porte/défi
7. **Écran 5 - Profil** : Page profil utilisateur
8. **Écran 6 - Ajouter membre** : Formulaire ajout profil
9. **Écran 7 - Galerie** : Galerie photos familiale

**Caractéristiques :**
- Responsive 375px (mobile standard)
- 4 thèmes différents selon l'âge
- Animations de portes
- Upload photo intégré

### ✅ Maquettes Desktop (Terminées - 9 écrans)

**Écrans réalisés :**
1. **Écran 0 - Accueil** : Page d'accueil avec 2 boutons (Créer/Se connecter)
2. **Écran 1 - Authentification** : Formulaire code famille
3. **Écran 1a - Inscription** : Création famille complète (nom, code, email, premier profil admin)
4. **Écran 2 - Sélection profils** : Netflix-style avec 6 avatars, vidéo fond, musique
5. **Écran 3 - Calendrier** : 24 portes avec thème personnalisé (ex: cheminée cosy pour Mamie)
6. **Écran 4 - Défis** : Détail porte avec lutin, message, vidéo tuto, upload photo
7. **Écran 5 - Profil** : Stats réalisations (3/24 défis, 12.5%), mes photos, RGPD
8. **Écran 6 - Ajouter membre** : Formulaire ajout nouveau profil à la famille
9. **Écran 7 - Galerie** : Layout masonry, filtres par membre/jour, attribution photos

**Thèmes personnalisés par profil :**
- **Khyle (4 ans)** : Village coloré et joyeux
- **Khelyann (16 ans)** : Neige moderne et épurée
- **Papa/Maman** : Cheminée cosy et chaleureuse
- **Mamie/Papy** : Traditionnel et nostalgique

**Lien Figma :** *(à ajouter)*

---

## 💻 Installation

### Prérequis

- PHP 8.2+
- Composer
- PostgreSQL 14+
- Symfony CLI
- Node.js 18+ (pour le frontend)

### Installation Backend

```bash
# 1. Clone le projet
git clone https://github.com/chabriermanu/calendar_event.git
cd calendar_event/backend

# 2. Installe les dépendances
composer install

# 3. Configure la BDD
# Édite .env.local avec tes identifiants PostgreSQL
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/advent_calendar"

# 4. Génère les clés JWT
php bin/console lexik:jwt:generate-keypair

# 5. Crée la base de données
php bin/console doctrine:database:create

# 6. Exécute les migrations
php bin/console doctrine:migrations:migrate

# 7. Charge les fixtures (données de test)
php bin/console doctrine:fixtures:load

# 8. Démarre le serveur
symfony serve
```

**API disponible sur :** `http://localhost:8000`

### Installation Frontend (à venir)

```bash
# À définir lors du développement React
cd frontend
npm install
npm run dev
```

---

## 🔐 Authentification

### Flow d'authentification en 2 étapes

#### Étape 1 : Vérifier le code famille

**Endpoint :** `POST /auth/family`

**Body :**
```json
{
  "code": "NOEL2026"
}
```

**Réponse (200 OK) :**
```json
{
  "familyId": 1,
  "familyName": "Famille Noël 2026",
  "users": [
    {
      "id": 1,
      "pseudo": "Khyle",
      "avatar": "avatar_khyle.png",
      "age": 4
    }
    // ... 5 autres profils
  ]
}
```

---

#### Étape 2 : Sélectionner un profil

**Endpoint :** `POST /auth/profile`

**Body :**
```json
{
  "familyId": 1,
  "userId": 3
}
```

**Réponse (200 OK) :**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 3,
    "pseudo": "Papa",
    "roles": ["ROLE_USER", "ROLE_ADMIN"]
  }
}
```

---

#### Utilisation du token

Pour toutes les routes protégées, ajouter le header :

```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

**Durée de validité :** 1 heure

---

## 🌐 Endpoints API

### 🔓 Routes publiques

#### GET /api/themes

Liste tous les thèmes disponibles.

**Réponse (200 OK) :**
```json
[
  {
    "id": 1,
    "name": "colorful_village",
    "backgroundImage": "village_colore.jpg",
    "primaryColor": "#FF6B6B",
    "secondaryColor": "#4ECDC4",
    "musicUrl": "jingle_bells.mp3",
    "videoUrl": null,
    "description": "Village coloré et joyeux pour les enfants"
  }
  // ... 3 autres thèmes
]
```

---

#### GET /api/doors

Liste toutes les portes du calendrier.

**Réponse (200 OK) :**
```json
[
  {
    "id": 1,
    "dayNumber": 1,
    "title": "1er décembre",
    "message": "le compte à rebours de Noel commence !",
    "availableDate": "2026-12-01T00:00:00+00:00",
    "imageUrl": null,
    "videoUrl": null,
    "musicUrl": null
  }
  // ... 23 autres portes
]
```

---

### 🔒 Routes authentifiées

#### GET /api/me

Récupère le profil de l'utilisateur connecté.

**Headers :**
```
Authorization: Bearer TOKEN
```

**Réponse (200 OK) :**
```json
{
  "id": 3,
  "pseudo": "Papa",
  "age": 45,
  "avatar": "avatar_papa.png",
  "roles": ["ROLE_USER", "ROLE_ADMIN"]
}
```

---

#### GET /api/me/famille

Récupère le profil famille avec le thème associé.

**Headers :**
```
Authorization: Bearer TOKEN
```

**Réponse (200 OK) :**
```json
{
  "id": 3,
  "avatar": "avatar_papa.png",
  "familyRole": "parent",
  "hasCalendarAccess": true,
  "theme": {
    "id": 19,
    "name": "cozy",
    "backgroundImage": "cheminee.jpg",
    "primaryColor": "#8B4513",
    "secondaryColor": "#FFA500",
    "musicUrl": "home_alone.mp3",
    "videoUrl": "fireplace.mp4",
    "description": "Atmosphère chaleureuse et cosy pour les parents"
  }
}
```

---

#### POST /api/doors/{id}/open

Ouvre une porte du calendrier.

**Headers :**
```
Authorization: Bearer TOKEN
```

**Réponse (201 Created) :**
```json
{
  "success": true,
  "door": {
    "id": 1,
    "dayNumber": 1,
    "title": "1er décembre",
    "message": "le compte à revours de Noel commence !",
    "imageUrl": null,
    "videoUrl": null,
    "musicUrl": null
  },
  "openedAt": "2026-12-01T10:30:00+00:00"
}
```

**Règles métier :**
- ✅ Une porte ne peut être ouverte qu'à partir de sa date de disponibilité
- ✅ Un utilisateur ne peut ouvrir une porte qu'une seule fois
- ✅ Les vérifications sont gérées par un Voter Symfony

**Erreurs :**
- `400` : Porte déjà ouverte par cet utilisateur
- `403` : Porte pas encore disponible (date future)
- `404` : Porte inexistante

---

#### POST /api/door-openings/{id}/photo 📸

Upload une photo pour un défi réalisé.

**Headers :**
```
Authorization: Bearer TOKEN
Content-Type: multipart/form-data
```

**Body (form-data) :**
- `photo` (file) : Image JPG/PNG/WEBP (max 5MB)
- `caption` (text, optionnel) : Légende de la photo

**Réponse (201 Created) :**
```json
{
  "success": true,
  "photo": {
    "id": 1,
    "url": "/uploads/galerie/6956e77c441ee.png",
    "caption": "Mon beau sapin de Noël !"
  }
}
```

**Règles métier :**
- ✅ Seul le propriétaire du DoorOpening peut uploader
- ✅ Formats autorisés : JPG, PNG, WEBP
- ✅ Fichier stocké dans `/public/uploads/galerie/`
- ✅ Nom de fichier unique (uniqid)

**Erreurs :**
- `400` : Aucun fichier reçu ou format non autorisé
- `403` : Non autorisé (pas le propriétaire)
- `404` : DoorOpening inexistant
- `500` : Erreur upload

---

#### GET /api/photos 🖼️

Récupère la galerie familiale (toutes les photos de la famille).

**Headers :**
```
Authorization: Bearer TOKEN
```

**Réponse (200 OK) :**
```json
{
  "photos": [
    {
      "id": 1,
      "url": "/uploads/galerie/6956e77c441ee.png",
      "caption": "Mon beau sapin de Noël !",
      "uploadedAt": "2026-12-01T15:30:00+00:00",
      "doorNumber": 1,
      "uploadedBy": {
        "id": 3,
        "pseudo": "Papa",
        "avatar": "avatar_papa.png"
      }
    }
    // ... autres photos de la famille
  ]
}
```

**Règles métier :**
- ✅ Filtre automatique par FamilyGroup (sécurité)
- ✅ Photos triées par date (plus récentes en premier)
- ✅ Inclut infos uploader + porte associée

---

## 📊 Modèles de données

### FamilyGroup

```php
{
  "id": int,
  "code": string,              // "NOEL2026" (unique)
  "name": string,              // "Famille Noël 2026"
  "users": Collection<User>
}
```

**Contrainte :** Le code famille est unique et partagé par tous les membres.

---

### User

```php
{
  "id": int,
  "pseudo": string,         // "Papa"
  "age": int,              // 45
  "avatar": string,        // "avatar_papa.png"
  "roles": array,          // ["ROLE_USER", "ROLE_ADMIN"]
  "familyGroup": FamilyGroup
}
```

**Note :** Pas de email/password individuel. L'authentification se fait par code famille.

---

### Famille

```php
{
  "id": int,
  "avatar": string,
  "familyRole": string,        // "parent", "enfant", "ado", "grand_parent"
  "hasCalendarAccess": bool,
  "owner": User,
  "theme": Theme
}
```

---

### Theme

```php
{
  "id": int,
  "name": string,              // "cozy", "colorful_village", etc.
  "backgroundImage": string,   // "cheminee.jpg"
  "primaryColor": string,      // "#8B4513"
  "secondaryColor": string,    // "#FFA500"
  "musicUrl": string|null,     // "home_alone.mp3"
  "videoUrl": string|null,     // "fireplace.mp4"
  "description": string
}
```

**4 thèmes disponibles :**
1. `colorful_village` - Enfants (4-10 ans)
2. `modern_snow` - Ados (11-17 ans)
3. `cozy` - Parents (18-60 ans)
4. `traditionnel` - Grands-parents (60+ ans)

---

### Door

```php
{
  "id": int,
  "dayNumber": int,           // 1-24
  "title": string,            // "1er décembre"
  "message": string,          // Message du jour
  "availableDate": DateTime,  // Date de disponibilité
  "imageUrl": string|null,
  "videoUrl": string|null,
  "musicUrl": string|null
}
```

---

### DoorOpening

```php
{
  "id": int,
  "owner": User,
  "door": Door,
  "openedAt": DateTime,
  "photos": Collection<Photo>  // Photos uploadées
}
```

**Contrainte :** Un User ne peut ouvrir une Door qu'une seule fois (unique: owner + door).

---

### Photo 📸

```php
{
  "id": int,
  "filename": string,         // "6956e77c441ee.png"
  "caption": string|null,     // Légende optionnelle
  "uploadedAt": DateTime,     // Date d'upload
  "doorOpening": DoorOpening  // Lien vers le défi
}
```

**Relations :**
- ManyToOne → DoorOpening
- Fichier physique stocké dans `/public/uploads/galerie/`

---

## 🧪 Exemples complets

### Scénario 1 : Papa ouvre une porte et upload une photo

```bash
# 1. Vérifier le code famille
curl -X POST http://localhost:8000/auth/family \
  -H "Content-Type: application/json" \
  -d '{"code": "NOEL2026"}'

# 2. Sélectionner Papa (id: 3)
curl -X POST http://localhost:8000/auth/profile \
  -H "Content-Type: application/json" \
  -d '{"familyId": 1, "userId": 3}'

# Réponse : Token JWT

# 3. Ouvrir la porte du jour
curl -X POST http://localhost:8000/api/doors/1/open \
  -H "Authorization: Bearer TOKEN"

# Réponse : DoorOpening créé (id: 10)

# 4. Uploader une photo
curl -X POST http://localhost:8000/api/door-openings/10/photo \
  -H "Authorization: Bearer TOKEN" \
  -F "photo=@/path/to/photo.jpg" \
  -F "caption=Mon premier défi réussi !"

# 5. Voir la galerie familiale
curl -X GET http://localhost:8000/api/photos \
  -H "Authorization: Bearer TOKEN"
```

---

### Scénario 2 : Toute la famille consulte la galerie

```bash
# Khyle se connecte et voit toutes les photos de la famille
curl -X POST http://localhost:8000/auth/profile \
  -H "Content-Type: application/json" \
  -d '{"familyId": 1, "userId": 1}'

curl -X GET http://localhost:8000/api/photos \
  -H "Authorization: Bearer TOKEN"

# Réponse : Toutes les photos uploadées par Papa, Maman, etc.
```

---

## 🔒 Sécurité

### JWT (JSON Web Token)

- **Algorithme :** RS256 (clés RSA publique/privée)
- **Durée :** 1 heure
- **Contenu token :**
  ```json
  {
    "iat": 1767278895,
    "exp": 1767282495,
    "roles": ["ROLE_USER", "ROLE_ADMIN"],
    "username": "Papa"
  }
  ```

---

### Voter Symfony

**DoorOpeningVoter** vérifie :
1. ✅ Porte disponible (date >= aujourd'hui)
2. ✅ Pas de doublon (user n'a pas déjà ouvert cette porte)

**Usage :**
```php
if (!$this->isGranted('DOOR_OPEN', $door)) {
    return $this->json(['error' => 'Non autorisé'], 403);
}
```

---

### Upload sécurisé

**PhotoController** vérifie :
1. ✅ Utilisateur connecté (JWT)
2. ✅ Propriétaire du DoorOpening
3. ✅ Format fichier autorisé (jpg, png, webp)
4. ✅ Taille max (géré par PHP upload_max_filesize)

**Stockage :**
- Dossier : `/public/uploads/galerie/`
- Nom unique : `uniqid() + extension`
- **Gitignored** (pas de commits de photos)

---

### Routes protégées

**Configuration** `config/packages/security.yaml` :

```yaml
access_control:
    - { path: ^/auth, roles: PUBLIC_ACCESS }
    - { path: ^/api/themes, roles: PUBLIC_ACCESS }
    - { path: ^/api/doors$, roles: PUBLIC_ACCESS, methods: [GET] }
    - { path: ^/api, roles: IS_AUTHENTICATED_FULLY }
```

---

### Rôles

- **ROLE_USER** : Tous les membres de la famille
- **ROLE_ADMIN** : Administrateur famille (Papa)

---

## 📁 Structure du projet

```
calendar_event/
├── backend/
│   ├── config/
│   │   ├── packages/
│   │   │   ├── doctrine.yaml
│   │   │   ├── lexik_jwt_authentication.yaml
│   │   │   └── security.yaml
│   │   ├── routes.yaml
│   │   └── services.yaml
│   ├── migrations/
│   ├── public/
│   │   └── uploads/
│   │       └── galerie/          # Photos (gitignored)
│   ├── src/
│   │   ├── Controller/
│   │   │   ├── AuthController.php
│   │   │   ├── DoorController.php
│   │   │   ├── PhotoController.php
│   │   │   ├── ThemesController.php
│   │   │   └── UserController.php
│   │   ├── DataFixtures/
│   │   │   └── AppFixtures.php
│   │   ├── Entity/
│   │   │   ├── Door.php
│   │   │   ├── DoorOpening.php
│   │   │   ├── Famille.php
│   │   │   ├── FamilyGroup.php
│   │   │   ├── Photo.php
│   │   │   ├── Theme.php
│   │   │   └── User.php
│   │   ├── Repository/
│   │   │   └── PhotoRepository.php
│   │   └── Security/
│   │       └── Voter/
│   │           └── DoorOpeningVoter.php
│   └── composer.json
└── frontend/                      # À développer
    ├── src/
    │   ├── components/
    │   ├── pages/
    │   ├── services/
    │   └── styles/
    ├── public/
    └── package.json
```

---

## 🧪 Tests

### Fixtures de test

**Code famille :** `NOEL2026`

**6 profils :**
1. Khyle (4 ans, enfant, theme: colorful_village)
2. Khelyann (16 ans, ado, theme: modern_snow)
3. Papa (45 ans, parent, ADMIN, theme: cozy)
4. Maman (42 ans, parent, theme: cozy)
5. Mamie (74 ans, grand_parent, theme: traditionnel)
6. Papy (76 ans, grand_parent, theme: traditionnel)

**Tester avec Postman :**
1. Authentification (code + profil)
2. Ouvrir porte
3. Upload photo
4. Consulter galerie
5. Vérifier erreurs (403, 404, 400)

---

## 🚀 Roadmap Frontend

### Phase 1 - Setup (À venir)
- [ ] Créer projet React
- [ ] Configurer Axios
- [ ] Setup React Router
- [ ] Intégrer Tailwind CSS

### Phase 2 - Authentification
- [ ] Page de connexion (code famille)
- [ ] Sélection de profil Netflix-style
- [ ] Gestion token JWT
- [ ] Protected routes

### Phase 3 - Calendrier
- [ ] Affichage des 24 portes
- [ ] Génération positions aléatoires (Math.random)
- [ ] Animation ouverture porte
- [ ] Thèmes dynamiques par profil

### Phase 4 - Photos
- [ ] Upload photo
- [ ] Galerie masonry layout
- [ ] Lightbox
- [ ] Filtres par membre

### Phase 5 - Finitions
- [ ] Musique de Noël
- [ ] Vidéo de fond
- [ ] Responsive design
- [ ] Tests

---

## 🚀 Déploiement

### Production Backend

```bash
# 1. Variables d'environnement
APP_ENV=prod
DATABASE_URL=postgresql://...
JWT_PASSPHRASE=votre_passphrase_sécurisée

# 2. Build
composer install --no-dev --optimize-autoloader
php bin/console cache:clear
php bin/console doctrine:migrations:migrate --no-interaction

# 3. Permissions dossier uploads
chmod -R 775 public/uploads/
chown -R www-data:www-data public/uploads/

# 4. (Optionnel) Fixtures production
php bin/console doctrine:fixtures:load --no-interaction
```

### Production Frontend (à venir)

```bash
npm run build
# Déploiement sur Netlify/Vercel
```

---

## 📝 Changelog

### Version 2.1.0 (3 janvier 2026)
- ✅ **Maquettes desktop terminées** (Figma)
- ✅ **Maquettes mobile terminées** (Figma)
- 🎨 Login Netflix-style avec vidéo de fond
- 🎨 Calendrier avec portes aléatoires
- 🎨 Galerie masonry layout
- 🎨 4 thèmes personnalisés complets

### Version 2.0 (1er janvier 2026)
- ✨ Upload photos défis (POST /api/door-openings/{id}/photo)
- ✨ Galerie familiale (GET /api/photos)
- ✨ Entité Photo + migration BDD
- ✨ Stockage sécurisé `/public/uploads/galerie/`
- ✨ Filtrage par FamilyGroup
- 🔒 Validation format + propriétaire

### Version 1.0 (Décembre 2025)
- ✨ Architecture multi-tenant par famille
- ✨ Authentification par code famille partagé
- ✨ API REST complète (9 endpoints)
- ✨ JWT authentification
- ✨ 7 entités (User, Door, DoorOpening, Famille, Theme, FamilyGroup, Photo)
- ✨ Voter pour règles métier
- ✨ 24 portes + 4 thèmes

---

## 👤 Auteur

**Emmanuel Chabrier**  
Étudiant Développeur Web & Mobile - AFPA Saint-Jean-de-Védas  
Projet ECF - Décembre 2025 → Avril 2026

**GitHub :** https://github.com/chabriermanu

---

## 📄 Licence

Projet éducatif AFPA - Tous droits réservés

---

## 🔗 Liens utiles

**Backend :**
- Symfony : https://symfony.com/doc/current/index.html
- API Platform : https://api-platform.com/docs/
- JWT Bundle : https://github.com/lexik/LexikJWTAuthenticationBundle
- Doctrine : https://www.doctrine-project.org/
- Upload Files Symfony : https://symfony.com/doc/current/controller/upload_file.html

**Frontend (à venir) :**
- React : https://react.dev/
- Axios : https://axios-http.com/
- React Router : https://reactrouter.com/
- Tailwind CSS : https://tailwindcss.com/

**Design :**
- Figma : *(lien vers maquettes à ajouter)*

---

**Dernière mise à jour : 3 janvier 2026**  
**9 endpoints API | 7 entités | Backend 100% ✅ | Maquettes 100% ✅ | Frontend 0% ⏳**
