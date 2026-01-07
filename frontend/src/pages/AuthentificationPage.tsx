import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../api/axios';
import type { FamilyCodeResponse } from '../types';
import './AuthentificationPage.css';

const LoginPage = () => {
  const [code, setCode] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  // Musique
  const [audio] = useState(new Audio('/sounds/winter-bells-442069.mp3'));

  useEffect(() => {
    audio.loop = true;
    audio.volume = 0.4;
  }, [audio]);

  const startMusic = () => {
    audio.play().catch(() => {
      console.log("Autoplay bloqué, mais le son démarrera après un clic");
    });
  };

  // FORMULAIRE
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const response = await api.post<FamilyCodeResponse>('/auth/family', {
        code: code.toUpperCase(),
      });

      // 🔥 Le son démarre ici, après interaction utilisateur
      startMusic();

      sessionStorage.setItem('familyData', JSON.stringify(response.data));
      navigate('/select-profile');
// eslint-disable-next-line @typescript-eslint/no-explicit-any 
    } catch (err: any) {
      setError(err.response?.data?.error || 'Code famille invalide');
    } finally {
      setLoading(false);
    }
  };

  // NEIGE
  const generateSnowFlakes = () => {
    const snowflakes = [];
    for (let i = 0; i < 50; i++) {
      const style = {
        left: `${Math.random() * 100}%`,
        animationDuration: `${Math.random() * 3 + 5}s`,
        animationDelay: `${Math.random() * 5}s`,
        fontSize: `${Math.random() * 10 + 10}px`,
      };
      snowflakes.push(
        <div key={i} className="snowflake" style={style}>
          ❄️
        </div>
      );
    }
    return snowflakes;
  };

  return (
    <div className="login-page">
      <header className="login-header">
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

        <h1>Bienvenue dans la magie de Noël 2026</h1>
        <p>Créez des souvenir inoubliable avec votre famille</p>
      </header>

      <div className="snow-background"></div>

      <div className="snowflakes" aria-hidden="true">
        {generateSnowFlakes()}
      </div>

      <div className="login-container">
        <div className="login-card">
          <h2 className="login-title">Calendrier de l'Avent 2026</h2>

          <form onSubmit={handleSubmit} className="login-form">
            <h3>Connectez-vous</h3>
            <label>Entrez le code Famille</label>

            <input
              type="text"
              value={code}
              onChange={(e) => setCode(e.target.value)}
              placeholder="ex: NOEL2026"
              className="code-input"
              required
              maxLength={10}
            />

            {error && <div className="error-message">{error}</div>}

            <button type="submit" disabled={loading} className="submit-button">
              {loading ? 'Vérification...' : 'Valider'}
            </button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default LoginPage;
