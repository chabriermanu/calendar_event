# 🎄 Calendrier de l'Avent 2026 - Backend API

API REST Symfony pour le projet Calendrier de l'Avent familial interactif.

---

## 📋 Table des matières

- [Présentation](#présentation)
- [Architecture](#architecture)
- [Installation](#installation)
- [Authentification](#authentification)
- [Endpoints API](#endpoints-api)
- [Modèles de données](#modèles-de-données)
- [Exemples](#exemples)
- [Sécurité](#sécurité)

---

## 🎯 Présentation

Backend API RESTful pour un calendrier de l'Avent familial où chaque membre de la famille peut :
- Se connecter avec un code famille partagé
- Choisir son profil personnalisé
- Ouvrir les portes du calendrier (1 par jour du 1er au 24 décembre)
- Bénéficier d'un thème visuel adapté à son âge

**Technologies :**
- Symfony 7.4
- PostgreSQL
- JWT (Lexik Bundle)
- API Platform
- Doctrine ORM

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
```

### Entités principales

1. **FamilyGroup** : Représente une famille (1 code partagé)
2. **User** : Membre de la famille (authentification par sélection de profil)
3. **Famille** : Profil utilisateur avec thème visuel
4. **Theme** : Thème graphique (4 types : enfant, ado, parent, grand-parent)
5. **Door** : Porte du calendrier (24 portes du 1er au 24 décembre)
6. **DoorOpening** : Enregistrement d'ouverture de porte par user

---

## 💻 Installation

### Prérequis

- PHP 8.2+
- Composer
- PostgreSQL 14+
- Symfony CLI

### Installation

```bash
# 1. Clone le projet
git clone <repo>
cd backend

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
    },
    {
      "id": 2,
      "pseudo": "Khelyann",
      "avatar": "avatar_teen1.png",
      "age": 16
    }
    // ... 4 autres profils
  ]
}
```

**Erreurs :**
- `400` : Code manquant
- `404` : Code famille invalide

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

**Erreurs :**
- `400` : Paramètres manquants
- `403` : User n'appartient pas à cette famille
- `404` : User non trouvé

---

#### Utilisation du token

**Pour toutes les routes protégées, ajouter le header :**

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
    "message": "le compte à revours de Noel commence !",
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

## 📊 Modèles de données

### FamilyGroup

```php
{
  "id": int,
  "name": string,           // "Famille Noël 2026"
  "code": string,           // "NOEL2026" (unique)
  "adminEmail": string      // Email de l'administrateur
}
```

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
  "openedAt": DateTime
}
```

**Contrainte :** Un User ne peut ouvrir une Door qu'une seule fois (unique: owner + door).

---

## 🧪 Exemples complets

### Scénario 1 : Papa se connecte et ouvre la porte du jour

```bash
# 1. Vérifier le code famille
curl -X POST http://localhost:8000/auth/family \
  -H "Content-Type: application/json" \
  -d '{"code": "NOEL2026"}'

# Réponse : Liste des 6 profils

# 2. Sélectionner Papa (id: 3)
curl -X POST http://localhost:8000/auth/profile \
  -H "Content-Type: application/json" \
  -d '{"familyId": 1, "userId": 3}'

# Réponse : Token JWT

# 3. Récupérer son profil
curl -X GET http://localhost:8000/api/me \
  -H "Authorization: Bearer TOKEN"

# 4. Récupérer son thème
curl -X GET http://localhost:8000/api/me/famille \
  -H "Authorization: Bearer TOKEN"

# 5. Ouvrir la porte du jour
curl -X POST http://localhost:8000/api/doors/1/open \
  -H "Authorization: Bearer TOKEN"
```

---

### Scénario 2 : Khyle (4 ans) ouvre sa porte

```bash
# 1. Code famille NOEL2026 → Liste profils
# 2. Sélectionner Khyle (id: 1, thème: colorful_village)
# 3. Ouvrir porte → Voir message adapté enfant
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
backend/
├── config/
│   ├── packages/
│   │   ├── doctrine.yaml
│   │   ├── lexik_jwt_authentication.yaml
│   │   └── security.yaml
│   └── routes.yaml
├── migrations/
├── src/
│   ├── Controller/
│   │   ├── AuthController.php      # Login code famille + profil
│   │   ├── DoorController.php      # Ouverture portes
│   │   ├── ThemesController.php    # Liste thèmes
│   │   └── UserController.php      # Profil user
│   ├── DataFixtures/
│   │   └── AppFixtures.php         # Données de test
│   ├── Entity/
│   │   ├── Door.php
│   │   ├── DoorOpening.php
│   │   ├── Famille.php
│   │   ├── FamilyGroup.php
│   │   ├── Theme.php
│   │   └── User.php
│   ├── Repository/
│   └── Security/
│       └── Voter/
│           └── DoorOpeningVoter.php
└── composer.json
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
1. Import collection (à créer)
2. Tester le flow complet
3. Vérifier les erreurs 400/403/404

---

## 🚀 Déploiement

### Production

```bash
# 1. Variables d'environnement
APP_ENV=prod
DATABASE_URL=postgresql://...
JWT_PASSPHRASE=votre_passphrase_sécurisée

# 2. Build
composer install --no-dev --optimize-autoloader
php bin/console cache:clear
php bin/console doctrine:migrations:migrate --no-interaction

# 3. (Optionnel) Fixtures production
php bin/console doctrine:fixtures:load --no-interaction
```

---

## 📝 Changelog

### Version 2.0 (1er janvier 2026)
- ✨ Nouvelle architecture multi-tenant par famille
- ✨ Authentification par code famille partagé
- ✨ Sélection de profil sans email/password
- ✨ Entity FamilyGroup ajoutée
- ♻️ User refactorisé (suppression email/password)
- 🔒 Nouveau flow d'authentification en 2 étapes

### Version 1.0 (Décembre 2025)
- ✨ API REST complète
- ✨ JWT authentification
- ✨ 5 entités (User, Door, DoorOpening, Famille, Theme)
- ✨ Voter pour règles métier
- ✨ 24 portes + 4 thèmes

---

## 👤 Auteur

**Emmanuel**  
Étudiant Développeur Web - AFPA Saint-Jean-de-Védas  
Projet ECF - Décembre 2025 → Avril 2026

---

## 📄 Licence

Projet éducatif AFPA - Tous droits réservés

---

## 🔗 Liens utiles

- **Symfony** : https://symfony.com/doc/current/index.html
- **API Platform** : https://api-platform.com/docs/
- **JWT Bundle** : https://github.com/lexik/LexikJWTAuthenticationBundle
- **Doctrine** : https://www.doctrine-project.org/

---

**Dernière mise à jour : 1er janvier 2026**