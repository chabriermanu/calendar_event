import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../api/axios";
import { AxiosError } from "axios";
import "./CreateFamily.css";
import Snowfall from "../../components/Snowfall/Snowfall";

/// <reference types="react" /> 

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

const CreateFamily = () => {
    const navigate = useNavigate();
    
    // États du formulaire
    const [familyName, setFamilyName] = useState("");
    const [familyCode, setFamilyCode] = useState("");
    const [adminEmail, setAdminEmail] = useState("");
    const [adminFirstName, setAdminFirstName] = useState("");
    const [adminAge, setAdminAge] = useState("");
    const [selectedAvatar, setSelectedAvatar] = useState("boy");
    const [acceptCGU, setAcceptCGU] = useState(false);
    const [parentalAuth, setParentalAuth] = useState(false);
    
    // États pour les thèmes
    const [themes, setThemes] = useState<Theme[]>([]);
    const [selectedTheme, setSelectedTheme] = useState<number | null>(null);

    // États pour le chargement et les erreurs
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState("");

    // ✨ Charger les thèmes depuis l'API au montage du composant
    useEffect(() => {
        const fetchThemes = async () => {
            try {
                const response = await api.get<Theme[]>('/api/themes');
                setThemes(response.data);
                
                // Sélectionner le premier thème par défaut
                if (response.data.length > 0) {
                    setSelectedTheme(response.data[0].id);
                }
            } catch (error) {
                console.error("Erreur lors du chargement des thèmes:", error);
                setError("Impossible de charger les thèmes. Vérifiez que le serveur est lancé.");
            }
        };
        
        fetchThemes();
    }, []);

    // Générer un code famille aléatoire
    const generateFamilyCode = () => {
        const code = "Noel" + Math.floor(Math.random() * 9000 + 1000);
        setFamilyCode(code);
    };

    // 🚀 Envoi au backend Symfony avec axios
    
    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError("");
        
        // Validation basique
        if (!familyName || !familyCode || !adminEmail || !adminFirstName || !adminAge || !selectedTheme) {
            setError("Veuillez remplir tous les champs obligatoires");
            return;
        }
        
        if (!acceptCGU) {
            setError("Vous devez accepter la politique de confidentialité et les CGU");
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
                    themeId: selectedTheme  // ✅ Envoyer l'ID du thème
                },
                acceptCGU,
                parentalAuth
            });

            if (response.data.success) {
                localStorage.setItem('familyCode', familyCode);
                localStorage.setItem('familyId', response.data.familyId.toString());
                
                if (response.data.token) {
                    localStorage.setItem('jwt_token', response.data.token);
                }
                
                alert("🎄 Famille créée avec succès !");
                navigate("/authentificationpage");
            } else {
                setError(response.data.message || "Une erreur est survenue lors de la création");
            }
             
        } catch (error) {
            console.error("Erreur:", error);
            
            if (error instanceof AxiosError) {
                if (error.response) {
                    setError(error.response.data.message || "Une erreur est survenue côté serveur");
                } else if (error.request) {
                    setError("Impossible de contacter le serveur. Vérifiez que Symfony est bien lancé.");
                } else {
                    setError("Une erreur inattendue est survenue");
                }
            } else {
                setError("Une erreur inattendue est survenue");
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
                    <button className="back-icon-button" onClick={() => navigate('/')} aria-label="Retour à l'accueil" >
                        <img src="/icons/icons8-annuler-94.png" alt="Retour" className="back-icon-img" />
                    </button>
                    <h1 className="form-title">Créer votre calendrier Familial</h1>
                </div>
                {error && (
                    <div className="error-message">
                        ⚠️ {error}
                    </div>
                )}
                
                <form onSubmit={handleSubmit} className="family-form">
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

                    <div className="admin-section">
                        <h2 className="section-title">Premier profil (Admin)</h2>
                        
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
                                    onChange={(e) => setAdminAge(e.target.value)}
                                    required
                                    disabled={isLoading}
                                />
                            </div>
                        </div>

                        <div className="form-group">
                            <label>Avatar</label>
                            <div className="avatar-selection">
                                <button
                                    type="button"
                                    className={`avatar-btn ${selectedAvatar === 'boy' ? 'selected' : ''}`}
                                    onClick={() => setSelectedAvatar('boy')}
                                    disabled={isLoading}
                                >
                                    👦
                                </button>
                                <button
                                    type="button"
                                    className={`avatar-btn ${selectedAvatar === 'girl' ? 'selected' : ''}`}
                                    onClick={() => setSelectedAvatar('girl')}
                                    disabled={isLoading}
                                >
                                    👧
                                </button>
                            </div>
                        </div>

                        {/* Thème de décor - DYNAMIQUE depuis l'API */}
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
                            <span>En tant que parent, j'autorise la création pour enfant &lt; 15 ans*</span>
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        className="submit-btn"
                        disabled={isLoading}
                    >
                        {isLoading ? "⏳ Création en cours..." : "Créer ma Famille"}
                    </button>
                </form>
            </div>
        </div>
    );
};


export default CreateFamily;