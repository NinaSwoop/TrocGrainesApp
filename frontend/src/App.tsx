import {Route, Routes} from 'react-router-dom';
import './App.css';
import Home from "./pages/Home.tsx";
// import Login from "./pages/Login.tsx";
// import Register from "./pages/Register.tsx";
import Navbar from "./components/Navbar/Navbar.tsx";

function App() {

    return (
    <>
        <Navbar />
        <main>
            <Routes>
                <Route path="/" element={<Home />} />
            </Routes>
        </main>
    </>
  );
}

export default App
