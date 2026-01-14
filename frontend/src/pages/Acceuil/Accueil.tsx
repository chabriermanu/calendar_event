// src/pages/Accueil/Accueil.tsx
import { useNavigate } from "react-router-dom";  
import Snowfall from "../../components/Snowfall/Snowfall";
import "./Accueil.css";

const Accueil = () => {
    const navigate = useNavigate();


    const startMusicAndNavigate = (path: string) => {
        window.dispatchEvent(new Event('playBackgroundMusic'));
        navigate(path);
    };
    return (
        <div className="accueil-page">
            <div className="snow-background"></div>
            
            <Snowfall snowflakeCount={50} />
            
            <div className="content">
                <h1 className="title">🎄 Bienvenue dans la magie de Noël 2026</h1>
                <p className="subtitle">Créez des souvenirs inoubliables avec votre famille</p>
                
                <div className="button-group">
                    <button 
                        className="action-button"
                        onClick={() => startMusicAndNavigate("/create-family")}
                    >
                        🏠 Créer une nouvelle famille
                    </button>
                    
                    <button 
                        className="action-button"
                        onClick={() => startMusicAndNavigate("/authentificationpage")}
                    >
                        🔑 Se connecter
                        <br />
                        <span className="small-text">(J'ai déjà un code famille)</span>
                    </button>
                </div>
            </div>
        </div>
    );
};

export default Accueil;