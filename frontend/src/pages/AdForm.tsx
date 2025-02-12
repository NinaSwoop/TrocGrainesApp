import React, {useContext, useState} from 'react';
import {useNavigate} from "react-router-dom";
import Error from '../components/Error.tsx';
import Button from "../components/Button.tsx";
import Input from "../components/Input.tsx";
import UploadImageZone from '../components/UploadImageZone.tsx';
import MenuSelect from "../components/MenuSelect.tsx";
import TextArea from "../components/TextArea.tsx";
import {AuthContext} from "../context/AuthContext";

export default function AdForm() {
    const [category, setCategory] = useState<string>('');
    const [title, setTitle] = useState<string>('');
    const [description, setDescription] = useState<string>('');
    const [picture, setPicture] = useState<File | null>(null);
    const [pictureUrl, setPictureUrl] = useState<string | null>(null);
    const [location, setLocation] = useState<string>('');
    const [errors, setErrors] = useState<{ [key: string]: string }>({});
    const [error, setError] = useState<string | null>(null);
    const [isModalOpen, setIsModalOpen] = useState<boolean>(false);
    const navigate = useNavigate();
    const {user} = useContext(AuthContext);

    const openModal = () => setIsModalOpen(true);
    const closeModal = () => setIsModalOpen(false);
    const handleCancel = () => {
        closeModal();
        navigate("/");
    };

    const validateForm = () => {
        let valid = true;
        const newErrors: any = {};

        if (!title) {
            newErrors.title = "Veuillez entrer un titre";
            valid = false;
        }

        if (!category) {
            newErrors.category = 'Veuillez sélectionner une catégorie';
            valid = false;
        }

        if (!description) {
            newErrors.description = 'Veuillez entrer une description';
            valid = false;
        }

        if (!location) {
            newErrors.location = 'Veuillez indiquer la localisation';
            valid = false;
        }

        if (picture) {
            switch (picture.type) {
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

    const createAd = async (
        title: string,
        description: string,
        pictureUrl: string | null,
        location: string,
        owner: number | undefined,
        category: string) => {
        const response = await fetch('http://localhost/api/ads', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({title, description, pictureUrl, location, owner, category}),
        });

        if (!response.ok) {
            throw new Error("Erreur lors de la création de l'annonce");
        }

        return await response.json();
    }

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();

        if (!validateForm()) {
            return;
        }

        if (!user) {
            setError("Vous devez être connecté pour publier une annonce.");
            return;
        }

        try {
            await createAd(title, description, pictureUrl, location, user.id, category);
            console.log("Annonce publiée !");
            window.location.href = "/";
        } catch (error) {
            console.error("Erreur lors de l'ajout de l'annonce:", error);
            setError("Erreur lors de l'ajout de l'annonce. Réponse inattendue du serveur.");
        }
    }

    const handlePictureChange = async (file: File | null) => {
        if (!file) {
            setPicture(null);
            return;
        }

        const allowedTypes = ["image/jpeg", "image/png", "image/webp", "image/svg+xml"];
        if (!allowedTypes.includes(file.type)) {
            setError("Type de fichier non autorisé.");
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        try {
            const response = await fetch('http://localhost/api/upload_file', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                setError("Erreur lors du téléchargement du fichier");
            }

            const data = await response.json();
            if (data) {
                console.log(data);
                setPictureUrl(data);
            } else {
                setError('Erreur fichier');
            }
        } catch (error) {
            console.error("Erreur lors du téléchargement du fichier", error);
            setError('Erreur lors du téléchargement du fichier');
        }
    };

    return (
        <div className="flex flex-col bg-gray-100 pt-[5rem] lg:pt-[5rem]">
            <div className="flex items-center justify-center p-10">
                <div className="bg-beige p-10 rounded-lg shadow-md">
                    <h2 className="text-2xl font-bold mb-6 text-center text-green-dark">
                        Ajouter une annonce
                    </h2>
                    <form encType="multipart/form-data" onSubmit={handleSubmit} noValidate>
                        <div className="grid grid-cols-1 gap-4 text-sm lg:text-base">
                            <Input
                                label="Titre"
                                type="text"
                                placeholder="Graines de tournesol"
                                value={title}
                                onChange={setTitle}
                                required={true}
                                aria-describedby="title"
                            />
                            {errors.title && <Error title="Erreur" text={errors.title}/>}
                            {/*{errors.usernameLength && <Error title="Erreur" text={errors.usernameLength}/>}*/}
                            <MenuSelect
                                options={[
                                    {value: "", label: "Choisir une catégorie"},
                                    {value: "plantes", label: "Plantes"},
                                    {value: "graines", label: "Graines"},
                                    {value: "boutures", label: "Boutures"},
                                    {value: "matériel", label: "Matériel"},
                                ]}
                                onChange={(value: string) => setCategory(value)}
                                name="menuSelect"
                                aria-describedby="categorie des annonces"
                                className="w-full bg-beige-light"
                            />
                            {errors.category && <Error title="Erreur" text={errors.category}/>}
                            <TextArea
                                label="Description"
                                placeholder="sac de graines de trounesol encore emballé"
                                value={description}
                                onChange={setDescription}
                                rows={4}
                                required={true}
                            />
                            {errors.description && <Error title="Erreur" text={errors.description}/>}
                            {/*{errors.firstnameLength && <Error title="Erreur" text={errors.firstnameLength}/>}*/}
                            <label
                                className="block text-green-dark mb-2 font-bold text-sm lg:text-base"
                                htmlFor="picture"
                            >
                                Photo (optionnel)
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
                            {errors.pictureType && <Error title="Erreur" text={errors.pictureType}/>}
                            <Input
                                label="Localisation"
                                type="text"
                                placeholder="Montpellier"
                                value={location}
                                onChange={setLocation}
                                required={true}
                                aria-describedby="localisation"
                            />
                            {errors.location && <Error title="Erreur" text={errors.location}/>}
                        </div>
                        <div className="flex flex-col md:flex-row justify-around">
                            <div className="flex items-center justify-center md:mt-2">
                                <Button
                                    text="Publier"
                                    type="submit"
                                    className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold text-sm lg:text-base"
                                />
                            </div>
                            <div className="flex items-center justify-center mt-4 md:mt-2">
                                <Button
                                    text="Annuler"
                                    type="button"
                                    className="bg-red hover:bg-beige hover:text-red text-beige font-bold text-sm lg:text-base"
                                    onClick={openModal}
                                />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {isModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-gray-light bg-opacity-75">
                    <div className="bg-beige rounded-lg shadow-xl sm:w-full sm:max-w-lg">
                        <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div className="sm:flex sm:items-start">
                                <div
                                    className="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                    <svg className="size-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                         strokeWidth="1.5" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                                    </svg>
                                </div>
                                <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 className="text-base font-semibold text-gray-900">Annuler la saisie</h3>
                                    <p className="text-sm text-gray-500">Êtes-vous sûr de vouloir annuler la saisie
                                        ?</p>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button onClick={handleCancel}
                                    className="inline-flex w-full justify-center rounded-md bg-red px-3 py-2 text-sm font-semibold text-beige shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Annuler la saisie
                            </button>
                            <button onClick={closeModal}
                                    className="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-green-dark ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}