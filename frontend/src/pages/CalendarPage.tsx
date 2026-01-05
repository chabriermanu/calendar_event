import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';

const CalendarPage = () => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/');
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-900 to-purple-900 p-8">
      <nav className="flex justify-between items-center mb-8">
        <h1 className="text-3xl font-bold text-white">
          🎄 Calendrier de l'Avent
        </h1>
        <div className="flex items-center space-x-4">
          <span className="text-white">Bonjour, {user?.pseudo} !</span>
          <button
            onClick={handleLogout}
            className="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition"
          >
            Déconnexion
          </button>
        </div>
      </nav>

      <div className="bg-white rounded-2xl p-8 shadow-2xl">
        <h2 className="text-2xl font-bold text-gray-800 mb-4">
          🎅 Bienvenue {user?.pseudo} !
        </h2>
        <p className="text-gray-600 mb-4">
          Le calendrier arrive bientôt... 🎁
        </p>
        <div className="bg-green-50 border border-green-200 rounded-lg p-4">
          <p className="text-green-800 font-medium">
            ✅ Authentification réussie !
          </p>
          <p className="text-green-600 text-sm mt-2">
            Tu es connecté en tant que <strong>{user?.pseudo}</strong> (ID: {user?.id})
          </p>
          <p className="text-green-600 text-sm mt-1">
            Rôles : {user?.roles.join(', ')}
          </p>
        </div>
      </div>
    </div>
  );
};

export default CalendarPage;