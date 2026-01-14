// src/components/BackgroundMusic/BackgroundMusic.tsx
import { useEffect, useRef, useState } from "react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faVolumeHigh, faVolumeXmark } from '@fortawesome/free-solid-svg-icons';
import "./BackgroundMusic.css";

interface BackgroundMusicProps {
    audioSrc: string;
    volume?: number;
    showControls?: boolean;
}

const BackgroundMusic = ({ 
    audioSrc, 
    volume = 0.4,
    showControls = true 
}: BackgroundMusicProps) => {
    const audioRef = useRef<HTMLAudioElement | null>(null);
    const [isMuted, setIsMuted] = useState(false);
    const [isPlaying, setIsPlaying] = useState(false);

    useEffect(() => {
        audioRef.current = new Audio(audioSrc);
        audioRef.current.loop = true;
        audioRef.current.volume = volume;

        return () => {
            if (audioRef.current) {
                audioRef.current.pause();
                audioRef.current.src = "";
                audioRef.current = null;
            }
        };
    }, [audioSrc, volume]);

    useEffect(() => {
        const handlePlayMusic = () => {
            if (audioRef.current && !isPlaying) {
                audioRef.current.play().catch(() => {
                    console.log("Autoplay bloqué");
                });
                setIsPlaying(true);
            }
        };
        
        window.addEventListener('playBackgroundMusic', handlePlayMusic);
        
        return () => {
            window.removeEventListener('playBackgroundMusic', handlePlayMusic);
        };
    }, [isPlaying]);

    const toggleMute = () => {
        if (audioRef.current) {
            if (isMuted) {
                audioRef.current.volume = volume;
                setIsMuted(false);
            } else {
                audioRef.current.volume = 0;
                setIsMuted(true);
            }
        }
    };

    if (!showControls) return null;

    return (
        <button 
            className={`music-control-button ${isMuted ? 'muted' : ''}`}
            onClick={toggleMute}
            title={isMuted ? "Activer le son" : "Couper le son"}
        >
            
            <FontAwesomeIcon 
                icon={isMuted ? faVolumeXmark : faVolumeHigh} 
                className="speaker-icon-fa"
            />
        </button>
    );
};

export default BackgroundMusic;