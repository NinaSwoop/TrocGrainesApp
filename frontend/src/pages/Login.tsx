import React, { useState } from 'react';
// import { useLocation, useNavigate } from 'react-router-dom';
import Button from "../components/Button.tsx";
import Input from "../components/Input.tsx";
import Error from "../components/Error.tsx";
// import { AuthContext } from "../context/AuthContext.tsx";

export default function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState<string | null>(null);
    const [errors, setErrors] = useState<{ [key: string]: string }>({});
    // const { login } = useContext(AuthContext);
    // const navigate = useNavigate();
    // const location = useLocation();

    // const from = location.state?.from?.pathname || '/';

    const validateForm = () => {
        let valid = true;
        const newErrors: any = {};

        if (!email) {
            newErrors.email = 'Veuillez indiquer votre email';
            valid = false;
        }

        if (!password) {
            newErrors.password = 'Veuillez indiquer votre mot de passe';
            valid = false;
        }

        setErrors(newErrors);
        return valid;
    };

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();

        if (!validateForm()) {
            return;
        }

        try {
            const response = await fetch('http://localhost/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    password
                }),
            });
            const contentType = response.headers.get('content-type');
            if (!response.ok) {
                if (contentType && contentType.includes('application/json')) {
                    const errorData = await response.json();

                    if (response.status === 401) {
                        setError("Email ou mot de passe incorrect.");
                    } else if (response.status === 400) {
                        setError("Données invalides. Vérifiez vos informations.");
                    } else {
                        setError(errorData.message || "Erreur inconnue.");
                    }
                } else {
                    setError("Erreur lors de la connexion. Réponse inattendue du serveur.");
                }
                return;
            }

            console.log("Connexion réussie !");
            window.location.href = "/home";

        } catch (error) {
            console.error("Erreur lors de la connexion:", error);
            setError("Erreur lors de la connexion. Réponse inattendue du serveur.");
            return;
        }
    };

    return (
        <div className="flex items-center justify-center min-h-screen bg-gray-100">
            <div className="w-full max-w-xl h-auto bg-beige-light p-10 rounded-lg shadow-md">
                <h2 className="text-2xl font-bold mb-6 text-center text-green-dark" data-cy="connexion-title">
                    Connectez-vous
                </h2>
                <form onSubmit={handleSubmit} noValidate>
                    <div className="mb-4">
                        <Input
                            label="Email"
                            type="email"
                            placeholder="email@email.com"
                            value={email}
                            onChange={setEmail}
                            required={true}
                        />
                        {errors.email && <Error title="Erreur" text={errors.email} />}
                    </div>
                    <div className="mb-6">
                        <Input
                            label="Mot de passe"
                            type="password"
                            placeholder="********"
                            value={password}
                            onChange={setPassword}
                            required={true}
                        />
                        {errors.password && <Error title="Erreur" text={errors.password} />}
                    </div>
                    <div className="mt-5 mb-5">
                        <a href="/register"
                           className="text sm text-green-dark text-decoration-line: underline">
                            Pas encore inscrit ? Créer un compte
                        </a>
                    </div>
                    {error && <Error title="Erreur" text={error} />}
                    <div className="flex items-center justify-center">
                        <Button
                            text="Connexion"
                            type="submit"
                            className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold"
                        />
                    </div>
                </form>
            </div>
        </div>
    );
}