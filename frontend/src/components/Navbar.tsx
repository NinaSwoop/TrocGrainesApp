import { useContext } from "react";
import { AuthContext } from "../context/AuthContext";
import logo from "../assets/logo.svg";
import userLogo from "../assets/user.svg";
export default function Navbar() {
    const { user, logout } = useContext(AuthContext);

    const handleLogout = async () => {
        try {
            await logout();
            console.log("Déconnexion réussie !");
            window.location.href = "/";
        } catch (error) {
            console.error("Erreur lors de la déconnexion:", error);
        }
    };

    return (
        <nav className="w-full fixed top-0 flex flex-col sm:flex-row justify-between items-center bg-beige p-4 z-50">
            <div className="flex items-center mb-4 sm:mb-0">
                <a href="/" className="flex items-center">
                    <img src={logo} alt="logo" className="h-10 mr-2"/>
                    <p className="text-lg">TROC & GRAINES</p>
                </a>
            </div>
            <div className="flex items-center">
                {user ? (
                    <>
                        <button onClick={handleLogout} className="flex items-center text-green-500">
                            <img src={userLogo} alt="user icon" className="h-10 mr-2"/>
                            Déconnexion
                        </button>
                    </>
                ) : (
                    <button onClick={() => window.location.href = "/login"} className="flex items-center text-green-500">
                        <img src={userLogo} alt="user icon" className="h-10 mr-2"/>
                        <p className="text-lg">Connexion</p>
                    </button>
                )}
            </div>
        </nav>
    );
};