import { useState } from "react";
import logo from "../assets/logo.svg";
import "../styles/NavbarMobile.css";
import placeholder from "../assets/placeholder-user.webp";
import { AuthContext } from "../context/AuthContext";
import { useContext } from "react";
import helpdeskLogo from "../assets/helpdesk.svg";
import leaveLogo from "../assets/leave.svg";
import userLogo from "../assets/user.svg";

export default function NavbarMobile() {
    const [isNavOpen, setIsNavOpen] = useState(false);
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
        <nav className="border-b border-green-darker p-4 md:hidden bg-beige fixed z-50 w-full">
            <p className="text-m text-center mb-2">TROC & GRAINES</p>
            <div className="flex justify-between">
                <a href="/" className="flex items-center">
                    <img src={logo} alt="logo" className="h-8"/>
                </a>

                {user ? (
                    <button onClick={() => window.location.href = "/profile"} className="flex items-center green-darker">
                        <p className="text-l mr-2">{user.username}</p>
                        <img src={placeholder} alt="avatar of plant" className="h-10 w-10 cursor-pointer rounded-full"/>
                    </button>
                ) : (
                    ""
                )}

                <section className="flex items-center">
                    <div
                        className="space-y-2 "
                        onClick={() => setIsNavOpen((prev) => !prev)}
                    >
                        <span className="block h-0.5 w-8 bg-green-dark"></span>
                        <span className="block h-0.5 w-8 bg-green-dark"></span>
                        <span className="block h-0.5 w-8 bg-green-dark"></span>
                    </div>

                    <div className={isNavOpen ? "showMenuNav" : "hideMenuNav"}>
                        <div
                            className="absolute top-0 right-0 px-8 py-8 bg-beige"
                            onClick={() => setIsNavOpen(false)}
                        >
                            <svg
                                className="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            >
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </div>
                        <ul className="flex flex-col items-center justify-between min-h-[250px]">
                            <li className="border-b border-green-950 my-8 uppercase text-green-darkest">
                                {user ? (
                                    <>
                                        <button onClick={handleLogout} className="flex items-center green-darker cursor-pointer">
                                            <img src={userLogo} alt="user icon" className="h-5 mr-2"/>
                                            Déconnexion
                                        </button>
                                    </>
                                ) : (
                                    <button onClick={() => window.location.href = "/login"} className="flex items-center green-darker cursor-pointer">
                                        <img src={userLogo} alt="user icon" className="h-5 mr-2"/>
                                        <p className="text-m">Connexion</p>
                                    </button>
                                )}
                            </li>
                            <li className="border-b border-green-950 my-8 uppercase text-green-darkest">
                                {user ? (
                                    <button onClick={() => window.location.href = "/help_points"} className="flex items-center green-darker">
                                        <p className="text-m mr-2">{user.point_balance}</p>
                                        <img src={leaveLogo} alt="leave icon" className="h-5 mr-8 cursor-pointer"/>
                                    </button>
                                ) : (
                                    ""
                                )}
                            </li>
                            <li className="border-b border-green-950 my-8 uppercase text-green-darkest">
                                <button onClick={() => window.location.href = "/helpdesk"} className="flex items-center green-darker cursor-pointer">
                                    <img src={helpdeskLogo} alt="helpdesk icon" className="h-5 mr-2"/>
                                    <p className="text-m">Guide</p>
                                </button>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </nav>
    );
}
