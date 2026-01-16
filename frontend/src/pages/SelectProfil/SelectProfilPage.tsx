import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../../api/axios';
import { useAuth } from '../../context/AuthContext';
import type { AuthResponse, FamilyCodeResponse } from '../../types';
import './SelectProfilPage.css';

const SelectProfilPage = () => {
  const [familyData, setFamilyData] = useState<FamilyCodeResponse | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const navigate = useNavigate();
  const { login, logout } = useAuth();

  useEffect(() => {
    const data = sessionStorage.getItem('familyData');
    if (!data) {
      navigate('/');
      return;
    }
    setFamilyData(JSON.parse(data));
  }, [navigate]);

  const handleSelectProfile = async (userId: number) => {
    if (!familyData) return;

    setLoading(true);
    setError('');

    try {
      const response = await api.post<AuthResponse>('/auth/profile', {
        familyId: familyData.familyId,
        userId,
      });

      login(response.data.token);
      sessionStorage.removeItem('familyData');
      navigate('/calendar');
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      setError(err.response?.data?.error || 'Erreur de connexion');
    } finally {
      setLoading(false);
    }
  };

  const handleDisconnect = () => {
    logout();
    sessionStorage.removeItem('familyData');
    navigate('/');
  };

  const handleAddProfile = () => {
    navigate('/create-profil');
  };

  const handleChangeTheme = () => {
    console.log('Changer le thème');
  };

  if (!familyData) return null;

  return (
    <div className="select-profile-container">
      {/* Header */}
      <header className="profile-header">
        <button
          className="back-icon-button"
          onClick={() => navigate('/')}
          aria-label="Retour"
        >
          <img
            src="/icons/icons8-annuler-94.png"
            alt="Retour"
            className="back-icon-img"
          />
        </button>

        <h1 className="header-title">Calendrier de l'avent 2026</h1>

        <button className="disconnect-button" onClick={handleDisconnect}>
          Déconnexion
        </button>
      </header>

      {/* Contenu principal */}
      <div className="profile-content">
        <h2 className="profile-subtitle">Sélectionne Ton Profil</h2>

        {error && <div className="error-message">{error}</div>}

        <div className="profiles-grid">
          {familyData.users.map((user) => (
            <div
              key={user.id}
              className={`profile-card ${loading ? 'loading' : ''}`}
              onClick={() => !loading && handleSelectProfile(user.id)}
              role="button"
              tabIndex={0}
              onKeyPress={(e) => {
                if (e.key === 'Enter' && !loading) {
                  handleSelectProfile(user.id);
                }
              }}
            >
              <div className="profile-avatar">
                <img
                  src={`${import.meta.env.VITE_API_URL}/${user.avatar}`}
                  alt={user.pseudo}
                  onError={(e) => {
                    e.currentTarget.src = '/icons/default-avatar.png';
                  }}
                />
              </div>

              <div className="profile-name">{user.pseudo}</div>
            </div>
          ))}
        </div>
      </div>

      {/* Boutons en bas */}
      <div className="bottom-actions">
        <button
          className="add-profile-button"
          onClick={handleAddProfile}
          aria-label="Ajouter un profil"
        >
          +
        </button>

        <button
          className="theme-button"
          onClick={handleChangeTheme}
          aria-label="Changer de thème"
        >
          🎨
        </button>
      </div>
    </div>
  );
};

export default SelectProfilPage;
