background: linear-gradient(90deg, 
    #00FF00 0%,      /* Vert fluo pur - gauche */
    #00E5A0 35%,     /* Vert menthe */
    #00D9B5 60%,     /* Cyan-vert */
    #00CDD9 85%,     /* Cyan clair */
    #00C3E8 100%     /* Bleu cyan - droite */
);
```

### **Couleurs principales**
- **Noir barre navigation** : `#000000` (opaque, pas de transparence)
- **Fond bleu glassmorphism** : `rgba(74, 144, 164, 0.4)` avec `backdrop-filter: blur(20px)`
- **Bleu badges/labels** : `rgba(74, 144, 164, 0.85)` (plus opaque)
- **Blanc texte principal** : `#FFFFFF`
- **Texte noir modal** : `#1A1A1A` ou `#000000`

### **Couleurs d'accentuation**
- **Bouton déconnexion** : `#8B3A3A` (bordeaux/marron rouge)
- **Bouton valider** : `#2C5F7B` (bleu marine foncé)
- **Bouton supprimer** : `#E67E7E` (corail/saumon)
- **Check vert portes** : `#00FF00` (vert fluo pur)
- **Border porte jour** : `#FFD700` (or pur)
- **Étoile jour** : `#FFC107` (jaune/or)
- **Cadenas fermé** : `#A8D5BA` (vert pale) ou `#90A4AE` (gris-bleu)
- **Flèche retour** : `#00D9E8` (cyan vif)

### **Couleurs progression**
- **Barre remplie** : `#FF9500` (orange vif)
- **Barre vide** : `rgba(255, 255, 255, 0.25)`
- **Pie chart** : Dégradé `#FF6B35` → `#FFA500`

---

## 📐 **DIMENSIONS & ESPACEMENTS EXACTS**

### **Header vert dégradé**
```
Hauteur : 100px
Padding vertical : 0
Titre principal : 
  - Font-size : 44px
  - Font-weight : 800 (Extra Bold)
  - Color : #FFFFFF
  - Text-stroke : 3px #000000 (contour noir)
  
Sous-titre :
  - Font-size : 26px
  - Font-weight : 600
  - Color : #FFFFFF
  - Text-stroke : 2px #000000
```

### **Barre navigation noire (écran 3)**
```
Hauteur : 70px
Background : #000000 (opaque)
Padding horizontal : 24px
Icônes : 48px x 48px
Gap entre icônes : 16px

Texte "Bonjour..." :
  - Font-size : 22px
  - Font-weight : 600
  - Color : #FFFFFF
```

### **Boutons principaux (Écran 0)**

**Bouton "Créer une nouvelle famille"**
```
Width : 380px
Height : 70px
Border-radius : 15px
Background : rgba(255, 255, 255, 0.95)
Box-shadow : 0px 6px 18px rgba(0, 0, 0, 0.25)
Padding : 16px 24px

Icône (maison) :
  - Size : 48px x 48px
  - Position : Left, margin-right 16px

Texte :
  - Font-size : 18px
  - Font-weight : 600
  - Color : #2C3E50 (gris très foncé)
```

**Bouton "Se Connecter"**
```
Width : 380px
Height : 80px
Border-radius : 15px
Background : rgba(255, 255, 255, 0.2)
Backdrop-filter : blur(15px)
Border : 2px solid rgba(255, 255, 255, 0.35)
Box-shadow : 0px 6px 18px rgba(0, 0, 0, 0.3)

Icône clé :
  - Size : 56px x 56px
  - Position : Left

Texte principal :
  - Font-size : 20px
  - Font-weight : 700
  - Color : #FFFFFF
  
Texte secondaire :
  - Font-size : 15px
  - Font-weight : 400
  - Color : #E8E8E8
```

---

### **Formulaire authentification (Écran 1)**

**Zone formulaire**
```
Width : 540px
Height : auto (min 420px)
Border-radius : 45px
Background : rgba(74, 144, 164, 0.45)
Backdrop-filter : blur(25px)
Border : 2px solid rgba(255, 255, 255, 0.3)
Box-shadow : 0px 12px 35px rgba(0, 0, 0, 0.4)
Padding : 48px
```

**Titre "Connectez-vous"**
```
Font-size : 34px
Font-weight : 700
Color : #FFFFFF
Text-align : center
Margin-bottom : 16px
Text-stroke : 2px rgba(0, 0, 0, 0.6)
```

**Label "Entrez le code Famille"**
```
Font-size : 20px
Font-weight : 600
Color : #FFFFFF
Text-stroke : 1.5px rgba(0, 0, 0, 0.5)
Margin-bottom : 12px
```

**Input code**
```
Width : 100%
Height : 65px
Border-radius : 12px
Background : rgba(255, 255, 255, 0.95)
Border : 2px solid rgba(255, 255, 255, 0.6)
Font-size : 20px
Font-weight : 600
Text-align : center
Color : #1A1A1A
Padding : 0 20px

Placeholder :
  - Color : #999999
  - Font-style : italic
```

**Bouton "Valider"**
```
Width : 180px
Height : 50px
Border-radius : 25px (pill)
Background : #2C5F7B (marine)
Box-shadow : 0px 5px 15px rgba(0, 0, 0, 0.35)
Font-size : 20px
Font-weight : 700
Color : #FFFFFF
Margin-top : 32px
Position : center

Hover :
  - Transform : scale(1.06)
  - Box-shadow : 0px 7px 20px rgba(0, 0, 0, 0.45)
```

---

### **Sélection profil (Écran 2)**

**Bouton DÉCONNEXION**
```
Width : 190px
Height : 42px
Border-radius : 21px (pill)
Background : #8B3A3A (bordeaux)
Border : 2px solid #FFFFFF
Font-size : 16px
Font-weight : 700
Letter-spacing : 0.5px
Color : #FFFFFF
Position : Top-right (24px, 24px)
```

**Zone titre "Sélectionne Ton Profil"**
```
Width : 320px
Height : 50px
Border-radius : 0 0 20px 20px (rounded bottom only)
Background : rgba(74, 144, 164, 0.5)
Backdrop-filter : blur(10px)
Font-size : 24px
Font-weight : 700
Color : #FFFFFF
Text-align : center
Padding : 12px 24px
```

**Grille profils**
```
Display : Grid
Grid-template-columns : repeat(3, 1fr)
Grid-template-rows : repeat(2, 1fr)
Gap : 56px (horizontal) 48px (vertical)
Justify-items : center
Padding : 80px 120px
```

**Carte profil individuelle**
```
Width : 200px
Height : 240px
Border-radius : 20px
Background : rgba(255, 255, 255, 0.15)
Backdrop-filter : blur(18px)
Border : 3px solid rgba(255, 255, 255, 0.35)
Box-shadow : 0px 8px 22px rgba(0, 0, 0, 0.3)
Padding : 20px 16px
Display : flex
Flex-direction : column
Align-items : center
Transition : all 0.3s ease

Hover :
  - Border : 4px solid #FFD700
  - Transform : scale(1.09)
  - Box-shadow : 0px 0px 25px rgba(255, 215, 0, 0.6)
  - Cursor : pointer
```

**Avatar circulaire (dans carte)**
```
Width : 120px
Height : 120px
Border-radius : 50%
Border : 4px solid #FFFFFF
Background : #4A90A4 (bleu cyan)
Margin-bottom : 16px
Object-fit : cover
```

**Label nom (dans carte)**
```
Width : 140px
Height : 36px
Border-radius : 18px
Background : rgba(74, 144, 164, 0.9)
Font-size : 18px
Font-weight : 700
Color : #FFFFFF
Text-align : center
Text-transform : uppercase
Line-height : 36px
```

**Icônes bottom (son & paramètres)**
```
Son (bottom-left) :
  - Size : 56px x 56px
  - Border-radius : 50%
  - Background : rgba(0, 0, 0, 0.5)
  - Icon size : 32px, color #FFFFFF
  - Position : Fixed (24px, 24px)

Paramètres (bottom-right) :
  - Size : 64px x 64px
  - Border-radius : 50%
  - Background : linear-gradient(135deg, #FF6B35, #FFA500)
  - Icon size : 36px, color #FFFFFF
  - Position : Fixed (24px, 24px)
```

---

### **Portes du calendrier (Écran 3)**

**Porte standard (fermée)**
```
Diameter : Variable (75px, 85px, 95px, 105px)
Border-radius : 50%
Background : rgba(255, 255, 255, 0.25)
Backdrop-filter : blur(8px)
Border : 3px solid #FFFFFF
Box-shadow : 0px 4px 12px rgba(0, 0, 0, 0.3)

Numéro :
  - Font-size : 38px (pour 85px) - proportionnel
  - Font-weight : 800
  - Color : #FFFFFF
  - Text-stroke : 2px #000000
  - Position : Center

Cadenas :
  - Size : 28px x 28px
  - Color : #A8D5BA (vert pâle transparent)
  - Position : Bottom-center du cercle
```

**Porte ouverte**
```
Same base style
Border : 3px solid #00FF00 (vert fluo)
Icône check : ✓
  - Size : 32px x 32px
  - Color : #00FF00
  - Position : Bottom-center
Opacity : 0.85
Transform : rotate(-3deg)
```

**Porte du jour (disponible)**
```
Same base style
Border : 4px solid #FFD700 (or)
Box-shadow : 
  0px 4px 12px rgba(0, 0, 0, 0.3),
  0px 0px 20px rgba(255, 215, 0, 0.7)
  
Icône étoile : ⭐
  - Size : 40px x 40px
  - Color : #FFC107
  - Position : Bottom-center

Animation :
  - Keyframes : scale(1.0) → scale(1.08) → scale(1.0)
  - Duration : 2s
  - Iteration : infinite
  - Timing : ease-in-out
```

---

### **Modal défi (Écran 4)**

**Popup/Modal**
```
Width : 520px
Max-height : 75vh
Border-radius : 35px
Background : #FFFFFF
Box-shadow : 0px 15px 50px rgba(0, 0, 0, 0.6)
Padding : 48px 40px
Position : Fixed center
Z-index : 1000
```

**Lutin (top)**
```
Size : 90px x 90px
Position : Top-center (relative to modal)
Margin-bottom : 20px
```

**Titre défi**
```
Font-family : 'Comic Sans MS' ou 'Baloo 2'
Font-size : 26px
Font-weight : 700
Color : #2C3E50 (noir chaud)
Text-align : center
Margin-bottom : 8px
```

**Sous-titre personnalisé**
```
Font-size : 18px
Font-weight : 600
Font-style : italic
Color : #555555
Text-align : center
Margin-bottom : 24px
```

**Texte description**
```
Font-size : 16px
Font-weight : 400
Line-height : 1.65
Color : #333333
Text-align : left
Margin-bottom : 24px
```

**Icône vidéo**
```
Size : 52px x 52px
Margin : 0 auto 20px
Display : block
```

**Icône appareil photo**
```
Size : 52px x 52px
Position : Bottom-center de la modal
Margin-top : 24px
```

**Bouton retour (dans modal)**
```
Size : 56px x 56px
Border-radius : 50%
Background : rgba(0, 217, 232, 0.2)
Icon : Flèche cyan 36px
Position : Absolute bottom-left (-16px, -16px)

Hover :
  - Background : rgba(0, 217, 232, 0.35)
```

**Background overlay**
```
Background : rgba(0, 0, 0, 0.75)
Backdrop-filter : blur(6px)
Position : Fixed full-screen
Z-index : 999
```

---

### **Profil utilisateur (Écran 5)**

**Bouton Déconnexion (header)**
```
Width : 200px
Height : 46px
Border-radius : 23px (pill)
Background : #8B3A3A
Border : 2.5px solid #FFFFFF
Font-size : 17px
Font-weight : 700
Color : #FFFFFF
Position : Top-right (32px, 24px)
```

**Titre "Profil"**
```
Font-size : 36px
Font-weight : 800
Color : #FFFFFF
Text-stroke : 2.5px #000000
Text-align : center
Position : Header center
```

**Info profil (ligne)**
```
Layout : Flex row, gap 40px
Font-size : 30px
Font-weight : 700
Color : #FFFFFF
Text-stroke : 2px #000000
Justify-content : center
Align-items : center
Margin-top : 32px
```

**Titre "Réalisation"**
```
Width : 240px
Height : 48px
Border-radius : 24px
Background : rgba(74, 144, 164, 0.6)
Font-size : 24px
Font-weight : 700
Color : #FFFFFF
Text-align : center
Line-height : 48px
Margin : 40px auto 32px
```

**Badge "3 / 24 défis"**
```
Width : auto (padding)
Height : 44px
Border-radius : 22px
Background : rgba(74, 144, 164, 0.75)
Padding : 0 24px
Font-size : 20px
Font-weight : 700
Color : #FFFFFF
Display : inline-flex
Align-items : center
Gap : 12px

Étoile :
  - Size : 32px
  - Color : #FFC107
```

**Pie chart (diagramme)**
```
Diameter : 110px
Stroke-width : 14px
Colors : 
  - Fill : Dégradé #FF6B35 → #FFA500
  - Empty : rgba(255, 255, 255, 0.2)
  
Texte center :
  - Font-size : 18px
  - Font-weight : 700
  - Color : #FFFFFF
```

**Badge "12.5% complété"**
```
Width : auto
Height : 44px
Border-radius : 22px
Background : rgba(74, 144, 164, 0.75)
Padding : 0 28px
Font-size : 20px
Font-weight : 700
Color : #FFFFFF
```

**Barre de progression**
```
Width : 80% (max 600px)
Height : 16px
Border-radius : 8px
Background : rgba(255, 255, 255, 0.25)
Margin : 24px auto

Fill :
  - Background : #FF9500
  - Height : 100%
  - Border-radius : 8px
  - Width : {percentage}%
```

**Titre "Photos"**
```
Width : 180px
Height : 44px
Border-radius : 22px
Background : rgba(74, 144, 164, 0.6)
Font-size : 22px
Font-weight : 700
Color : #FFFFFF
Text-align : center
Line-height : 44px
Margin : 32px auto 20px
```

**Miniatures photos (grid)**
```
Display : Flex
Gap : 20px
Justify-content : center

Chaque photo :
  - Size : 80px x 80px
  - Border-radius : 12px
  - Object-fit : cover
  - Box-shadow : 0px 4px 10px rgba(0, 0, 0, 0.25)
  - Hover : scale(1.15)
```

**Boutons footer (RGPD, etc.)**
```
Width : auto (padding)
Height : 40px
Border-radius : 20px
Background : rgba(255, 255, 255, 0.25)
Backdrop-filter : blur(8px)
Border : 1.5px solid rgba(255, 255, 255, 0.4)
Padding : 0 20px
Font-size : 14px
Font-weight : 600
Color : #FFFFFF
Display : inline-flex
Align-items : center
Gap : 8px
Margin : 0 8px

Icon :
  - Size : 20px
  - Color : #FFFFFF
```

**Bouton "Supprimer mon compte"**
```
Width : 280px
Height : 44px
Border-radius : 22px
Background : #E67E7E
Font-size : 16px
Font-weight : 700
Color : #FFFFFF
Margin-top : 32px
Box-shadow : 0px 4px 12px rgba(0, 0, 0, 0.3)

Hover :
  - Background : #D65A5A
  - Transform : scale(1.03)
```

---

## 🔤 **TYPOGRAPHIE EXACTE**

**Police principale**
```
Font-family : 'Comic Sans MS', 'Baloo 2', sans-serif