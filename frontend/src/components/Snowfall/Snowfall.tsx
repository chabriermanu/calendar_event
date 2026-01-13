// src/components/Snowfall/Snowfall.tsx
import { useState } from "react";
import "./Snowfall.css";

interface SnowfallProps {
    snowflakeCount?: number;
}

const Snowfall = ({ snowflakeCount = 50 }: SnowfallProps) => {
    // ❄️ Flocons générés UNE SEULE FOIS avec useState + fonction d'initialisation
    const [snowflakes] = useState(() => 
        Array.from({ length: snowflakeCount }).map((_, i) => ({
            id: i,
            left: `${Math.random() * 100}%`,
            animationDuration: `${Math.random() * 3 + 5}s`,
            animationDelay: `${Math.random() * 5}s`,
            fontSize: `${Math.random() * 10 + 10}px`,
        }))
    );

    return (
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
    );
};

export default Snowfall;