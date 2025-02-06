import { Link } from 'react-router-dom';
import leaveLogo from '../assets/leave.svg';
export default function Footer() {
    return (
        <div className='3xl:container flex justify-center bg-beige h-20 items-center'>
            <div className='mr-8 flex'>
                <p>Made with</p>
                <img src={leaveLogo} alt="logo" className="h-5"/>
                <p>by Troc & Graines team</p>
            </div>
            <div className='mr-8'>
                <Link to='/cgu'>CGU</Link>
            </div>
            <div className='mr-8'>
                <Link to='/legal-notices'>Mentions légales</Link>
            </div>
            <div>
                <Link to='/settings_cookies'>Paramètres cookies</Link>
            </div>
        </div>
    );
}