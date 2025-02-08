import {Route, Routes} from 'react-router-dom';
import './App.css';
import Home from "./pages/Home.tsx";
import Login from "./pages/Login.tsx";
import Register from "./pages/Register.tsx";
import Navbar from "./components/Navbar.tsx";
import Footer from "./components/Footer.tsx";
import {AuthProvider} from "./context/AuthContext.tsx";
import NavbarMobile from "./components/NavbarMobile.tsx";

function App() {

    return (
    <>
        <AuthProvider>
            <div className="min-h-screen flex flex-col">
                <Navbar />
                <NavbarMobile />
                <main className="flex-grow">
                    <Routes>
                        <Route path="/" element={<Home />} />
                        <Route path="/login" element={<Login />} />
                        <Route path="/register" element={<Register />} />
                    </Routes>
                </main>
                <Footer />
            </div>
        </AuthProvider>
    </>
  );
}

export default App
