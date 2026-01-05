import { createContext, useContext, useState, useEffect } from 'react';
import type { ReactNode } from 'react';
import api from '../api/axios';
import type { UserMeResponse } from '../types';


interface AuthContextType {

// Contient les infos de l’utilisateur connecté (id, email, rôle, etc.) vient du backend.
// Peut être null si l’utilisateur n’est pas connecté ou si les données ne sont pas encore chargées
//  C’est l’objet que tu affiches dans ton UI

    user: UserMeResponse | null; 

// token: string | null : Contient le JWT stocké après login, null si l’utilisateur n’est pas connecté.
// Sert à authentifier les requêtes API.C’est ce que tu mets dans Authorization: Bearer <token>.

    token: string | null;


// fonction qui sert à enregistrer le token, mettre a jour l'etat globla, declencher le chargement du User
// appeller après un login réussi "login(response.data.token)"";

    login: (token: string) => void;

// fonction supprime le token, remettre user à null, nettoyer localstorage.
// appeller quand l’utilisateur clique sur “Déconnexion”.

    logout: () => void;

// true si un token existe sinon false

    isAuthenticated: boolean;

// vérifier le token, charger les infos utilisateur, initialiser l’état
// Très utile pour afficher un spinner au démarrage.

    loading: boolean;
}

// contexte React qui va contenir toutes les infos d’authentification.
// le contexte peut être undefined si on l’utilise en dehors du provider (ce qui permet d’afficher une erreur propre).

const AuthContext = createContext<AuthContextType | undefined>(undefined);

//C’est le composant qui va envelopper toute ton application. Il fournit les valeurs du contexte à tous les composants enfants.

export const AuthProvider = ({ children }: { children: ReactNode }) => {

    //contient les infos de l’utilisateur connecté. Null si pas connecté ou pas encore chargé.

    const [user, setUser] = useState<UserMeResponse | null>(null);

    // Contient le JWT.Initialisé depuis le localStorage → permet de rester connecté après un refresh.

    const [token, setToken] = useState<string | null>(localStorage.getItem('jwt_token'));

    // Indique si le contexte est en train de charger les infos utilisateur. Très utile pour afficher un spinner au démarrage.

    const [loading, setLoading] = useState(true);

 // s’exécute à chaque fois que le token change.  pas de token → pas besoin d’appeler l’API → user = null.
 // token existe → il appelle /api/me pour récupérer les infos utilisateur.
 // Si l’API renvoie une erreur → token invalide → on déconnecte l’utilisateur.
 // Dans tous les cas → loading passe à false.
 // app sait automatiquement si l’utilisateur est connecté ou non.

    useEffect(() => {
        const fetchUser = async () => {
            if (!token) {
                setUser(null);
                setLoading(false);
                return;
            }

            try {
                const response = await api.get<UserMeResponse>('/api/me');
                setUser(response.data);
            } catch (error) {
                console.error('Erreur récupération user :', error);
                logout();
            } finally {
                setLoading(false);
            }
        };

        fetchUser();
    }, [token]);



// Stocke le token dans le localStorage.
// Met à jour l’état token.
// Ce changement déclenche automatiquement fetchUser() grâce au useEffect.

    const login = (newToken: string) => {
        localStorage.setItem('jwt_token', newToken);
        setToken(newToken);
    };

// Supprime le token du localStorage. Réinitialise token et user. L’utilisateur est immédiatement déconnecté.

    const logout = () => {
        localStorage.removeItem('jwt_token');
        setToken(null);
        setUser(null);
    };

    return (

// Valeurs fournies au contexte

        <AuthContext.Provider
            value={{
                user,
                token,
                login,
                logout,
                isAuthenticated: !!token,
                loading,
            }}
        >
            {children}
        </AuthContext.Provider>
    );
};
// eslint-disable-next-line react-refresh/only-export-components
export const useAuth = () => {

//Il récupère la valeur du contexte AuthContext.
    const context = useContext(AuthContext);

    // vérification si quelqu’un utilise useAuth() en dehors du <AuthProvider>,
    // createContext(AuthContextType | undefined) peut retourner undefined, 
    // dangereux (composant non protégé, crash silencieux, etc.)
    // forces React à crasher proprement avec un message clair.

    if (!context) {
        throw new Error('useAuth must be used within AuthProvider');
    }

    // toutes les valeurs du contexte. 
    
    return context;
};
