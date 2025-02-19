import { Link } from "react-router-dom";
import leaveLogo from "../assets/leave.svg";
export default function Footer() {
  return (
    <div className="w-full bg-beige z-50 mt-4 lg:flex lg:justify-around lg:items-center lg:px-8 py-4 text-sm lg:text-base">
      <div className="flex justify-center text-decoration-line: underline">
        <Link to="/cgu">CGU</Link>
      </div>
      <div className="flex justify-center text-decoration-line: underline">
        <Link to="/legal-notices">Mentions légales</Link>
      </div>
      <div className="flex justify-center text-decoration-line: underline">
        <Link to="/settings_cookies">Paramètres cookies</Link>
      </div>
      <div className="flex justify-center">
        <p>Made with</p>
        <img src={leaveLogo} alt="logo" className="h-5" />
        <p>by Troc & Graines team</p>
      </div>
    </div>
  );
}
