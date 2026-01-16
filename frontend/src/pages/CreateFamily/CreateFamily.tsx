import { AxiosError } from 'axios';
import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../../api/axios';
import {
  get2RandomAvatarsByAge,
  getAgeCategory,
} from '../../components/Avatarconfig';
import Snowfall from '../../components/Snowfall/Snowfall';
import './CreateFamily.css';

interface Theme {
  id: number;
  name: string;
  backgroundImage: string;
  primaryColor: string;
  secondaryColor: string;
  musicUrl: string | null;
  videoUrl: string | null;
  description: string;
}

const CreateFamily: React.FC = () => {
  const navigate = useNavigate();

  // États du formulaire principal
  const [familyName, setFamilyName] = useState('');
  const [familyCode, setFamilyCode] = useState('');
  const [adminEmail, setAdminEmail] = useState('');

  // États pour le profil admin
  const [adminFirstName, setAdminFirstName] = useState('');
  const [adminAge, setAdminAge] = useState('');
  const [selectedAvatar, setSelectedAvatar] = useState<string>('');

  // États pour les thèmes et validation
  const [themes, setThemes] = useState<Theme[]>([]);
  const [selectedTheme, setSelectedTheme] = useState<number | null>(null);
  const [acceptCGU, setAcceptCGU] = useState(false);
  const [parentalAuth, setParentalAuth] = useState(false);

  // États pour le chargement et les erreurs
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState('');

  // Calcul des avatars disponibles selon l'âge
  const age = adminAge ? parseInt(adminAge) : null;
  const isValidAge = age !== null && !isNaN(age) && age >= 0;
  const availableAvatars = isValidAge ? get2RandomAvatarsByAge(age) : [];
  const ageCategory = isValidAge ? getAgeCategory(age) : '';
  const showAvatarSelection = isValidAge && availableAvatars.length > 0;

  // Charger les thèmes depuis l'API
  useEffect(() => {
    const fetchThemes = async () => {
      try {
        const response = await api.get<Theme[]>('/api/themes');
        setThemes(response.data);

        if (response.data.length > 0) {
          setSelectedTheme(response.data[0].id);
        }
      } catch (error) {
        console.error('Erreur lors du chargement des thèmes:', error);
        setError(
          'Impossible de charger les thèmes. Vérifiez que le serveur est lancé.'
        );
      }
    };

    fetchThemes();
  }, []);

  // Réinitialiser l'avatar quand l'âge change
  const handleAgeChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setAdminAge(e.target.value);
    setSelectedAvatar('');
  };

  // Générer un code famille aléatoire
  const generateFamilyCode = () => {
    const code = 'Noel' + Math.floor(Math.random() * 9000 + 1000);
    setFamilyCode(code);
  };

  // Sélection d'avatar
  const handleAvatarSelect = (avatarPath: string) => {
    setSelectedAvatar(avatarPath);
  };

  // Envoi au backend Symfony
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');

    // Validation
    if (
      !familyName ||
      !familyCode ||
      !adminEmail ||
      !adminFirstName ||
      !adminAge ||
      !selectedTheme ||
      !selectedAvatar
    ) {
      setError('Veuillez remplir tous les champs obligatoires');
      return;
    }

    if (!acceptCGU) {
      setError(
        'Vous devez accepter la politique de confidentialité et les CGU'
      );
      return;
    }

    setIsLoading(true);

    try {
      const response = await api.post('/api/family/register', {
        familyName,
        familyCode,
        adminEmail,
        admin: {
          firstName: adminFirstName,
          age: parseInt(adminAge),
          avatar: selectedAvatar,
          themeId: selectedTheme,
        },
        acceptCGU,
        parentalAuth,
      });

      if (response.data.success) {
        localStorage.setItem('familyCode', familyCode);
        localStorage.setItem('familyId', response.data.familyId.toString());

        if (response.data.token) {
          localStorage.setItem('jwt_token', response.data.token);
        }

        alert('🎄 Famille créée avec succès !');
        navigate('/authentificationpage');
      } else {
        setError(
          response.data.message || 'Une erreur est survenue lors de la création'
        );
      }
    } catch (error) {
      console.error('Erreur:', error);

      if (error instanceof AxiosError) {
        if (error.response) {
          setError(
            error.response.data.message ||
              'Une erreur est survenue côté serveur'
          );
        } else if (error.request) {
          setError(
            'Impossible de contacter le serveur. Vérifiez que Symfony est bien lancé.'
          );
        } else {
          setError('Une erreur inattendue est survenue');
        }
      } else {
        setError('Une erreur inattendue est survenue');
      }
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="create-family-page">
      <div className="snow-background"></div>
      <Snowfall snowflakeCount={50} />

      <div className="form-container">
        <div className="form-header">
          <button
            className="back-icon-button"
            onClick={() => navigate('/')}
            aria-label="Retour à l'accueil"
          >
            <img
              src="/icons/icons8-annuler-94.png"
              alt="Retour"
              className="back-icon-img"
            />
          </button>
          <h1 className="form-title">Créer votre calendrier Familial</h1>
        </div>

        {error && <div className="error-message">⚠️ {error}</div>}

        <form onSubmit={handleSubmit} className="family-form">
          {/* Nom de la famille */}
          <div className="form-group">
            <label htmlFor="familyName">Nom de votre famille</label>
            <input
              type="text"
              id="familyName"
              placeholder="Ex: Famille Dupont"
              value={familyName}
              onChange={(e) => setFamilyName(e.target.value)}
              required
              disabled={isLoading}
            />
          </div>

          {/* Code famille avec bouton générer */}
          <div className="form-group">
            <label htmlFor="familyCode">Code famille</label>
            <div className="code-input-group">
              <input
                type="text"
                id="familyCode"
                placeholder="Ex: Noel2026"
                value={familyCode}
                onChange={(e) => setFamilyCode(e.target.value)}
                required
                disabled={isLoading}
              />
              <button
                type="button"
                className="generate-btn"
                onClick={generateFamilyCode}
                title="Générer un code"
                disabled={isLoading}
              >
                🔄
              </button>
            </div>
          </div>

          {/* Email administrateur */}
          <div className="form-group">
            <label htmlFor="adminEmail">Email administrateur</label>
            <input
              type="email"
              id="adminEmail"
              placeholder="Ex: votre.email@exemple.com"
              value={adminEmail}
              onChange={(e) => setAdminEmail(e.target.value)}
              required
              disabled={isLoading}
            />
          </div>

          {/* Section Premier profil (Admin) */}
          <div className="admin-section">
            <h2 className="section-title">Premier profil (Admin)</h2>

            {/* Prénom + Âge sur la même ligne */}
            <div className="form-row">
              <div className="form-group half">
                <label htmlFor="adminFirstName">Prénom</label>
                <input
                  type="text"
                  id="adminFirstName"
                  placeholder="Prénom"
                  value={adminFirstName}
                  onChange={(e) => setAdminFirstName(e.target.value)}
                  required
                  disabled={isLoading}
                />
              </div>

              <div className="form-group half">
                <label htmlFor="adminAge">Âge</label>
                <input
                  type="number"
                  id="adminAge"
                  placeholder="0"
                  min="0"
                  max="120"
                  value={adminAge}
                  onChange={handleAgeChange}
                  required
                  disabled={isLoading}
                />
              </div>
            </div>

            {/* Sélection d'avatar par âge */}
            {showAvatarSelection && availableAvatars.length > 0 && (
              <div className="form-group">
                <label>
                  Avatar <span className="age-category">({ageCategory})</span>
                </label>
                <div className="avatar-grid">
                  {availableAvatars.map((avatar) => (
                    <div
                      key={avatar.id}
                      className={`avatar-option ${
                        selectedAvatar === avatar.path ? 'selected' : ''
                      }`}
                      onClick={() => handleAvatarSelect(avatar.path)}
                    >
                      <img src={avatar.path} alt={avatar.label} />
                      <p>{avatar.label}</p>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* Sélection de thème */}
            <div className="form-group">
              <label htmlFor="theme">Décor</label>
              <select
                id="theme"
                value={selectedTheme || ''}
                onChange={(e) => setSelectedTheme(parseInt(e.target.value))}
                disabled={isLoading || themes.length === 0}
                required
              >
                {themes.length === 0 ? (
                  <option value="">Chargement des thèmes...</option>
                ) : (
                  themes.map((theme) => (
                    <option key={theme.id} value={theme.id}>
                      {theme.description}
                    </option>
                  ))
                )}
              </select>
            </div>
          </div>

          {/* Checkboxes CGU */}
          <div className="checkbox-group">
            <label className="checkbox-label">
              <input
                type="checkbox"
                checked={acceptCGU}
                onChange={(e) => setAcceptCGU(e.target.checked)}
                required
                disabled={isLoading}
              />
              <span>J'accepte la politique de confidentialité et les CGU*</span>
            </label>

            <label className="checkbox-label">
              <input
                type="checkbox"
                checked={parentalAuth}
                onChange={(e) => setParentalAuth(e.target.checked)}
                disabled={isLoading}
              />
              <span>
                En tant que parent, j'autorise la création pour enfant &lt; 15
                ans*
              </span>
            </label>
          </div>

          {/* Bouton de soumission */}
          <button type="submit" className="submit-btn" disabled={isLoading}>
            {isLoading ? '⏳ Création en cours...' : 'Créer ma Famille'}
          </button>
        </form>
      </div>
    </div>
  );
};

export default CreateFamily;
