# 🎄 Calendrier de l'Avent - Frontend React

Application web React TypeScript permettant aux membres d'une famille de partager un calendrier de l'avent interactif avec upload de photos souvenirs.

**Projet ECF - Emmanuel Chabrier**  
**Formation :** Web et Mobile Developer - AFPA Saint-Jean-de-Védas  
**Date :** Janvier 2026

---

## 📋 Table des matières

- [Vue d'ensemble](#vue-densemble)
- [Technologies](#technologies)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Structure du projet](#structure-du-projet)
- [Fonctionnalités actuelles](#fonctionnalités-actuelles)
- [Architecture](#architecture)
- [Utilisation](#utilisation)
- [Développement](#développement)
- [Prochaines étapes](#prochaines-étapes)

---

## 🎯 Vue d'ensemble

Frontend d'un calendrier de l'avent familial avec système d'authentification multi-tenant innovant :
- **Pas de mot de passe individuel** : authentification par code famille partagé
- **Sélection de profil type Netflix** : chaque membre choisit son avatar
- **24 portes interactives** : une surprise par jour jusqu'à Noël
- **Galerie photos** : souvenirs partagés en famille

---

## 🛠️ Technologies

### **Core**
- **React 18** - Bibliothèque UI
- **TypeScript 5** - Typage statique
- **Vite 5** - Build tool ultra-rapide

### **Routing & State**
- **React Router 6** - Navigation SPA
- **Context API** - Gestion état global (auth)

### **Styling**
- **Tailwind CSS 3** - Framework CSS utility-first
- **PostCSS** - Transformation CSS

### **HTTP & API**
- **Axios** - Client HTTP avec intercepteurs JWT
- **API REST Symfony** - Backend

### **Code Quality**
- **ESLint** - Linter JavaScript/TypeScript
- **Prettier** - Formateur de code

---

## 📦 Prérequis

- **Node.js** >= 18.0.0
- **npm** >= 9.0.0
- **Backend Symfony** fonctionnel sur `http://127.0.0.1:8000`

---

## 🚀 Installation

### **1. Clone le dépôt**
```bash
git clone https://github.com/chabriermanu/calendar_event.git
cd calendar_event/frontend
```

### **2. Installe les dépendances**
```bash
npm install
```

### **3. Lance le serveur de développement**
```bash
npm run dev
```

L'application sera accessible sur : **http://localhost:5173**

---

## ⚙️ Configuration

### **API Backend**

L'URL de l'API est configurée dans `src/api/axios.ts` :
```typescript
baseURL: 'http://127.0.0.1:8000'
```

### **CORS Backend**

Assure-toi que le backend Symfony autorise les requêtes depuis `http://localhost:5173` :
```yaml
# backend/config/packages/nelmio_cors.yaml
nelmio_cors:
    defaults:
        allow_origin: ['http://localhost:5173']
```

---

## 📁 Structure du projet
```
frontend/
├── public/              # Assets statiques
├── src/
│   ├── api/            # Configuration API
│   │   └── axios.ts    # Instance Axios + intercepteurs JWT
│   ├── components/     # Composants réutilisables
│   │   └── ProtectedRoute.tsx
│   ├── context/        # Context API
│   │   └── AuthContext.tsx  # Gestion authentification globale
│   ├── pages/          # Pages de l'application
│   │   ├── LoginPage.tsx           # Code famille
│   │   ├── SelectProfilePage.tsx   # Sélection profil
│   │   └── CalendarPage.tsx        # Calendrier (en cours)
│   ├── types/          # Types TypeScript
│   │   └── index.ts    # Interfaces DTOs backend
│   ├── App.tsx         # Composant racine + routing
│   ├── main.tsx        # Point d'entrée
│   └── index.css       # Styles globaux Tailwind
├── .eslintrc.cjs       # Configuration ESLint
├── tailwind.config.js  # Configuration Tailwind
├── tsconfig.json       # Configuration TypeScript
├── vite.config.ts      # Configuration Vite
└── package.json        # Dépendances npm
```

---

## ✨ Fonctionnalités actuelles

### **✅ Authentification complète**

#### **1. Connexion par code famille**
- Saisie du code partagé (ex: `NOEL2026`)
- Validation backend via `POST /auth/family`
- Récupération des 6 profils membres

#### **2. Sélection de profil (Netflix-style)**
- Affichage de 6 avatars personnalisés
- Nom + âge de chaque membre
- Authentification via `POST /auth/profile`
- Génération JWT stocké dans `localStorage`

#### **3. Routes protégées**
- Redirection automatique si non authentifié
- Vérification token au chargement
- Composant `ProtectedRoute` réutilisable

#### **4. Gestion de session**
- Token JWT persistant (survit au refresh)
- Récupération auto des infos user via `GET /api/me`
- Déconnexion propre (suppression token)

---

## 🏗️ Architecture

### **Pattern Context API**

**AuthContext** gère l'état global d'authentification :
```typescript
interface AuthContextType {
  user: UserMeResponse | null;     // Infos utilisateur
  token: string | null;             // JWT
  login: (token: string) => void;   // Connexion
  logout: () => void;               // Déconnexion
  isAuthenticated: boolean;         // Statut
  loading: boolean;                 // État chargement
}
```

### **Flux d'authentification**
```
1. User entre code famille (NOEL2026)
   ↓
2. POST /auth/family → Récupère 6 profils
   ↓
3. User sélectionne son profil (ex: Papa)
   ↓
4. POST /auth/profile → Génère JWT
   ↓
5. Token stocké dans localStorage
   ↓
6. GET /api/me → Récupère infos complètes user
   ↓
7. Redirect → /calendar
```

### **Intercepteur Axios**

Injection automatique du JWT dans toutes les requêtes :
```typescript
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('jwt_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});
```

---

## 💻 Utilisation

### **Commandes disponibles**
```bash
# Développement
npm run dev              # Lance serveur dev (port 5173)

# Build
npm run build           # Build production dans dist/
npm run preview         # Prévisualise le build

# Linting
npm run lint            # Vérifie le code avec ESLint
```

### **Workflow de test**

1. **Lance le backend** : `symfony server:start` (port 8000)
2. **Lance le frontend** : `npm run dev` (port 5173)
3. **Ouvre le navigateur** : http://localhost:5173
4. **Entre le code** : `NOEL2026`
5. **Sélectionne un profil** : Papa, Maman, etc.
6. **Vérifie le calendrier** : "Bonjour, [pseudo] !"

---

## 🔧 Développement

### **Ajouter une nouvelle page**
```typescript
// 1. Crée src/pages/MaPage.tsx
const MaPage = () => {
  return <div>Ma nouvelle page</div>;
};
export default MaPage;

// 2. Ajoute la route dans App.tsx
<Route path="/ma-page" element={<MaPage />} />
```

### **Utiliser l'authentification**
```typescript
import { useAuth } from './context/AuthContext';

const MonComposant = () => {
  const { user, logout } = useAuth();
  
  return (
    <div>
      <p>Bonjour {user?.pseudo}</p>
      <button onClick={logout}>Déconnexion</button>
    </div>
  );
};
```

### **Appeler l'API**
```typescript
import api from '../api/axios';

const fetchData = async () => {
  try {
    const response = await api.get('/api/endpoint');
    console.log(response.data);
  } catch (error) {
    console.error(error);
  }
};
```

---

## 📅 Prochaines étapes

### **Phase 2 : Calendrier (2-3 semaines)**
- [ ] Composant `Door` (porte individuelle)
- [ ] Composant `DoorGrid` (grille 24 portes)
- [ ] Animation ouverture porte
- [ ] Modal avec contenu (titre, message, image)
- [ ] Gestion des dates (désactivation portes futures)
- [ ] État "déjà ouvert" persistant

### **Phase 3 : Galerie photos (1 semaine)**
- [ ] Page galerie masonry layout
- [ ] Lightbox pour agrandir photos
- [ ] Filtres par porte/date
- [ ] Navigation entre photos

### **Phase 4 : Upload photos (3-4 jours)**
- [ ] Composant drag & drop
- [ ] Prévisualisation avant upload
- [ ] Ajout légende
- [ ] Lien avec porte ouverte

### **Phase 5 : Optimisations (1 semaine)**
- [ ] Lazy loading images
- [ ] Code splitting
- [ ] Tests unitaires (Vitest)
- [ ] Tests E2E (Playwright)
- [ ] Performance Lighthouse > 90

---

## 🎨 Design System

### **Couleurs principales**
```css
/* Login page */
bg-gradient-to-br from-red-700 via-green-700 to-red-700

/* Profile selection */
bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900

/* Calendar */
bg-gradient-to-br from-blue-900 to-purple-900

/* Accents */
text-red-600      /* Titres */
text-yellow-400   /* Hover effects */
```

---

## 🐛 Dépannage

### **Erreur CORS**
```
Access to XMLHttpRequest blocked by CORS policy
```

**Solution :** Configure CORS dans le backend Symfony.

### **Page blanche**

Vérifie que le serveur dev tourne :
```bash
npm run dev
```

### **Token invalide**

Efface le localStorage et reconnecte-toi :
```javascript
localStorage.removeItem('jwt_token');
```

---

## 👨‍💻 Auteur

**Emmanuel Chabrier**  
Étudiant Web et Mobile Developer  
AFPA Saint-Jean-de-Védas  

**GitHub :** [@chabriermanu](https://github.com/chabriermanu)

---

## 📚 Ressources

- [React Documentation](https://react.dev)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [React Router](https://reactrouter.com)
- [Axios](https://axios-http.com)

---

**🎄 Joyeux Noël et bon développement ! 🎅**

---

*Dernière mise à jour : 5 janvier 2026*  
*Version : 0.1.0 (Alpha - Authentification)*
```

---

