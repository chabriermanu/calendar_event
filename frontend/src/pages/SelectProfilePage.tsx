import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import api from '../api/axios';
import type { FamilyCodeResponse, AuthResponse } from '../types';

const SelectProfilePage = () => {
  const [familyData, setFamilyData] = useState<FamilyCodeResponse | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const navigate = useNavigate();
  const { login } = useAuth();

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

  if (!familyData) return null;

  return (
    <div className="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center p-4">
      <div className="w-full max-w-5xl">
        <h1 className="text-4xl md:text-5xl font-bold text-white text-center mb-12">
          Qui regarde ? 🎄
        </h1>

        {error && (
          <div className="bg-red-500 text-white px-4 py-3 rounded-lg mb-8 text-center">
            {error}
          </div>
        )}

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
          {familyData.users.map((user) => (
            <button
              key={user.id}
              onClick={() => handleSelectProfile(user.id)}
              disabled={loading}
              className="group flex flex-col items-center space-y-3 transition-transform hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <div className="relative">
                <div className="w-32 h-32 rounded-lg overflow-hidden border-4 border-transparent group-hover:border-white transition-all">
                  <img
                    src={`https://ui-avatars.com/api/?name=${user.pseudo}&background=random&size=128`}
                    alt={user.pseudo}
                    className="w-full h-full object-cover"
                  />
                </div>
                <div className="absolute -bottom-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-8 h-8 flex items-center justify-center">
                  {user.age}
                </div>
              </div>
              <span className="text-white font-medium text-lg group-hover:text-yellow-400 transition-colors">
                {user.pseudo}
              </span>
            </button>
          ))}
        </div>

        <div className="text-center mt-12">
          <button
            onClick={() => navigate('/')}
            className="text-gray-400 hover:text-white transition-colors"
          >
            ← Changer de code famille
          </button>
        </div>
      </div>
    </div>
  );
};

export default SelectProfilePage;