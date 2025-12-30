# Wireframes Mobile - Calendrier de l'Avent 2026

## 📱 Vue d'ensemble

Wireframes basse fidélité pour l'application mobile "Calendrier de l'Avent 2026".  
Format : Mobile (375×812px)  
Outil : Excalidraw  
Date : Décembre 2025

---

## 🎯 Liste des écrans

### **Écran 0 : Accueil**
- **Fichier** : `ecran0-accueil-mobile.png`
- **Description** : Page d'accueil avec deux options principales
- **Actions** :
  - Créer une nouvelle famille
  - Se connecter (code famille existant)
- **Design** : Background dégradé linéaire moderne, image Noël avec texte superposé

---

### **Écran 1 : Authentification**
- **Fichier** : `ecran1-authentification-mobile.png`
- **Description** : Saisie du code famille pour connexion
- **Flow** : Accueil → Authentification → Sélection profils
- **Design** : Même background que l'accueil

---

### **Écran 1a : Créer famille**
- **Fichier** : `ecran1a-inscription-profil-mobile.png`
- **Description** : Formulaire de création d'une nouvelle famille
- **Champs** :
  - Nom de famille
  - Code famille (à créer)
  - Email administrateur
  - Premier profil (Admin) : Prénom, Âge, Avatar
- **RGPD** :
  - Checkbox politique de confidentialité
  - Checkbox consentement parental (si < 15 ans)
- **Flow** : Accueil → Créer famille → Sélection profils
- **Note** : Paysage assigné automatiquement selon âge + avatar

---

### **Écran 2 : Sélection profils**
- **Fichier** : `ecran2-selection-profil-mobile.png`
- **Description** : Choix du profil utilisateur
- **Éléments** :
  - Liste des avatars familiaux
  - Scroll vertical
  - Bouton "s'inscrire" (ajouter membre)
- **Flow** : Post-authentification → Sélection → Calendrier

---

### **Écran 3 : Calendrier**
- **Fichier** : `ecran3-calendrier-profil-mobile.png`
- **Description** : Hub central - Calendrier personnalisé 24 jours
- **Fonctionnalités** :
  - Message personnalisé ("Bonjour Khyle")
  - 24 cases avec états (Fermée 🔒, Ouverte ✅, Jour J ⭐, Porte sortie 🚪)
  - Légende complète
  - Navigation bas écran : Son 🔔, Profil 👤, Galerie 🖼️
- **Design** : Background animé Noël + musique
- **Flow** : Point central → Défis / Profil / Galerie

---

### **Écran 4 : Défis**
- **Fichier** : `ecran4-defis-profil-mobile.png`
- **Description** : Écran du défi quotidien
- **Éléments** :
  - Carte lutin Noël personnage
  - Titre du défi
  - Message personnalisé ("Coucou Khyle 👋")
  - Explication défi avec emoji
  - Tutoriel vidéo (icône 📹)
  - Upload photo 📷
  - Boutons : Activer/Désactiver son, Pour sortir
- **Design** : Background animé paysage personnalisé
- **Flow** : Calendrier → Clic case → Défi → Upload → Retour

---

### **Écran 5 : Ajouter membre**
- **Fichier** : `ecran5-ajouter-profil-mobile.png`
- **Description** : Formulaire pour rejoindre une famille existante
- **Champs** :
  - Texte de bienvenue
  - Prénom
  - Âge
  - Choix avatar
  - Choix paysage (dropdown 6 options)
  - Email parents
  - Code famille (vérification)
  - Bouton "Donner par Administrateur" (optionnel)
- **RGPD** :
  - Checkbox politique de confidentialité
  - Checkbox consentement parental (si < 15 ans)
- **Flow** : Sélection profils → "s'inscrire" → Formulaire → Retour sélection
- **Note** : Email de confirmation envoyé après validation

---

### **Écran 6 : Profil utilisateur**
- **Fichier** : `ecran6-edit-profil-mobile.png`
- **Description** : Gestion du profil personnel
- **Sections** :
  - **Informations** : Prénom, Âge
  - **Personnalisation** : Paysage actuel + Bouton "Changer" (dropdown 6 options)
  - **Réalisations** :
    - Stats gamification (⭐ 5/24 défis, 📊 21% complété)
    - Message motivation (19 défis restants ! 💪)
  - **Mes photos** : Grid miniatures (J-1, J-2, J-3) avec affichage full screen au clic
  - **Paramètres RGPD** :
    - 📄 Politique de confidentialité
    - 📥 Télécharger mes données
    - 🗑️ Supprimer mon compte
  - **Déconnexion**
- **Design** : Background fond uni couleur neutre ou dégradé linéaire moderne
- **Flow** : Calendrier → Clic icône 👤 → Profil

---

### **Écran 7 : Galerie familiale**
- **Fichier** : `ecran7-galerie-profil-mobile.png`
- **Description** : Feed photos des défis de toute la famille
- **Fonctionnalités** :
  - Filtres : "Tous" / "Jour" (dropdowns)
  - Cards photos par jour :
    - Icône + numéro (🎄 JOUR 3)
    - Titre défi (Sapin, Dessin...)
    - Photo grande
    - Attribution (Réalisé par : Mamie, Khélyann, Khyle)
  - Scroll vertical
- **Design** : Background fond uni neutre ou dégradé
- **Flow** : Calendrier → Clic icône 🖼️ → Galerie
- **Retour** : Vers calendrier

---

## 🔄 Parcours utilisateurs principaux

### **Parcours A : Nouvelle famille**
```
Accueil → Créer famille → Sélection profils → Calendrier → Défis → Galerie
```

### **Parcours B : Utilisateur existant**
```
Accueil → Authentification → Sélection profils → Calendrier → Défis → Galerie
```

### **Parcours C : Ajout membre**
```
Sélection profils → "s'inscrire" → Ajouter membre → Retour sélection
```

### **Parcours D : Gestion profil**
```
Calendrier → Profil → Modifier paysage / Voir stats / RGPD
```

---

## 🎨 Conventions de design

### **Backgrounds**
- **Écrans magiques** (animés Noël) : Accueil, Authentification, Sélection, Calendrier, Défis, Créer famille
- **Écrans fonctionnels** (fond sobre) : Galerie, Profil

### **Navigation**
- **Retour** : Flèche ← en haut à gauche
- **Barre navigation** : Bottom bar sur calendrier (Son, Profil, Galerie)

### **Composants récurrents**
- Boutons arrondis
- Cards avec ombres légères
- Icônes émojis pour clarté
- Dropdowns pour sélection

---

## ⚖️ Conformité RGPD

### **Consentements**
- ✅ Politique de confidentialité (checkbox obligatoire)
- ✅ Consentement parental si âge < 15 ans (checkbox conditionnelle)

### **Droits utilisateurs**
- 📄 Accès politique de confidentialité
- 📥 Télécharger ses données (portabilité)
- 🗑️ Supprimer son compte (droit à l'effacement)

---

## 🔐 Architecture technique

### **Multi-tenant**
- Chaque famille = Instance isolée
- Code famille unique par foyer
- Données strictement cloisonnées
- Aucun accès inter-familles

### **Personnalisation intelligente**
- Paysage assigné selon **âge + avatar** lors création
- Modifiable dans profil après
- 8 combinaisons optimisées UX

### **Rôles**
- **Admin famille** : Créateur, gestion famille
- **Membre** : Utilisateur standard
- **Super admin** : Emmanuel (gestion technique globale)

---

## 📊 Statistiques wireframes

- **Nombre d'écrans** : 9
- **Parcours couverts** : 4 principaux
- **Points de navigation** : 15+
- **Format** : Mobile 375×812px
- **Taille totale** : ~3 Mo

---

## 🚀 Prochaines étapes

1. ✅ Wireframes mobile (terminé)
2. ⏳ Maquettes haute fidélité Figma (desktop)
3. ⏳ Développement backend Symfony
4. ⏳ Développement frontend React
5. ⏳ Tests et déploiement

---

## 👤 Auteur

**Emmanuel**  
Étudiant développeur web - AFPA Saint-Jean-de-Védas  
Projet ECF - Décembre 2025

---

## 📝 Notes

- Wireframes créés avec Excalidraw
- Approche mobile-first
- Architecture évolutive (système A actuel, migration système B possible)
- Focus UX enfants + seniors
- RGPD by design
