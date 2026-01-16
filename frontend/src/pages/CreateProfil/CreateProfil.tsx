import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Snowfall from "../../components/Snowfall/Snowfall"
import api from '../../api/axios';
import './CreateProfil.css';

interface FamilyMember {
  id: number;
  firstName: string;
  avatar: string;
  age: number;
}

interface AddMemberResponse {
  success: boolean;
  memberId: number;
  message: string;
}

interface FamilyMembersResponse {
  members: FamilyMember[];
}

// Interface pour les thèmes
interface Theme {
  id: number | string;  // Peut être number (API) ou string (fallback)
  name: string;
  icon: string;
  code?: string;  // Optionnel : code comme 'montagne', 'village'
}

interface ThemesResponse {
  themes: Theme[];
}

const AddMember = () => {
  const navigate = useNavigate();
  
  // États du formulaire
  const [firstName, setFirstName] = useState('');
  const [age, setAge] = useState<number>(0);
  const [selectedAvatar, setSelectedAvatar] = useState<'boy' | 'girl'>('boy');
  const [currentTheme, setCurrentTheme] = useState('Montagne');
  const [parentEmail, setParentEmail] = useState('');
  const [acceptCGU, setAcceptCGU] = useState(false);
  const [parentalAuth, setParentalAuth] = useState(false);
  const [showThemeModal, setShowThemeModal] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  // Membres existants (récupérés depuis l'API)
  const [existingMembers, setExistingMembers] = useState<FamilyMember[]>([]);

  // État pour les thèmes avec type défini
  const [themes, setThemes] = useState<Theme[]>([]);

  // Récupérer l'ID de la famille depuis sessionStorage ou localStorage
  const familyData = JSON.parse(sessionStorage.getItem('familyData') || '{}');
  const familyId = familyData.familyId;

  // Charger les membres existants au montage du composant
  useEffect(() => {
    const fetchMembers = async () => {
      try {
        const response = await api.get<FamilyMembersResponse>(`/family/${familyId}/members`);
        setExistingMembers(response.data.members);
        // eslint-disable-next-line @typescript-eslint/no-explicit-any 
      } catch (err: any) {
        console.error('Erreur lors du chargement des membres:', err);
        setError('Impossible de charger les membres de la famille');
      }
    };

    if (familyId) {
      fetchMembers();
    }
  }, [familyId]);

  // Charger les thèmes depuis l'API au montage
  useEffect(() => {
    const fetchThemes = async () => {
      try {
        const response = await api.get<ThemesResponse>('/themes');
        setThemes(response.data.themes);
      
      // eslint-disable-next-line @typescript-eslint/no-explicit-any   
      } catch (err: any) {
        console.error('Erreur chargement thèmes:', err);
        // Fallback sur des thèmes par défaut si l'API échoue
        setThemes([
          { id: 1, name: 'Montagne', icon: '🏔️', code: 'montagne' },
          { id: 2, name: 'Village', icon: '🏘️', code: 'village' },
          { id: 3, name: 'Moderne', icon: '🌃', code: 'moderne' },
          { id: 4, name: 'Cosy', icon: '🔥', code: 'cosy' },
          { id: 5, name: 'Traditionnel', icon: '🕯️', code: 'traditionnel' },
        ]);
      }
    };
    fetchThemes();
  }, []);

  // Fonction de soumission du formulaire
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    
    // Validation
    if (!firstName.trim()) {
      setError('Veuillez entrer un prénom');
      return;
    }
    
    if (age <= 0) {
      setError('Veuillez entrer un âge valide');
      return;
    }

    if (age < 18 && !parentEmail.trim()) {
      setError('L\'email des parents est requis pour les mineurs');
      return;
    }
    
    if (!acceptCGU) {
      setError('Vous devez accepter la politique de confidentialité et les CGU');
      return;
    }

    if (age < 15 && !parentalAuth) {
      setError('L\'autorisation parentale est requise pour les moins de 15 ans');
      return;
    }

    setLoading(true);

    try {
      const newMemberData = {
        firstName: firstName.trim(),
        age,
        avatar: selectedAvatar,
        theme: currentTheme,
        parentEmail: age < 18 ? parentEmail.trim() : null,
        familyId
      };

      const response = await api.post<AddMemberResponse>(
        `/family/${familyId}/members`,
        newMemberData
      );

      if (response.data.success) {
        // Succès - redirection vers la page de sélection de profils
        alert(`${firstName} a été ajouté à la famille avec succès !`);
        navigate('/select-profile');
      }
     // eslint-disable-next-line @typescript-eslint/no-explicit-any  
    } catch (err: any) {
      console.error('Erreur lors de l\'ajout du membre:', err);
      setError(err.response?.data?.error || 'Erreur lors de l\'ajout du membre');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="add-member-page">
      {/* Fond avec flocons */}
      <Snowfall snowflakeCount={50} />

      {/* En-tête avec titre */}
      <div className="page-header">
        <h1 className="page-title">Calendrier de l'avent 2026</h1>
        <button className="disconnect-btn" onClick={() => navigate('/')}>
          SE DÉCONNECTER
        </button>
      </div>

      {/* Profils existants en haut */}
      <div className="existing-profiles-section">
        <p className="section-subtitle">Sélectionne ton profil</p>
        <div className="profiles-grid">
          {existingMembers.map((member) => (
            <div key={member.id} className="profile-circle">
              <div className="avatar-circle">
                <span className="avatar-emoji">{member.avatar}</span>
              </div>
              <p className="profile-name">{member.firstName}</p>
            </div>
          ))}
        </div>
      </div>

      {/* Flèche vers le bas */}
      <div className="arrow-down">
        <div className="add-icon">➕</div>
      </div>

      {/* Section "Ajouter un membre" */}
      <div className="add-section-title">
        <h2>Ajouter un membre</h2>
      </div>

      {/* Formulaire */}
      <div className="form-container">
        <div className="form-card">
          <h3 className="form-title">Nouveau membre</h3>

          <form onSubmit={handleSubmit}>
            {/* Message d'erreur */}
            {error && (
              <div className="error-message">
                ⚠️ {error}
              </div>
            )}

            {/* Prénom et Âge */}
            <div className="form-row">
              <div className="form-group">
                <label htmlFor="firstName">Prénom</label>
                <input
                  type="text"
                  id="firstName"
                  placeholder="Prénom"
                  value={firstName}
                  onChange={(e) => setFirstName(e.target.value)}
                  required
                />
              </div>

              <div className="form-group small">
                <label htmlFor="age">Âge</label>
                <div className="age-input-wrapper">
                  <input
                    type="number"
                    id="age"
                    min="0"
                    max="120"
                    value={age || ''}
                    onChange={(e) => setAge(parseInt(e.target.value) || 0)}
                    required
                  />
                  <span className="age-icon">🎂</span>
                </div>
              </div>
            </div>

            {/* Avatar */}
            <div className="form-group">
              <label>Avatar</label>
              <div className="avatar-selection">
                <button
                  type="button"
                  className={`avatar-btn ${selectedAvatar === 'boy' ? 'selected' : ''}`}
                  onClick={() => setSelectedAvatar('boy')}
                >
                  👦
                </button>
                <button
                  type="button"
                  className={`avatar-btn ${selectedAvatar === 'girl' ? 'selected' : ''}`}
                  onClick={() => setSelectedAvatar('girl')}
                >
                  👧
                </button>
              </div>
            </div>

            {/* Thème */}
            <div className="form-group">
              <div className="theme-display">
                <span>Décor actuel : 🏔️ {currentTheme}</span>
                <button
                  type="button"
                  className="change-theme-btn"
                  onClick={() => setShowThemeModal(true)}
                >
                  Changer ⬇️
                </button>
              </div>
            </div>

            {/* Email des parents (si mineur) */}
            {age < 18 && (
              <div className="form-group">
                <label htmlFor="parentEmail">
                  Email des parents (si moins de 18 ans)
                </label>
                <input
                  type="email"
                  id="parentEmail"
                  placeholder="parent@exemple.com"
                  value={parentEmail}
                  onChange={(e) => setParentEmail(e.target.value)}
                  required={age < 18}
                />
              </div>
            )}

            {/* Checkboxes */}
            <div className="checkbox-group">
              <label className="checkbox-label">
                <input
                  type="checkbox"
                  checked={acceptCGU}
                  onChange={(e) => setAcceptCGU(e.target.checked)}
                  required
                />
                <span>J'accepte la politique de confidentialité et les CGU*</span>
              </label>

              {age < 15 && (
                <label className="checkbox-label">
                  <input
                    type="checkbox"
                    checked={parentalAuth}
                    onChange={(e) => setParentalAuth(e.target.checked)}
                    required
                  />
                  <span>En tant que parent, j'autorise la création pour enfant {'<'} 15 ans*</span>
                </label>
              )}
            </div>

            {/* Bouton de soumission */}
            <button 
              type="submit" 
              className="submit-btn"
              disabled={loading}
            >
              {loading ? 'AJOUT EN COURS...' : 'Ajouter un membre'}
            </button>
          </form>
        </div>
      </div>

      {/* Modal de sélection de thème */}
      {showThemeModal && (
        <div className="modal-overlay" onClick={() => setShowThemeModal(false)}>
          <div className="theme-modal" onClick={(e) => e.stopPropagation()}>
            <h3>Choisir un décor</h3>
            <div className="themes-grid">
              {themes.map((theme) => (
                <button
                  key={theme.id}
                  className={`theme-option ${currentTheme === theme.name ? 'selected' : ''}`}
                  onClick={() => {
                    setCurrentTheme(theme.name);
                    setShowThemeModal(false);
                  }}
                >
                  <span className="theme-icon">{theme.icon}</span>
                  <span className="theme-name">{theme.name}</span>
                </button>
              ))}
            </div>
            <button className="close-modal-btn" onClick={() => setShowThemeModal(false)}>
              Fermer
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default AddMember;