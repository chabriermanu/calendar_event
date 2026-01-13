import { BrowserRouter, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";

// ✅ Import manquant ajouté
import Accueil from "./pages/Acceuil/Accueil";
import CreateFamily from "./pages/CreateFamily/CreateFamily";
import AuthentificationPage from "./pages/Authentification/AuthentificationPage";
import SelectProfilePage from "./pages/SelectProfilePage";
import CalendarPage from "./pages/CalendarPage";

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Accueil />} />
           <Route path="/create-family" element={<CreateFamily />}/>
          <Route path="/authentificationpage" element={<AuthentificationPage />} />
          <Route path="/select-profile" element={<SelectProfilePage />} />
          <Route path="/calendar" element={<CalendarPage />} />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}

export default App;