import React, { useContext, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Error from '../components/Error.tsx';
import Button from "../components/Button.tsx";
import Input from "../components/Input.tsx";
import UploadImageZone from '../components/UploadImageZone.tsx';
// import { AuthContext } from '../context/AuthContext.tsx';

export default function RegistrationPage() {
    const [username, setUsername] = useState('');
    const [lastname, setLastname] = useState('');
    const [firstname, setFirstname] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [birthdate, setBirthdate] = useState('');
    const [picture, setPicture] = useState<File | null>(null);
    const [error, setError] = useState<string | null>(null);
    const [errors, setErrors] = useState<{ [key: string]: string }>({});
    // const { register } = useContext(AuthContext);
    const navigate = useNavigate();

    const validateForm = () => {
        let valid = true;
        const newErrors: any = {};
        const nameRegex = /^[a-zA-Z\s-]+$/;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        const birthdateRegex = /^\d{4}-\d{2}-\d{2}$/;

        if ((username && !nameRegex.test(username)) ||
            (lastname && !nameRegex.test(lastname)) ||
            (firstname && !nameRegex.test(firstname))) {
            newErrors.nameRegex = 'Le nom ne doit contenir que des lettres, des espaces ou des tirets';
            valid = false;
        }

        if ((username && username.length < 2 || username.length > 50) ||
            (lastname && lastname.length < 2 || lastname.length > 50) ||
            (firstname && firstname.length < 2 || firstname.length > 50)) {
            newErrors.nameLength = 'Le nom doit contenir entre 2 et 50 caractères';
            valid = false;
        }

        if (!username || !lastname || !firstname) {
            newErrors.name = 'Veuillez entrer un nom';
            valid = false;
        }

        if (!email) {
            newErrors.email = 'Veuillez indiquer un email';
            valid = false;
        }

        if (email && (!email.includes('@') || !email.includes('.'))) {
            newErrors.emailNotComplete = 'Email invalide';
            valid = false;
        }

        if (!password) {
            newErrors.password = 'Veuillez indiquer un mot de passe';
            valid = false;
        }

        if (password && (password.length < 8 || !passwordRegex.test(password))) {
            newErrors.passwordLength = 'Votre mot de passe doit contenir au moins 8 caractères dont au moins 1 lettre minuscule, 1 lettre majuscule, 1 chiffre et 1 caractère spécial';
            valid = false;
        }

        if(picture) {
            switch(picture.type) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/png' :
                case 'image/webp':
                case 'image/svg+xml':
                case null:
                    valid = true;
                    break;
                default:
                    newErrors.pictureType = 'Le type utilisé est incorrect';
                    valid = false;
            }
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
            const role_id = 2;
            const user = await register(username, firstname, lastname, email, password, birthdate, picture, role_id);

            if (!user) {
                setError('Ce profil possède déjà un compte.');
            } else {
                navigate('/login');
            }
        } catch (error) {
            setError('Erreur lors de la connexion');
            console.error('Erreur lors de la connexion:', error);
        }
    };

    const handlePictureChange = (file: File | null) => {
        setPicture(file);
    };

    return (
        <div className="flex items-center justify-center min-h-screen bg-gray-100">
            <div className="w-full max-w-xl h-auto bg-beige-light p-10 rounded-lg shadow-md">
                <h2 className="text-2xl font-bold mb-6 text-center text-green-dark">
                    S'inscrire
                </h2>
                <form encType="multipart/form-data" onSubmit={handleSubmit} noValidate>
                    <div className="columns-2">
                        <div className="mb-4">
                            <Input
                                label="Nom d'utilisateur"
                                type="text"
                                placeholder="Votre nom d'utilisateur"
                                value={username}
                                onChange={setUsername}
                                required={true}
                                aria-describedby="username"
                            />
                            {errors.name && <Error title="Erreur" text={errors.username} />}
                            {errors.nameRegex && <Error title="Erreur" text={errors.nameRegex} />}
                            {errors.nameLength && <Error title="Erreur" text={errors.nameLength} />}
                        </div>
                        <div className="mb-4">
                            <Input
                                label="Nom"
                                type="text"
                                placeholder="Votre nom"
                                value={lastname}
                                onChange={setLastname}
                                required={true}
                                aria-describedby="lastname"
                            />
                            {errors.name && <Error title="Erreur" text={errors.name} />}
                            {errors.nameRegex && <Error title="Erreur" text={errors.nameRegex} />}
                            {errors.nameLength && <Error title="Erreur" text={errors.nameLength} />}
                        </div>
                    </div>
                    <div className="columns-2">
                        <div className="mb-4">
                            <Input
                                label="Prénom"
                                type="text"
                                placeholder="Votre prénom"
                                value={firstname}
                                onChange={setFirstname}
                                required={true}
                                aria-describedby="firstname"
                            />
                            {errors.name && <Error title="Erreur" text={errors.name} />}
                            {errors.nameRegex && <Error title="Erreur" text={errors.nameRegex} />}
                            {errors.nameLength && <Error title="Erreur" text={errors.nameLength} />}
                        </div>
                        <div className="mb-4">
                            <Input
                                label="Email"
                                type="email"
                                placeholder="Votre email"
                                value={email}
                                onChange={setEmail}
                                required={true}
                                aria-describedby="email"
                            />
                            {errors.email && <Error title="Erreur" text={errors.email} />}
                            {errors.emailNotComplete && <Error title="Erreur" text={errors.emailNotComplete} />}
                        </div>
                    </div>
                        <div className="mb-4">
                            <Input
                                label="Mot de passe"
                                type="password"
                                placeholder="********"
                                value={password}
                                onChange={setPassword}
                                required={true}
                                aria-describedby="password"
                            />
                            {errors.password && <Error title="Erreur" text={errors.password} />}
                            {errors.passwordLength && <Error title="Erreur" text={errors.passwordLength} />}
                        </div>
                        <div className="mb-4">
                            <Input
                                label="Date de naissance"
                                type="date"
                                value={birthdate}
                                onChange={setBirthdate}
                                required={true}
                                placeholder="Votre date de naissance"
                                aria-describedby="birthdate"
                            />
                            {errors.password && <Error title="Erreur" text={errors.password} />}
                            {errors.passwordLength && <Error title="Erreur" text={errors.passwordLength} />}
                        </div>
                        <div className="mb-4">
                            <label
                                className="block text-green-dark text-sm font-bold mb-2"
                                htmlFor="picture"
                            >
                                Photo de profil (optionnel)
                            </label>
                            <UploadImageZone
                                label="picture"
                                type="file"
                                onChange={handlePictureChange}
                                accept="image/png, image/jpeg, image/svg+xml, image/webp"
                                placeholder="picture"
                                required={false}
                                value={picture}
                                aria-describedby="picture"
                            />
                            {errors.pictureType && <Error title="Erreur" text={errors.pictureType} />}
                        </div>
                        <div className="mt-5 mb-5">
                            <a href="/login"
                               className="text sm text-green-dark text-decoration-line: underline">
                                Déjà inscrit ? Connectez-vous
                            </a>
                        </div>
                        {error && <Error title="Erreur" text={error} />}
                        <div className="flex items-center justify-center">
                            <Button
                                text="Inscription"
                                type="submit"
                                className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold"
                            />
                        </div>
                </form>
            </div>
        </div>
    );
}