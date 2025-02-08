import { useContext } from "react";
import { AuthContext } from "../context/AuthContext";
import logo from "../assets/logo.svg";
import userLogo from "../assets/user.svg";
import helpdeskLogo from "../assets/helpdesk.svg";
import leaveLogo from "../assets/leave.svg";
import placeholder from "../assets/placeholder-user.webp";
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
        <nav className="bg-amber-500 p-4 hidden md:block">
            <div className="flex justify-between">
                <div className="">
                    <a href="/" className="flex items-center">
                        <img src={logo} alt="logo" className="h-10"/>
                        <p className="text-l">TROC & GRAINES</p>
                    </a>
                </div>
                <div className="flex items-center">
                    <div className="flex items-center">
                        <div className="flex items-center">
                            {user ? (
                                <button onClick={() => window.location.href = "/profile"} className="flex items-center green-darker">
                                    <p className="text-m mr-2">{user.username}</p>
                                    <img src={placeholder} alt="avatar of plant" className="h-10 mr-8 cursor-pointer aspect-square rounded-4xl"/>
                                </button>
                            ) : (
                                ""
                            )}
                        </div>
                        <div className="">
                            {user ? (
                                    <button onClick={() => window.location.href = "/help_points"} className="flex items-center green-darker">
                                        <p className="text-l mr-2">{user.point_balance}</p>
                                        <img src={leaveLogo} alt="leave icon" className="h-7 mr-8 cursor-pointer"/>
                                    </button>
                            ) : (
                               ""
                            )}
                        </div>

                    </div>
                    <div className="">
                        <button onClick={() => window.location.href = "/helpdesk"} className="flex items-center green-darker cursor-pointer">
                            <img src={helpdeskLogo} alt="helpdesk icon" className="h-10 mr-2"/>
                            <p className="text-l mr-8">Guide</p>
                        </button>
                    </div>
                    <div className="">
                        {user ? (
                            <>
                                <button onClick={handleLogout} className="flex items-center green-darker cursor-pointer">
                                    <img src={userLogo} alt="user icon" className="h-10 mr-2"/>
                                    <p className="text-l">Déconnexion</p>
                                </button>
                            </>
                        ) : (
                            <button onClick={() => window.location.href = "/login"} className="flex items-center green-darker cursor-pointer">
                                <img src={userLogo} alt="user icon" className="h-5 mr-2"/>
                                <p className="text-l">Connexion</p>
                            </button>
                        )}
                    </div>
                </div>
            </div>
        </nav>
    );
};