import logo from "../../assets/logo.svg";
import user from "../../assets/user.svg";
const Navbar = () => {
    return (
        <nav className="w-full fixed top-0 flex flex-col sm:flex-row justify-between items-center bg-beige p-4 z-50">
            <div className="flex items-center mb-4 sm:mb-0">
                <a href="/" className="flex items-center">
                    <img src={logo} alt="logo" className="h-8 mr-2"/>
                    <p className="text-lg">TROC & GRAINES</p>
                </a>
            </div>
            <div className="flex items-center">
                <a href="/login" className="flex items-center">
                    <img src={user} alt="user icon" className="h-6 mr-2"/>
                    <p className="text-lg">Connexion</p>
                </a>
            </div>
        </nav>
    );
};

export default Navbar;