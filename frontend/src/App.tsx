import {Route, Routes} from 'react-router-dom';
import './App.css';
import Home from "./pages/Home.tsx";
import Login from "./pages/Login.tsx";
import Register from "./pages/Register.tsx";
import Navbar from "./components/Navbar.tsx";
import {AuthProvider} from "./context/AuthContext.tsx";

function App() {

    return (
    <>
        <AuthProvider>
            <Navbar />
            <main className="pt-16 flex justify-center">
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/login" element={<Login />} />
                    <Route path="/register" element={<Register />} />
                </Routes>
            </main>
        </AuthProvider>
    </>
  );
}

export default App
