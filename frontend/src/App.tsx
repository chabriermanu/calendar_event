import { BrowserRouter, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import BackgroundMusic from "./components/BackgroundMusic/BackgroundMusic"; 

// ✅ Import manquant ajouté
import Accueil from "./pages/Acceuil/Accueil";
import CreateFamily from "./pages/CreateFamily/CreateFamily";
import CreateProfil from "./pages/CreateProfil/CreateProfil";
import AuthentificationPage from "./pages/Authentification/AuthentificationPage";
import SelectProfilePage from "./pages/SelectProfil/SelectProfilPage";
import CalendarPage from "./pages/Calendar/CalendarPage";
import DefisPage from "./pages/Defis/DefisPage";
import ProfilPage from "./pages/Profil/ProfilPage"
import GaleriePage from "./pages/Galerie/GaleriePage";

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <BackgroundMusic audioSrc="/sounds/winter-bells-442069.mp3" volume={0.4} showControls={true} />
        <Routes>
          <Route path="/" element={<Accueil />} />
          <Route path="/Create-family" element={<CreateFamily />}/>
          <Route path="/Create-profil" element={<CreateProfil/>}/>
          <Route path="/authentificationpage" element={<AuthentificationPage />} />
          <Route path="/select-profile" element={<SelectProfilePage />} />
          <Route path="/calendar" element={<CalendarPage />} />
          <Route path="/Defis" element={<DefisPage />}/>
          <Route path="/Profil" element={<ProfilPage/>}/>
          <Route path="/Galerie"element={<GaleriePage/>}/>

        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}

export default App;