# 🎄 MoSCoW - Calendrier de l'Avent Familial
## État d'avancement FINAL au 1er janvier 2026 - 23h00

**Légende :**
- ✅ = Terminé (vert)
- 🟡 = Commencé mais pas fini (orange)  
- ❌ = Pas commencé (non coché)

---

## 🔴 MUST HAVE (Obligatoire pour certification)

### 1. Maquettes & Design
- ✅ **Wireframes 3 écrans** → TU EN AS 15 ! (6 desktop + 9 mobile)
  - ✅ Écran 0 : Accueil (desktop + mobile)
  - ✅ Écran 1 : Authentification code famille (desktop + mobile)
  - ✅ Écran 1a : Création famille/inscription (mobile)
  - ✅ Écran 2 : Sélection profils Netflix-style (desktop + mobile)
  - ✅ Écran 3 : Calendrier 24 portes (desktop + mobile)
  - ✅ Écran 4 : Contenu porte/Défis (desktop + mobile)
  - ✅ Écran 5 : Ajouter membre (mobile)
  - ✅ Écran 6 : Profil utilisateur (desktop + mobile)
  - ✅ Écran 7 : Galerie familiale (mobile)
- 🟡 **Charte graphique** (palette visible dans maquettes mais pas formalisée dans un doc)
  - Couleurs : Bleu/vert dégradé, neige, rouge Noël
  - Typographie : Police moderne lisible
  - Pas de logo officiel
- ✅ **Responsive design** (desktop 1920px + mobile 375x812px)

### 2. Page Sélection profils (Netflix-style)
- ✅ **Maquette complète** (écran 2)
  - 6 cartes avatar (Mamie, Papy, Maman, Papa, Khélyann, Khyle)
  - Background neige animé
  - Grille 2x3 responsive
  - Bouton son 🔊
  - Icône galerie 🖼️
  - Bouton déconnexion
- ❌ **Code frontend** (React pas commencé)

### 3. Page Login (après sélection) 
- ✅ **Maquette complète** (écran 1)
  - Formulaire code famille (ex: NOEL2026)
  - Background neige identique accueil
  - Bouton retour
  - Message "Entrez le code Famille"
- ✅ **Architecture backend cohérente**
  - POST /auth/family (vérification code)
  - POST /auth/profile (sélection profil)
  - Maquettes alignées avec backend ✅
- ❌ **Code frontend**

### 4. Page Calendrier (24 portes)
- ✅ **Maquette complète** (écran 3)
  - Grille 24 cases (numéros 1-24)
  - Background thème personnalisé (ex: cheminée cosy pour Mamie)
  - Message personnalisé "Bonjour Mamie, bienvenue sur ton calendrier"
  - 4 états visuels :
    - 🔒 Fermée (cadenas)
    - ⭐ Jour J (étoile)
    - ✅ Ouverte (check vert)
    - 🚪 Porte sortie
  - Légende complète
  - Barre navigation : Retour, Galerie, Son, Profil
- ❌ **Code frontend**

### 5. Page Contenu porte
- ✅ **Maquette complète** (écran 4)
  - Lutin Noël personnage
  - Titre défi (ex: "Jour 3 : un sapin de Noël tu créeras")
  - Message personnalisé ("Coucou mamie!")
  - Explication défi avec emoji
  - Icône vidéo tuto 📹
  - Bouton appareil photo 📷 (upload)
  - Boutons : Son, Retour calendrier
  - Background thème personnalisé
- 🟡 **Animations listées** (zoom, rotation, fade, slide) mais pas codées
- ❌ **Code frontend**

### 6. Backend
- ✅ **API REST complète** (9 endpoints)
  - ✅ POST /auth/family → Vérification code famille
  - ✅ POST /auth/profile → Sélection profil + JWT
  - ✅ GET /api/doors → Liste 24 portes
  - ✅ GET /api/me → Profil user
  - ✅ GET /api/me/famille → Profil famille + thème
  - ✅ GET /api/themes → Liste 4 thèmes
  - ✅ POST /api/doors/{id}/open → Ouvrir porte
  - ✅ POST /api/door-openings/{id}/photo → Upload photo défi 📸
  - ✅ GET /api/photos → Galerie familiale 📸
- ✅ **JWT authentification** (clés RSA, token sécurisé 1h)
- ✅ **7 entités + relations** (FamilyGroup, User, Famille, Door, DoorOpening, Theme, Photo)
- ✅ **Validations + sécurité** (Voter Symfony + upload sécurisé)
  - Règle date : pas d'ouverture avant availableDate
  - Règle doublon : 1 user = 1 ouverture/porte
  - Voter DoorOpeningVoter centralisé
  - Validation format photos (jpg, png, webp)
  - Vérification propriétaire pour upload
- ✅ **PostgreSQL + Migrations Doctrine**
  - 7 tables créées
  - Relations FK correctes
  - Contraintes UNIQUE
  - CASCADE on delete
- ✅ **Fixtures** (1 famille, 6 users, 4 themes, 24 portes)
- ✅ **Système upload photos** 📸
  - Entité Photo (filename, caption, uploadedAt, doorOpening)
  - Stockage `/public/uploads/galerie/`
  - Nom unique (uniqid)
  - Gitignore uploads
- ✅ **Documentation API** (README V2 - 21 sections)
  - Installation complète
  - Flow authentification documenté
  - 9 endpoints avec exemples cURL
  - Modèles de données (7 entités)
  - Sécurité JWT + Voter + Upload
  - Scénarios d'utilisation
  - Structure projet
- ✅ **Schéma BDD** (diagramme ERD V2)
  - Mermaid ERD (7 tables)
  - 6 relations détaillées
  - SQL complet
  - Code DBML pour dbdiagram.io
  - Requêtes SQL utiles (dont galerie)

### 7. Technique Frontend
- ❌ React 18+ avec Vite
- ❌ React Router
- ❌ Gestion état (useState, useContext)
- ❌ Appels API (fetch + JWT)
- ❌ Gestion erreurs
- ❌ localStorage pour token
- ❌ Upload photos côté client

### 8. Livrables ECF
- 🟡 **Dossier projet** (maquettes OK, cahier des charges à formaliser)
- ✅ **Dossier technique** (README backend V2 + ERD V2)
- 🟡 **Code commenté** (backend oui, frontend non)
- ✅ **README détaillé** (backend complet avec upload)
- ✅ **Captures d'écran** (15 maquettes PNG)
- ✅ **Git** (tout poussé sur GitHub - 2 commits aujourd'hui)

---

## 🟠 SHOULD HAVE (Améliore le projet)

### 1. Page Sélection profils - Améliorations
- 🟡 **Vidéo background** (mentionnée dans maquettes, pas implémentée)
- 🟡 **Musique nostalgique** (icône 🔊 présente, pas de fichier audio)
- ✅ **Bouton mute/unmute** (dans maquette écran 2)
- ❌ Animation survol avatars
- ❌ Transition douce après sélection

### 2. Backgrounds personnalisés
- ✅ **Table `theme` en BDD** (4 themes créés)
  - colorful_village (Khyle)
  - modern_snow (Khélyann)
  - cozy (Papa/Maman)
  - traditionnel (Papy/Mamie)
- ✅ **Relation Famille → Theme**
- ✅ **API GET /api/themes**
- ✅ **API GET /api/me/famille** retourne thème
- ✅ **Maquettes montrent backgrounds différents** (cheminée, village, montagne...)
- ❌ **Affichage frontend selon user**

### 3. Contenu enrichi portes
- ✅ **Structure BDD** (imageUrl, musicUrl, videoUrl dans Door)
- ✅ **Maquette montre** icône vidéo 📹 et upload photo 📷
- ✅ **Backend upload photos** 📸
  - POST /api/door-openings/{id}/photo
  - Stockage sécurisé
  - Validation format
- ❌ Affichage images frontend
- ❌ Upload frontend
- ❌ Lecteur audio (musicUrl)
- ❌ Lecteur vidéo (videoUrl)

### 4. Animations & UX
- 🟡 **Animations listées** dans écran 4 (Zoom, Rotation, Fade, Slide) mais pas codées
- ❌ Animation ouverture porte (3D/slide)
- ❌ Flocons de neige animés (CSS)
- ❌ Transitions fluides
- ❌ Effet brillant porte du jour (glow)
- ❌ Loading spinner

### 5. Page Profil
- ✅ **Maquette complète** (écran 6)
  - Voir infos (Prénom, Âge)
  - Stats réalisations (⭐ 5/24 défis, 📊 21% complété)
  - Mes photos (J-1, J-2, J-3)
  - Bouton changer paysage (dropdown 6 options)
  - Paramètres RGPD
  - Déconnexion
- ❌ **Code frontend**

### 6. Page Galerie familiale
- ✅ **Maquette complète** (écran 7)
  - Filtres (Tous / Jour)
  - Cards photos par jour
  - Attribution ("Réalisé par : Mamie, Khyle...")
  - Scroll vertical
- ✅ **Backend API** GET /api/photos 📸
  - Filtrage par famille
  - Tri par date
  - Infos complètes (uploader, porte, caption)
- ❌ **Code frontend**

### 7. Tests & Qualité
- ✅ **Tests manuels backend** (Postman - 9 endpoints validés)
- ❌ Tests unitaires (Jest)
- ❌ Tests intégration API
- ❌ Validation accessibilité (a11y)
- ❌ Optimisation performances (Lighthouse)

---

## 🟡 COULD HAVE (Bonus si temps)

### Features avancées
- 🟡 **Portes aléatoires** (concept dans doc, pas dans maquettes)
- ✅ **Vidéos** (structure BDD + icône dans maquette)
- ✅ **Upload photos** (backend 100% terminé) 📸
  - POST endpoint
  - Stockage sécurisé
  - Validation
  - Galerie API
- ✅ **Galerie familiale** (maquette + backend API)
- ❌ Dashboard admin
- ❌ Compte à rebours Noël
- ❌ Notifications

### Design avancé
- ✅ **Sélection thème par user** (dropdown dans écran 6)
- ❌ Mode nuit/jour
- ❌ Effets parallax
- ❌ Animations 3D

### Social (hors périmètre ton projet)
- ❌ Commentaires sur portes
- ❌ Like/réactions défis
- ❌ Historique années précédentes

---

## ⚪ WON'T HAVE (Hors périmètre V1)

- Application mobile native
- Partage réseaux sociaux
- Calendrier personnalisable
- Mode multijoueur
- Chat familial
- Version multilingue
- Gamification (points/badges)

---

## 📊 SCORE GLOBAL RÉEL

### Backend : 100% ✅ ⭐⭐⭐
- ✅ **Architecture cohérente** (FamilyGroup + User refactorisé)
- ✅ **API REST 9 endpoints** fonctionnels et testés
- ✅ **JWT + Sécurité** (Voter, validations, upload sécurisé)
- ✅ **PostgreSQL 7 tables** + relations + migrations
- ✅ **Fixtures complètes** (1 famille, 6 users, 4 themes, 24 portes)
- ✅ **Upload photos** (entité Photo, stockage, API complète)
- ✅ **Documentation complète** (README V2 - 21 sections)
- ✅ **Schéma ERD V2** (Mermaid + SQL + DBML - 7 tables)
- ✅ **Git** (2 commits détaillés, tout poussé)

### Maquettes/Design : 95% ✅
- ✅ 15 wireframes (6 desktop + 9 mobile) 
- ✅ Flows utilisateurs documentés
- ✅ README wireframes mobile
- ✅ Responsive (2 formats)
- 🟡 Charte graphique visible mais pas formalisée
- ❌ Maquettes haute-fidélité Figma

### Frontend : 0% ❌
- React non installé
- Aucune page codée
- Aucun composant créé

---

## 🎯 PROJET GLOBAL : 45%

**Répartition réelle :**
- Backend : 30% du projet → **100% fait = 30%** ✅
- Maquettes : 10% du projet → **95% fait = 9.5%** ✅
- Documentation : 5% du projet → **100% fait = 5%** ✅  
- Frontend : 55% du projet → **0% fait = 0%** ❌

**TOTAL : 44.5%**

---

## 🎉 ACHIEVEMENTS AUJOURD'HUI (1er janvier 2026)

### 🏗️ Refonte architecture + Upload photos (11h30 de travail)

**MATIN (9h) : Refonte architecture**

1. ✅ **Entité FamilyGroup créée**
   - Code famille partagé (NOEL2026)
   - Relation 1:N vers User
   - Migration exécutée

2. ✅ **User refactorisé**
   - Suppression email/password individuels
   - Ajout age, avatar, pseudo
   - Relation vers FamilyGroup

3. ✅ **Nouveau système d'authentification**
   - AuthController créé
   - POST /auth/family (vérification code)
   - POST /auth/profile (sélection profil + JWT)
   - Flow en 2 étapes testé et validé

4. ✅ **Fixtures adaptées**
   - 1 FamilyGroup
   - 6 Users sans password
   - 6 Familles avec thèmes
   - 4 Themes
   - 24 Doors

5. ✅ **Tests Postman réussis**
   - POST /auth/family → 200 OK (6 profils)
   - POST /auth/profile → 200 OK (JWT)
   - GET /api/me → 200 OK
   - GET /api/me/famille → 200 OK (thème cozy)
   - POST /api/doors/1/open → 201 Created

6. ✅ **Documentation professionnelle**
   - README backend 21 sections
   - Schéma ERD complet
   - SQL + Mermaid + DBML
   - Exemples cURL
   - Scénarios d'utilisation

**SOIR (2h30) : Upload photos + Galerie**

7. ✅ **Entité Photo créée** 📸
   - Propriétés : filename, caption, uploadedAt
   - Relation ManyToOne → DoorOpening
   - Migration BDD exécutée

8. ✅ **PhotoController créé**
   - POST /api/door-openings/{id}/photo
   - GET /api/photos (galerie familiale)
   - Validation format (jpg, png, webp)
   - Vérification propriétaire
   - Stockage `/public/uploads/galerie/`

9. ✅ **Tests upload réussis**
   - Upload photo → 201 Created ✅
   - Galerie → 200 OK ✅
   - Photo en BDD ✅
   - Fichier sur disque ✅

10. ✅ **Documentation mise à jour**
    - README Backend V2 (9 endpoints)
    - ERD V2 (7 tables + relation Photo)
    - Exemples upload complets

11. ✅ **Git mis à jour**
    - Commit upload photos
    - Push sur GitHub
    - .gitignore uploads

---

## 🚀 PROCHAINES PRIORITÉS (dans l'ordre)

### Phase 1 : Setup React (2 jours - 2-3 janvier)

1. **Installation Vite + React 18**
   - Création projet
   - Configuration routes
   - Structure dossiers

2. **Configuration API**
   - Axios ou fetch
   - Base URL
   - Intercepteurs JWT

---

### Phase 2 : Pages principales (12 jours - 4-15 janvier)

3. **Login Flow** (3 jours)
   - Page code famille (POST /auth/family)
   - Page sélection profils (6 cartes)
   - Page login profil (POST /auth/profile)
   - Stockage token localStorage

4. **Calendrier** (5 jours)
   - Grille 24 portes
   - 3 états visuels (fermée, jour J, ouverte)
   - GET /api/doors
   - Thème personnalisé (background)
   - Message bienvenue

5. **Contenu porte** (2 jours)
   - Modal/Page défi
   - POST /api/doors/{id}/open
   - Affichage message
   - Bouton retour

6. **Upload photo** (1 jour) 📸
   - Formulaire upload
   - POST /api/door-openings/{id}/photo
   - Prévisualisation
   - Caption optionnelle

7. **Navigation** (1 jour)
   - React Router setup
   - Navbar
   - Routes protégées
   - Redirection si non auth

---

### Phase 3 : Galerie + Responsive (5 jours - 16-20 janvier)

8. **Galerie familiale** (2 jours) 📸
   - GET /api/photos
   - Grille photos
   - Filtres par jour
   - Attribution (qui a uploadé)

9. **Responsive design** (2 jours)
   - Mobile-first CSS
   - Breakpoints
   - Tests multi-devices

10. **Tests & Debug** (1 jour)
    - Flow complet
    - Gestion erreurs
    - Loading states

---

### Phase 4 : SHOULD HAVE (optionnel - 21-30 janvier)

11. **Profil utilisateur**
    - Page profil
    - Stats réalisations
    - Mes photos

12. **Animations**
    - Ouverture porte
    - Transitions
    - Flocons neige

---

**= 20 jours de dev frontend**  
**Tu as ~45 jours avant stage = TRÈS LARGEMENT FAISABLE ! 💪**

---

## 📋 CHECKLIST AVANT STAGE (mi-février)

### Backend ✅
- [x] API REST complète (9 endpoints)
- [x] JWT sécurisé
- [x] Base de données (7 tables)
- [x] Upload photos
- [x] Documentation
- [x] Tests manuels
- [ ] Tests automatisés (optionnel)

### Frontend ❌
- [ ] React installé
- [ ] Pages login/calendrier/porte
- [ ] Upload photos frontend
- [ ] Galerie familiale
- [ ] Appels API fonctionnels
- [ ] Responsive
- [ ] Tests basiques

### Livrables ECF 🟡
- [x] Maquettes (15 écrans)
- [x] Backend documenté
- [ ] Frontend opérationnel
- [ ] Dossier projet complet
- [ ] Préparation soutenance

---

## 💡 CONSEILS POUR LA SUITE

**Priorité 1 : React setup (2-3 janvier)**
- Commence simple
- Suit un tuto Vite + React Router
- Configure Axios avec base URL

**Priorité 2 : Login flow (4-6 janvier)**
- Code famille → Le plus important
- Sélection profil → 6 cartes cliquables
- JWT stocké → localStorage

**Priorité 3 : Calendrier (7-11 janvier)**
- Grille 24 portes → Focus UX
- 3 états visuels → Bien distinguables
- API appels → Async/await

**Priorité 4 : Upload photos (12 janvier)** 📸
- Input file + préview
- FormData pour upload
- Feedback utilisateur

**Priorité 5 : Galerie (13-14 janvier)** 📸
- Récupérer photos API
- Grid responsive
- Filtres

**Ne pas oublier :**
- Commits réguliers (1x/jour)
- Tests au fur et à mesure
- README frontend (comme backend)

---

**Dernière mise à jour : 1er janvier 2026 - 23h00**  
**État après refonte complète backend + upload photos + documentation V2**  

**Le backend est 100% terminé avec upload photos ! 🎉**  
**Version 2.1.0 - 9 endpoints API - 7 entités - Upload sécurisé ✅**
**Next step : Frontend React ! 🚀**