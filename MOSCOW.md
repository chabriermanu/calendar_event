# 🎄 MoSCoW - Calendrier de l'Avent Familial

## 📋 Contexte projet
- **Type** : Projet de certification AFPA + Projet familial
- **Utilisateurs** : 6 membres (Papa admin, Maman, Papy, Mamie, Grand frère 16 ans, Khyle 4 ans)
- **Timeline** : Décembre 2025 → Avril 2026 (certification ECF)
- **Objectif** : Calendrier Noël 2026 avec défis pour Khyle

---

## 🔴 MUST HAVE (Obligatoire pour certification)

### 1. Maquettes & Design
- [ ] Wireframes 3 écrans (sélection profils, calendrier, contenu porte)
- [ ] Charte graphique (palette Noël, typographie, logo)
- [ ] Responsive design (mobile + desktop)

### 2. Page Sélection profils (Netflix-style)
- [ ] 6 cartes avatar cliquables (Papy, Mamie, Papa, Maman, Grand frère, Khyle)
- [ ] Background statique Noël
- [ ] Clic avatar → Pré-remplit email → Page password
- [ ] Grille responsive 2x3 ou 3x2
- [ ] Gros boutons (accessibilité grands-parents)

### 3. Page Login (après sélection)
- [ ] Message personnalisé ("Bonjour Khyle !")
- [ ] Email pré-rempli (disabled)
- [ ] Champ password
- [ ] Bouton "👁️ Voir/Masquer password"
- [ ] Gestion erreurs
- [ ] Bouton "Se connecter"

### 4. Page Calendrier (24 portes)
- [ ] Grille 4x6 ou 6x4 (24 portes)
- [ ] 3 états visuels :
  - 🔒 Fermée (date future) - grisée, non cliquable
  - ⭐ Du jour - brillante, cliquable
  - ✅ Ouverte - marquée, recliquable
- [ ] Numéro visible (1-24)
- [ ] Empêcher ouverture future (UX + API)
- [ ] Message bienvenue ("Bonjour [Pseudo]")
- [ ] Bouton déconnexion
- [ ] Responsive mobile

### 5. Page Contenu porte
- [ ] Titre de la porte
- [ ] Message/défi
- [ ] Bouton retour calendrier
- [ ] Enregistre ouverture (POST /api/door_openings)

### 6. Backend
- [x] API REST complète
- [x] JWT authentification
- [x] 3 entités + relations
- [x] Validations + sécurité
- [ ] Documentation API (README)
- [ ] Schéma BDD (diagramme ERD)

### 7. Technique Frontend
- [ ] React 18+ avec Vite
- [ ] React Router
- [ ] Gestion état (useState, useContext)
- [ ] Appels API (fetch + JWT)
- [ ] Gestion erreurs
- [ ] localStorage pour token

### 8. Livrables ECF
- [ ] Dossier projet (cahier des charges)
- [ ] Dossier technique (architecture)
- [ ] Code commenté
- [ ] README détaillé
- [ ] Captures d'écran

---

## 🟠 SHOULD HAVE (Améliore le projet)

### 1. Page Sélection profils - Améliorations
- [ ] **Vidéo background** (neige/cheminée)
- [ ] **Musique nostalgique** (Jingle Bells)
- [ ] Bouton mute/unmute 🔊
- [ ] Animation survol avatars
- [ ] Transition douce après sélection

### 2. Backgrounds personnalisés
- [ ] Champ `theme` dans User
- [ ] 5-6 backgrounds différents :
  - Khyle : Village Père Noël coloré
  - Ado : Montagne enneigée moderne
  - Parents : Cheminée cosy
  - Grands-parents : Maison traditionnelle
- [ ] Affichage automatique selon user

### 3. Contenu enrichi portes
- [ ] Affichage images (imageUrl)
- [ ] Lecteur audio (musicUrl) - pour Khyle
- [ ] Mode défi visuel (consignes illustrées)

### 4. Animations & UX
- [ ] Animation ouverture porte (3D/slide)
- [ ] Flocons de neige animés (CSS)
- [ ] Transitions fluides
- [ ] Effet brillant porte du jour (glow)
- [ ] Loading spinner

### 5. Page Profil
- [ ] Voir mes portes ouvertes
- [ ] Mon pseudo
- [ ] Changer password

### 6. Tests & Qualité
- [ ] Tests unitaires (Jest)
- [ ] Tests intégration API
- [ ] Validation accessibilité (a11y)
- [ ] Optimisation performances (Lighthouse)

---

## 🟡 COULD HAVE (Bonus si temps)

### Features avancées
- [ ] **Portes aléatoires** (tailles/positions Math.random)
- [ ] Vidéos (videoUrl)
- [ ] Upload photos (réalisations défis)
- [ ] Galerie familiale
- [ ] Dashboard admin
- [ ] Compte à rebours Noël
- [ ] Notifications

### Design avancé
- [ ] Sélection thème par user
- [ ] Mode nuit/jour
- [ ] Effets parallax
- [ ] Animations 3D

### Social
- [ ] Commentaires sur portes
- [ ] Like/réactions défis
- [ ] Historique années précédentes

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

## 📅 Planning

**Phase 1 : Préparation** (maintenant → mi-janvier)
- Apprendre React
- Maquettes/wireframes
- Dossier projet

**Phase 2 : MUST HAVE** (mi-janvier → mi-février)
- Setup React
- Pages login + calendrier
- Responsive

**Phase 3 : SHOULD HAVE** (stage : mi-février → mars)
- Vidéo/musique
- Backgrounds personnalisés
- Animations

**Phase 4 : COULD HAVE** (avril si temps)
- Features bonus

**Phase 5 : Finitions** (avril)
- Documentation ECF
- Tests finaux
- Soutenance

---

**Dernière mise à jour : 26 décembre 2025**