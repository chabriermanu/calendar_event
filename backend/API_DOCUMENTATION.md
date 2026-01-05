cat > API_DOCUMENTATION.md << 'EOF'
# 📚 Documentation API - Calendrier de l'Avent Familial

## 🎯 Vue d'ensemble

API REST pour un calendrier de l'avent familial permettant aux membres d'une famille de :
- Ouvrir les 24 portes du calendrier (1 par jour de décembre)
- Uploader des photos souvenirs
- Personnaliser l'expérience avec des thèmes de Noël

**Version** : 1.0  
**Base URL** : `http://127.0.0.1:8000`  
**Format** : JSON  
**Authentification** : JWT Bearer Token

---

## 🏗️ Architecture

### Pattern DTO (Data Transfer Object)

L'API utilise des DTOs pour :
- Séparer le modèle de données de l'API
- Garantir la sécurité (pas d'exposition accidentelle)
- Maintenir des contrats d'API stables

### Multi-tenant

- Authentification par **code famille** partagé (ex: `NOEL2026`)
- Sélection de profil individuel type Netflix
- **Pas de mot de passe individuel**

---

## 🔐 Authentification

### Flux d'authentification
```
1. Client envoie le code famille → POST /auth/family
2. API retourne la liste des 6 profils
3. Client sélectionne un profil → POST /auth/profile
4. API retourne un JWT token
5. Client utilise le token pour tous les appels suivants
```

### 1. Vérifier le code famille

**Endpoint :** `POST /auth/family`

**Headers :**
```
Content-Type: application/json
```

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
    {"id": 1, "pseudo": "Khyle", "avatar": "avatar_khyle.png", "age": 4},
    {"id": 2, "pseudo": "Khelyann", "avatar": "avatar_teen1.png", "age": 16},
    {"id": 3, "pseudo": "Papa", "avatar": "avatar_papa.png", "age": 45},
    {"id": 4, "pseudo": "Maman", "avatar": "avatar_maman.png", "age": 42},
    {"id": 5, "pseudo": "Mamie", "avatar": "avatar_grandparents.png", "age": 74},
    {"id": 6, "pseudo": "Papy", "avatar": "avatar_grandparents.png", "age": 76}
  ]
}
```

---

### 2. Sélectionner un profil

**Endpoint :** `POST /auth/profile`

**Headers :**
```
Content-Type: application/json
```

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
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": 3,
    "pseudo": "Papa",
    "roles": ["ROLE_USER", "ROLE_ADMIN"]
  }
}
```

**💡 Note :** Le token doit être stocké côté client et envoyé dans tous les endpoints protégés :
```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

---

## 👤 User Endpoints

### GET /api/me

Récupère les informations de l'utilisateur connecté.

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200 OK) - DTO UserMeResponse :**
```json
{
  "id": 3,
  "pseudo": "Papa",
  "age": 45,
  "avatar": "avatar_papa.png",
  "roles": ["ROLE_USER", "ROLE_ADMIN"]
}
```

**Erreurs :**
- `401 Unauthorized` : Token manquant ou invalide

---

### GET /api/me/famille

Récupère le profil famille avec le thème associé.

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200 OK) - DTO FamilleProfileResponse :**
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
    "videoUrl": "fireplace.mp4"
  }
}
```

**Erreurs :**
- `401 Unauthorized` : Token manquant ou invalide
- `404 Not Found` : Profil famille non trouvé
```json
{
  "error": "Profil famille non trouvé"
}
```

---

## 🚪 Door Endpoints

### POST /api/doors/{id}/open

Ouvre une porte du calendrier.

**URL Parameters :**
- `id` (integer) : ID de la porte (1-24)

**Headers :**
```
Authorization: Bearer {token}
```

**Règles métier :**
- Une porte ne peut être ouverte qu'à partir de sa date disponible
- Une porte ne peut être ouverte qu'une seule fois par utilisateur
- Génère un `DoorOpening` en base de données

**Réponse (201 Created) :**
```json
{
  "success": true,
  "door": {
    "id": 12,
    "dayNumber": 12,
    "title": "Joyeux Noël !",
    "message": "Félicitations pour avoir ouvert la porte du 12 décembre !",
    "imageUrl": "/images/door12.jpg",
    "videoUrl": "/videos/noel.mp4",
    "musicUrl": "/music/jingle.mp3"
  },
  "openedAt": "2026-12-12T10:30:00+00:00"
}
```

**Erreurs :**

**403 Forbidden** (porte pas encore disponible) :
```json
{
  "error": "Vous ne pouvez pas ouvrir cette porte",
  "availableDate": "2026-12-12T00:00:00+00:00"
}
```

**404 Not Found** (porte inexistante) :
```json
{
  "error": "Porte non trouvée"
}
```

**401 Unauthorized** : Token manquant ou invalide

---

## 🎨 Theme Endpoints

### GET /api/themes

Liste tous les thèmes de Noël disponibles.

**⚠️ Endpoint PUBLIC (pas d'authentification requise)**

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
    "videoUrl": "snow_village.mp4",
    "description": "Un village coloré et festif"
  },
  {
    "id": 2,
    "name": "modern_snow",
    "backgroundImage": "neige_moderne.jpg",
    "primaryColor": "#3498DB",
    "secondaryColor": "#ECF0F1",
    "musicUrl": "modern_christmas.mp3",
    "videoUrl": "snow_fall.mp4",
    "description": "Design moderne avec neige"
  },
  {
    "id": 3,
    "name": "cozy",
    "backgroundImage": "cheminee.jpg",
    "primaryColor": "#8B4513",
    "secondaryColor": "#FFA500",
    "musicUrl": "home_alone.mp3",
    "videoUrl": "fireplace.mp4",
    "description": "Ambiance chaleureuse au coin du feu"
  },
  {
    "id": 4,
    "name": "traditionnel",
    "backgroundImage": "sapin_traditionnel.jpg",
    "primaryColor": "#2ECC71",
    "secondaryColor": "#E74C3C",
    "musicUrl": "cantique_noel.mp3",
    "videoUrl": "sapin.mp4",
    "description": "Noël traditionnel avec sapin"
  }
]
```

---

## 📸 Photo Endpoints

### POST /api/door-openings/{id}/photo

Upload une photo pour une porte ouverte.

**URL Parameters :**
- `id` (integer) : ID du DoorOpening

**Headers :**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Form Data :**

| Clé | Type | Requis | Description |
|-----|------|--------|-------------|
| `photo` | File | ✅ Oui | Image (JPEG, PNG, WEBP, max 5MB) |
| `caption` | Text | ❌ Non | Légende (max 255 caractères) |

**⚠️ Important :** Dans Postman, utiliser `form-data` (PAS `raw` JSON)

**Validation :**
- Formats acceptés : `image/jpeg`, `image/png`, `image/webp`
- Taille maximale : `5MB`
- L'utilisateur doit être propriétaire du DoorOpening

**Réponse (201 Created) - DTO PhotoResponseDTO :**
```json
{
  "id": 2,
  "url": "/uploads/galerie/6956bcc66e9868.png",
  "caption": "Ma belle photo de Noël"
}
```

**Erreurs :**

**400 Bad Request** (validation échouée) :
```json
{
  "errors": "Object(App\\DTO\\PhotoUploadRequestDTO).photo:\n    This value should not be null."
}
```

**403 Forbidden** (pas le propriétaire) :
```json
{
  "error": "Non autorisé"
}
```

**404 Not Found** (DoorOpening inexistant) :
```json
{
  "error": "DoorOpening non trouvé"
}
```

---

### GET /api/door-openings/{id}/photos

Liste toutes les photos d'un DoorOpening spécifique.

**URL Parameters :**
- `id` (integer) : ID du DoorOpening

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200 OK) :**
```json
[
  {
    "id": 1,
    "url": "/uploads/galerie/abc123.jpg",
    "caption": "Notre première photo",
    "uploadedAt": "2026-12-12 10:30:00"
  },
  {
    "id": 2,
    "url": "/uploads/galerie/def456.png",
    "caption": "Joyeux Noël !",
    "uploadedAt": "2026-12-12 14:20:00"
  }
]
```

**Erreurs :**
- `401 Unauthorized` : Token manquant ou invalide
- `403 Forbidden` : Pas le propriétaire du DoorOpening
- `404 Not Found` : DoorOpening inexistant

---

### GET /api/photos/{id}

Récupère une photo spécifique.

**URL Parameters :**
- `id` (integer) : ID de la photo

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200 OK) :**
```json
{
  "id": 1,
  "url": "/uploads/galerie/abc123.jpg",
  "caption": "Notre première photo",
  "uploadedAt": "2026-12-12 10:30:00"
}
```

**Erreurs :**

**403 Forbidden** (pas le propriétaire) :
```json
{
  "error": "Non autorisé"
}
```

**404 Not Found** (photo inexistante) :
```json
{
  "error": "Photo non trouvée"
}
```

---

### DELETE /api/photos/{id}

Supprime une photo (fichier physique + enregistrement base de données).

**URL Parameters :**
- `id` (integer) : ID de la photo

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (204 No Content) :**
```
(pas de body)
```

**Erreurs :**

**403 Forbidden** (pas le propriétaire) :
```json
{
  "error": "Non autorisé"
}
```

**404 Not Found** (photo inexistante) :
```json
{
  "error": "Photo non trouvée"
}
```

---

## 📊 Codes de réponse HTTP

| Code | Signification | Utilisation |
|------|---------------|-------------|
| `200` | OK | Requête GET réussie |
| `201` | Created | Ressource créée avec succès (POST) |
| `204` | No Content | Suppression réussie (DELETE) |
| `400` | Bad Request | Validation échouée, données invalides |
| `401` | Unauthorized | Token JWT manquant ou invalide |
| `403` | Forbidden | Accès refusé (ownership, date non disponible) |
| `404` | Not Found | Ressource inexistante |
| `500` | Internal Server Error | Erreur serveur |

---

## 🗂️ Modèles de données

### User
```typescript
{
  id: number;
  pseudo: string;
  age: number;
  avatar: string;
  roles: string[];
  familyGroup: FamilyGroup;
  famille?: Famille;
}
```

### Famille (Profil)
```typescript
{
  id: number;
  owner: User;
  theme: Theme;
  avatar: string;
  familyRole: string; // 'enfant' | 'ado' | 'parent' | 'grand-parent'
  hasCalendarAccess: boolean;
}
```

### FamilyGroup
```typescript
{
  id: number;
  code: string; // ex: "NOEL2026"
  name: string;
  users: User[];
}
```

### Theme
```typescript
{
  id: number;
  name: string;
  backgroundImage: string;
  primaryColor: string;
  secondaryColor: string;
  musicUrl?: string;
  videoUrl?: string;
  description?: string;
}
```

### Door
```typescript
{
  id: number;
  dayNumber: number; // 1-24
  title: string;
  message: string;
  imageUrl?: string;
  videoUrl?: string;
  musicUrl?: string;
  availableDate: DateTime; // Format ISO 8601
}
```

### DoorOpening
```typescript
{
  id: number;
  owner: User;
  door: Door;
  openedAt: DateTime;
  photos: Photo[];
}
```

### Photo
```typescript
{
  id: number;
  doorOpening: DoorOpening;
  filename: string;
  caption?: string;
  uploadedAt: DateTime;
}
```

---

## 🧪 Tests avec Postman

### Variables d'environnement

Créer un environnement `Dev Local` avec :

| Variable | Valeur initiale |
|----------|-----------------|
| `base_url` | `http://127.0.0.1:8000` |
| `jwt_token` | *(vide, auto-rempli après auth)* |

### Workflow de test complet

1. **POST** `/auth/family` → Vérifier le code famille
2. **POST** `/auth/profile` → Obtenir le JWT (auto-sauvegardé dans `{{jwt_token}}`)
3. **GET** `/api/me` → Tester UserMeResponse DTO
4. **GET** `/api/me/famille` → Tester FamilleProfileResponse + ThemeResponse DTO
5. **GET** `/api/themes` → Liste des 4 thèmes
6. **POST** `/api/doors/12/open` → Ouvrir la porte du 12 décembre
7. **POST** `/api/door-openings/1/photo` → Upload photo (⚠️ form-data !)
8. **GET** `/api/door-openings/1/photos` → Liste des photos
9. **GET** `/api/photos/1` → Récupérer une photo
10. **DELETE** `/api/photos/1` → Supprimer une photo

### Script Postman pour auto-sauvegarder le token

Onglet **Tests** de la requête `POST /auth/profile` :
```javascript
if (pm.response.code === 200) {
    var jsonData = pm.response.json();
    pm.environment.set('jwt_token', jsonData.token);
    console.log('✅ Token JWT sauvegardé');
}
```

---

## 🔒 Sécurité

### Authentification
- JWT avec signature HMAC-SHA256
- Expiration configurable (défaut : 1 heure)
- Pas de refresh token (à implémenter si nécessaire)

### Autorisation
- Annotation `#[IsGranted('IS_AUTHENTICATED_FULLY')]` sur tous les endpoints protégés
- Vérification d'ownership sur les ressources (photos, doorOpenings)
- Voter Symfony pour les règles métier complexes (ex: ouverture de porte)

### Validation
- DTOs avec contraintes Symfony Validator :
  - `#[Assert\NotNull]`
  - `#[Assert\File(maxSize: '5M')]`
  - `#[Assert\Length(max: 255)]`

### Upload sécurisé
- Validation du type MIME (pas uniquement l'extension)
- Taille maximale : 5MB
- Stockage avec noms aléatoires (pas le nom original)

### CORS

Configuration recommandée pour le frontend React :
```yaml
# config/packages/nelmio_cors.yaml
nelmio_cors:
    defaults:
        origin_regex: true
        allow_origin: ['http://localhost:5173']
        allow_methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS']
        allow_headers: ['Content-Type', 'Authorization']
        expose_headers: ['Content-Type', 'Authorization']
        max_age: 3600
```

---

## 🚀 Déploiement

### Variables d'environnement (.env.prod)
```bash
APP_ENV=prod
APP_SECRET=your-secret-key-min-32-chars
DATABASE_URL=postgresql://user:pass@host:5432/advent_calendar
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your-passphrase
```

### Commandes de déploiement
```bash
# Installation des dépendances (production)
composer install --no-dev --optimize-autoloader

# Migrations de base de données
php bin/console doctrine:migrations:migrate --no-interaction

# Chargement des fixtures (si nécessaire)
php bin/console doctrine:fixtures:load --no-interaction

# Cache
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

# Permissions
chmod -R 755 public/uploads
chown -R www-data:www-data public/uploads
```

### Génération des clés JWT
```bash
mkdir -p config/jwt
openssl genpkey -algorithm RSA -out config/jwt/private.pem -pkeyopt rsa_keygen_bits:4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

---

## 📝 Changelog

### v1.0.0 (2026-01-05)

**Fonctionnalités :**
- ✅ Authentification multi-tenant par code famille (sans mot de passe individuel)
- ✅ Sélection de profil type Netflix
- ✅ CRUD Utilisateurs avec DTOs (UserMeResponse, FamilleProfileResponse)
- ✅ CRUD Photos avec upload sécurisé (PhotoUploadRequestDTO, PhotoResponseDTO)
- ✅ Gestion des 24 portes du calendrier avec Voter
- ✅ 4 thèmes de Noël personnalisables
- ✅ Architecture DTO + Mapper pour séparation API/Entity

**Technique :**
- Symfony 7.4
- PostgreSQL 16
- JWT Authentication (LexikJWTAuthenticationBundle)
- Pattern DTO pour toutes les réponses critiques
- Validation avec Symfony Validator

---

## 🛠️ Technologies

| Composant | Technologie | Version |
|-----------|-------------|---------|
| Framework | Symfony | 7.4 |
| Base de données | PostgreSQL | 16.11 |
| Authentification | JWT | LexikJWTAuthenticationBundle |
| ORM | Doctrine | 2.x |
| Validation | Symfony Validator | 7.4 |
| Upload | Symfony HttpFoundation | 7.4 |

---

## 📚 Ressources

### Documentation Symfony
- [JWT Authentication Bundle](https://github.com/lexik/LexikJWTAuthenticationBundle)
- [Validation](https://symfony.com/doc/current/validation.html)
- [Security](https://symfony.com/doc/current/security.html)
- [File Upload](https://symfony.com/doc/current/controller/upload_file.html)

### Structure des DTOs
```
src/
├── DTO/
│   ├── Request/
│   │   └── PhotoUploadRequestDTO.php
│   └── Response/
│       ├── UserMeResponse.php
│       ├── FamilleProfileResponse.php
│       ├── ThemeResponse.php
│       └── PhotoResponseDTO.php
├── Mapper/
│   └── UserMapper.php
└── Controller/
    ├── AuthController.php
    ├── UserController.php
    ├── DoorController.php
    ├── PhotoController.php
    └── ThemesController.php
```

---

## 👨‍💻 Informations projet

**Développeur :** Emmanuel Chabrier  
**Formation :** AFPA Saint-Jean-de-Védas - Web et Mobile Developer  
**Projet :** ECF Calendrier de l'Avent Familial  
**Date :** Janvier 2026  
**Stack Technique :**
- Backend : Symfony 7.4 + PostgreSQL
- Frontend : React + TypeScript (à venir)
- Architecture : API REST + Pattern DTO

---

## 📞 Support & Contact

Pour toute question sur l'API ou le projet :
- GitHub : [https://github.com/chabriermanu/calendar_event]
- Email : [chabrier.manu@gmail.com]

---

**🎄 Joyeux Noël et bon développement ! 🎅**

---

*Document généré le 05/01/2026*  
*Version 1.0.0*
