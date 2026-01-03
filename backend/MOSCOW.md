# 🎄 MoSCoW - Calendrier de l'Avent Familial
## État d'avancement au 3 janvier 2026 - 10h00

**Légende :**
- ✅ = Terminé (vert)
- 🟡 = Commencé mais pas fini (orange)  
- ❌ = Pas commencé (non coché)

---

## 🔴 MUST HAVE (Obligatoire pour certification)

### 1. Maquettes & Design ✅ 100%
- ✅ **Wireframes mobile** (9 écrans complets sur Figma)
  - ✅ Écran 0 : Accueil
  - ✅ Écran 1 : Authentification code famille
  - ✅ Écran 1a : Création famille/inscription
  - ✅ Écran 2 : Sélection profils Netflix-style
  - ✅ Écran 3 : Calendrier 24 portes
  - ✅ Écran 4 : Contenu porte/Défis
  - ✅ Écran 5 : Profil utilisateur
  - ✅ Écran 6 : Ajouter membre
  - ✅ Écran 7 : Galerie familiale
- ✅ **Maquettes desktop** (9 écrans - Terminées le 2 janvier 2026)
  - ✅ Écran 0 : Accueil avec 2 boutons
  - ✅ Écran 1 : Authentification code famille
  - ✅ Écran 1a : Inscription/Création famille complète
  - ✅ Écran 2 : Sélection profils Netflix-style (6 avatars, vidéo fond, musique)
  - ✅ Écran 3 : Calendrier 24 portes aléatoires (Math.random) avec thèmes personnalisés
  - ✅ Écran 4 : Défis avec lutin, message, vidéo tuto, upload photo
  - ✅ Écran 5 : Profil utilisateur avec stats (X/24 défis, %)
  - ✅ Écran 6 : Ajouter un membre à la famille
  - ✅ Écran 7 : Galerie photos masonry layout avec filtres
- ✅ **Charte graphique complète dans Figma**
  - Couleurs : Thèmes personnalisés par profil
  - Typographie : Police moderne lisible
  - Composants réutilisables
- ✅ **Responsive design** (desktop 1920px + mobile 375x812px)

### 2. Page Sélection profils (Netflix-style) ✅
- ✅ **Maquette desktop complète** (terminée 2 janvier)
  - 6 cartes avatar (Mamie, Papy, Maman, Papa, Khélyann, Khyle)
  - Background vidéo neige animée
  - Grille 2x3 responsive
  - Musique nostalgique (Jingle Bells, Home Alone)
  - Icône galerie 🖼️
  - Bouton déconnexion
- ✅ **Maquette mobile complète**
- ❌ **Code frontend** (React pas commencé)

### 3. Page Login (après sélection) ✅
- ✅ **Maquette desktop complète**
  - Formulaire code famille (ex: NOEL2026)
  - Background neige identique accueil
  - Bouton retour
  - Message "Entrez le code Famille"
- ✅ **Maquette mobile complète**
- ✅ **Architecture backend cohérente**
  - POST /auth/family (vérification code)
  - POST /auth/profile (sélection profil)
  - Maquettes alignées avec backend ✅
- ❌ **Code frontend**

### 4. Page Calendrier (24 portes) ✅
- ✅ **Maquette desktop complète** (terminée 2 janvier)
  - 24 portes de tailles aléatoires (Math.random())
  - Positionnement dynamique
  - Background thème personnalisé par profil :
    - Khyle : Village coloré
    - Khelyann : Neige moderne
    - Papa/Maman : Cheminée cosy
    - Papy/Mamie : Traditionnel
  - 4 états visuels :
    - 🔒 Fermée (cadenas)
    - ⭐ Jour J (étoile)
    - ✅ Ouverte (check vert)
    - 🚪 Porte sortie
  - Message personnalisé "Bonjour [prénom], bienvenue sur ton calendrier"
  - Barre navigation : Retour, Galerie, Son, Profil
- ✅ **Maquette mobile complète**
- ❌ **Code frontend**

### 5. Page Contenu porte ✅
- ✅ **Maquette desktop complète**
  - Lutin Noël personnage
  - Titre défi (ex: "Jour 3 : un sapin de Noël tu créeras")
  - Message personnalisé ("Coucou mamie!")
  - Explication défi avec emoji
  - Icône vidéo tuto 📹
  - Bouton appareil photo 📷 (upload)
  - Boutons : Son, Retour calendrier
  - Background thème personnalisé
- ✅ **Maquette mobile complète**
- 🟡 **Animations listées** (zoom, rotation, fade, slide) mais pas codées
- ❌ **Code frontend**

### 6. Page Galerie familiale ✅
- ✅ **Maquette desktop complète** (terminée 2 janvier)
  - Layout masonry (grille adaptative avec tailles variées)
  - Filtres par membre de la famille
  - Lightbox pour affichage plein écran
  - Attribution ("Réalisé par : Mamie, Khyle...")
  - Scroll vertical
- ✅ **Maquette mobile complète**
- ✅ **Backend API** GET /api/photos 📸
  - Filtrage par famille
  - Tri par date
  - Infos complètes (uploader, porte, caption)
- ❌ **Code frontend**

### 7. Backend ✅ 100%
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

### 8. Technique Frontend ❌ 0%
- ❌ React 18+ avec Vite
- ❌ React Router
- ❌ Gestion état (useState, useContext)
- ❌ Appels API (Axios + JWT)
- ❌ Gestion erreurs
- ❌ localStorage pour token
- ❌ Upload photos côté client

### 9. Livrables ECF 🟡
- ✅ **Dossier projet** (maquettes complètes Figma, cahier des charges à formaliser)
- ✅ **Dossier technique** (README backend V2 + ERD V2)
- 🟡 **Code commenté** (backend oui, frontend non)
- ✅ **README détaillé** (backend complet avec upload)
- ✅ **Captures d'écran** (maquettes Figma complètes)
- ✅ **Git** (tout poussé sur GitHub)

---

## 🟠 SHOULD HAVE (Améliore le projet)

### 1. Page Sélection profils - Améliorations
- ✅ **Vidéo background** (intégrée dans maquettes desktop)
- ✅ **Musique nostalgique** (Jingle Bells, Home Alone - spécifiée dans maquettes)
- ✅ **Bouton mute/unmute** (dans maquette)
- ❌ Animation survol avatars (à coder)
- ❌ Transition douce après sélection (à coder)

### 2. Backgrounds personnalisés ✅
- ✅ **Table `theme` en BDD** (4 themes créés)
  - colorful_village (Khyle)
  - modern_snow (Khélyann)
  - cozy (Papa/Maman)
  - traditionnel (Papy/Mamie)
- ✅ **Relation Famille → Theme**
- ✅ **API GET /api/themes**
- ✅ **API GET /api/me/famille** retourne thème
- ✅ **Maquettes desktop montrent backgrounds différents** (cheminée, village, montagne, neige)
- ❌ **Affichage frontend selon user**

### 3. Contenu enrichi portes ✅
- ✅ **Structure BDD** (imageUrl, musicUrl, videoUrl dans Door)
- ✅ **Maquettes montrent** icône vidéo 📹 et upload photo 📷
- ✅ **Backend upload photos** 📸
  - POST /api/door-openings/{id}/photo
  - Stockage sécurisé
  - Validation format
- ❌ Affichage images frontend
- ❌ Upload frontend
- ❌ Lecteur audio (musicUrl)
- ❌ Lecteur vidéo (videoUrl)

### 4. Animations & UX
- 🟡 **Animations listées** dans maquettes (Zoom, Rotation, Fade, Slide) mais pas codées
- ❌ Animation ouverture porte (3D/slide)
- ❌ Flocons de neige animés (CSS)
- ❌ Transitions fluides
- ❌ Effet brillant porte du jour (glow)
- ❌ Loading spinner

### 5. Page Profil ✅
- ✅ **Maquette desktop complète**
  - Voir infos (Prénom, Âge)
  - Stats réalisations (⭐ 5/24 défis, 📊 21% complété)
  - Mes photos (J-1, J-2, J-3)
  - Bouton changer paysage (dropdown 6 options)
  - Paramètres RGPD
  - Déconnexion
- ✅ **Maquette mobile complète**
- ❌ **Code frontend**

### 6. Tests & Qualité
- ✅ **Tests manuels backend** (Postman - 9 endpoints validés)
- ❌ Tests unitaires (Jest)
- ❌ Tests intégration API
- ❌ Validation accessibilité (a11y)
- ❌ Optimisation performances (Lighthouse)

---

## 🟡 COULD HAVE (Bonus si temps)

### Features avancées
- ✅ **Portes aléatoires** (Math.random() dans maquettes desktop)
- ✅ **Vidéos** (structure BDD + icône dans maquettes + vidéo background)
- ✅ **Upload photos** (backend 100% terminé) 📸
  - POST endpoint
  - Stockage sécurisé
  - Validation
  - Galerie API
- ✅ **Galerie familiale** (maquette desktop masonry + backend API)
- ❌ Dashboard admin
- ❌ Compte à rebours Noël
- ❌ Notifications

### Design avancé
- ✅ **Sélection thème par user** (dropdown dans maquettes)
- ✅ **Lightbox galerie** (dans maquettes desktop)
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
- ✅ **Git** (commits réguliers, tout poussé)

### Maquettes/Design : 100% ✅ ⭐⭐⭐
- ✅ 9 maquettes mobile complètes sur Figma
- ✅ 9 maquettes desktop complètes sur Figma (terminées 2 janvier)
- ✅ Flows utilisateurs documentés
- ✅ Responsive (2 formats : 1920px desktop + 375px mobile)
- ✅ Charte graphique complète dans Figma
- ✅ Composants réutilisables
- ✅ 4 thèmes personnalisés détaillés
- ✅ Login Netflix-style avec vidéo de fond
- ✅ Calendrier avec portes aléatoires (Math.random)
- ✅ Galerie masonry layout

### Frontend : 0% ❌
- React non installé
- Aucune page codée
- Aucun composant créé

---

## 🎯 PROJET GLOBAL : 50%

**Répartition réelle :**
- Backend : 30% du projet → **100% fait = 30%** ✅
- Maquettes : 15% du projet → **100% fait = 15%** ✅
- Documentation : 5% du projet → **100% fait = 5%** ✅  
- Frontend : 50% du projet → **0% fait = 0%** ❌

**TOTAL : 50%** 🎉

---

## 🎉 ACHIEVEMENTS 2-3 JANVIER 2026

### 🎨 Maquettes desktop Figma terminées (2 janvier soir - 9 écrans)

1. ✅ **Écran 0 - Accueil**
   - "Bienvenue dans la magie de Noël 2026"
   - 2 boutons : Créer famille / Se connecter

2. ✅ **Écran 1 - Authentification**
   - Formulaire code famille
   - Background neige animée

3. ✅ **Écran 1a - Inscription**
   - Création famille complète
   - Formulaire admin (nom, code, email, premier profil)

4. ✅ **Écran 2 - Sélection profils Netflix-style**
   - 6 avatars cliquables
   - Vidéo de fond (neige/cheminée)
   - Musique nostalgique (Jingle Bells, Home Alone)

5. ✅ **Écran 3 - Calendrier**
   - 24 portes de tailles aléatoires (Math.random())
   - 4 backgrounds personnalisés par profil
   - États visuels (fermée, jour J, ouverte)

6. ✅ **Écran 4 - Défis**
   - Lutin Noël, message personnalisé
   - Vidéo tuto, bouton upload photo
   - Animations détaillées

7. ✅ **Écran 5 - Profil**
   - Stats réalisations (3/24 défis, 12.5%)
   - Mes photos
   - Paramètres RGPD

8. ✅ **Écran 6 - Ajouter membre**
   - Formulaire ajout profil
   - Choix avatar et thème

9. ✅ **Écran 7 - Galerie**
   - Layout masonry (grille adaptative)
   - Filtres par membre/jour
   - Lightbox plein écran

### 📝 Documentation mise à jour (3 janvier matin)

5. ✅ **README mis à jour**
   - État d'avancement actualisé
   - Maquettes desktop ajoutées
   - Roadmap frontend détaillée
   - Section Figma ajoutée

6. ✅ **MOSCOW mis à jour**
   - Maquettes desktop 100%
   - Score global 50%
   - Prochaines étapes React

7. ✅ **Git propre**
   - .gitignore mis à jour
   - Fichiers temporaires supprimés
   - Commits à jour

---

## 🚀 PROCHAINES PRIORITÉS (dans l'ordre)

### Phase 1 : Setup React (2 jours - 3-4 janvier) 🔥

1. **Installation Vite + React 18**
   ```bash
   npm create vite@latest frontend -- --template react
   cd frontend
   npm install
   npm install react-router-dom axios
   ```

2. **Configuration API**
   - Créer `/src/services/api.js`
   - Configurer Axios avec base URL
   - Intercepteurs JWT
   - Gestion erreurs

3. **Structure dossiers**
   ```
   frontend/src/
   ├── components/     # Composants réutilisables
   ├── pages/          # Pages principales
   ├── services/       # API calls
   ├── contexts/       # Context API (auth, theme)
   ├── hooks/          # Custom hooks
   └── styles/         # CSS global
   ```

---

### Phase 2 : Pages principales (12 jours - 5-16 janvier)

4. **Login Flow** (3 jours)
   - Page code famille (POST /auth/family)
   - Page sélection profils Netflix-style (6 cartes)
   - Page login profil (POST /auth/profile)
   - Stockage token localStorage
   - Context Auth

5. **Calendrier** (5 jours)
   - Grille 24 portes
   - 3 états visuels (fermée, jour J, ouverte)
   - GET /api/doors
   - GET /api/me/famille (thème personnalisé)
   - Background dynamique selon profil
   - Message bienvenue personnalisé

6. **Contenu porte** (2 jours)
   - Modal/Page défi
   - POST /api/doors/{id}/open
   - Affichage message du jour
   - Bouton retour calendrier

7. **Upload photo** (1 jour) 📸
   - Input file + prévisualisation
   - POST /api/door-openings/{id}/photo
   - FormData upload
   - Caption optionnelle
   - Feedback succès/erreur

8. **Navigation** (1 jour)
   - React Router setup
   - Navbar avec liens
   - Routes protégées
   - Redirection si non auth
   - 404 page

---

### Phase 3 : Galerie + Responsive (5 jours - 17-21 janvier)

9. **Galerie familiale** (2 jours) 📸
   - GET /api/photos
   - Layout masonry (CSS Grid)
   - Lightbox plein écran
   - Filtres par membre
   - Attribution (qui a uploadé)
   - Scroll infini (optionnel)

10. **Responsive design** (2 jours)
    - Mobile-first CSS
    - Breakpoints (375px, 768px, 1024px, 1920px)
    - Tests multi-devices
    - Menu burger mobile

11. **Tests & Debug** (1 jour)
    - Flow complet de A à Z
    - Gestion erreurs réseau
    - Loading states
    - Messages d'erreur user-friendly

---

### Phase 4 : SHOULD HAVE (optionnel - 22-31 janvier)

12. **Profil utilisateur** (2 jours)
    - Page profil
    - Stats réalisations (X/24 défis)
    - Mes photos
    - Déconnexion

13. **Animations** (2 jours)
    - Ouverture porte (transition CSS)
    - Flocons neige (CSS animation)
    - Transitions pages (React Router)
    - Hover effects

14. **Audio/Vidéo** (2 jours)
    - Musique de fond (Jingle Bells)
    - Vidéo background (neige)
    - Contrôles mute/unmute
    - Lecteur vidéo défis

---

**= 22 jours de dev frontend**  
**Tu as ~52 jours avant stage (mi-février) = TRÈS LARGEMENT FAISABLE ! 💪**

---

## 📋 CHECKLIST AVANT STAGE (mi-février)

### Backend ✅ 100%
- [x] API REST complète (9 endpoints)
- [x] JWT sécurisé
- [x] Base de données (7 tables)
- [x] Upload photos
- [x] Documentation
- [x] Tests manuels
- [ ] Tests automatisés (optionnel)

### Maquettes ✅ 100%
- [x] 9 écrans mobile Figma
- [x] 6 écrans desktop Figma
- [x] Charte graphique complète
- [x] Responsive design
- [x] Flows utilisateurs

### Frontend ❌ 0%
- [ ] React installé + configuré
- [ ] Pages login/calendrier/porte
- [ ] Upload photos frontend
- [ ] Galerie familiale
- [ ] Appels API fonctionnels
- [ ] Responsive desktop/mobile
- [ ] Tests basiques
- [ ] Gestion erreurs

### Livrables ECF 🟡
- [x] Maquettes complètes Figma
- [x] Backend documenté
- [ ] Frontend opérationnel
- [ ] Dossier projet complet
- [ ] Préparation soutenance
- [ ] README frontend

---

## 💡 CONSEILS POUR LA SUITE

**Priorité 1 : React setup (3-4 janvier)** 🔥
- Crée le projet Vite aujourd'hui
- Configure Axios avec ton API
- Teste un premier appel simple (GET /api/themes)
- Commit réguliers sur GitHub

**Priorité 2 : Login flow (5-7 janvier)**
- Code famille → Le plus important
- Sélection profil → 6 cartes cliquables (comme maquette)
- JWT stocké → localStorage
- Context Auth pour partager l'état

**Priorité 3 : Calendrier (8-12 janvier)**
- Grille 24 portes → Focus UX
- 3 états visuels → Bien distinguables (comme maquettes)
- Background thème → Récupérer via API
- Async/await pour API calls

**Priorité 4 : Upload photos (13 janvier)** 📸
- Input file + préview image
- FormData pour upload multipart
- Feedback utilisateur clair
- Gérer les erreurs

**Priorité 5 : Galerie (14-15 janvier)** 📸
- Récupérer photos via GET /api/photos
- Grid responsive (masonry comme maquette)
- Filtres par membre
- Lightbox

**Ne pas oublier :**
- Commits réguliers (1-2x/jour minimum)
- Tests au fur et à mesure
- README frontend (comme backend)
- Screenshots pour soutenance

---

## 🎓 RESSOURCES POUR REACT

**Setup & Basics :**
- Vite : https://vitejs.dev/guide/
- React Router : https://reactrouter.com/
- Axios : https://axios-http.com/

**Concepts clés à maîtriser :**
- useState (état local)
- useEffect (appels API)
- useContext (Auth global)
- React Router (navigation)
- FormData (upload fichiers)

**Tu as déjà :**
- ✅ API backend fonctionnelle
- ✅ Maquettes complètes (tu sais exactement quoi faire)
- ✅ 52 jours avant le stage
- ✅ Compétences solides en JS

**= C'est du tout cuit ! 🚀**

---

**Dernière mise à jour : 3 janvier 2026 - 10h00**  
**État après maquettes desktop terminées**  

**Backend : 100% ✅ | Maquettes : 100% ✅ | Frontend : 0% ❌**  
**Version 2.1.0 - 9 endpoints API - 7 entités - Maquettes Figma complètes**  
**Next step : Setup React aujourd'hui ! 🔥**
