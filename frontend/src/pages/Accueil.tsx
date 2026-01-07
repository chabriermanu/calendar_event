import { useNavigate } from "react-router-dom"; 
import { useState, useEffect, useRef } from "react"; 
import "./Accueil.css";

const Accueil = () => {
    const navigate = useNavigate();
    
    // ✅ Audio dans un ref (modifiable sans erreur)
    const audioRef = useRef<HTMLAudioElement | null>(null);

    // ❄️ Flocons générés UNE SEULE FOIS avec useState + fonction d'initialisation
    const [snowflakes] = useState(() => 
        Array.from({ length: 50 }).map((_, i) => ({
            id: i,
            left: `${Math.random() * 100}%`,
            animationDuration: `${Math.random() * 3 + 5}s`,
            animationDelay: `${Math.random() * 5}s`,
            fontSize: `${Math.random() * 10 + 10}px`,
        }))
    );

    useEffect(() => {
        // Initialisation de l'audio
        audioRef.current = new Audio("/sounds/winter-bells-442069.mp3");
        audioRef.current.loop = true; 
        audioRef.current.volume = 0.4;

        // 🧹 Nettoyage
        return () => {
            if (audioRef.current) {
                audioRef.current.pause();
                audioRef.current.src = "";
                audioRef.current = null;
            }
        };
    }, []);

    const startMusicAndNavigate = (path: string) => {
        audioRef.current?.play().catch(() => {
            console.log("Autoplay bloqué, le son démarrera après un clic");
        });
        navigate(path);
    };

    return (
        <div className="accueil-page">
            <div className="snow-background"></div>
            
            <div className="snowflakes" aria-hidden="true">
                {snowflakes.map((flake) => (
                    <div 
                        key={flake.id} 
                        className="snowflake" 
                        style={{
                            left: flake.left,
                            animationDuration: flake.animationDuration,
                            animationDelay: flake.animationDelay,
                            fontSize: flake.fontSize,
                        }}
                    >
                        ❄️
                    </div>
                ))}
            </div>
            
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