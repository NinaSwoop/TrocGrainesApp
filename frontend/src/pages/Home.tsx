import React, {useContext, useEffect, useState} from "react";
import Card from "../components/Card.tsx";
import { Ad } from "../@types/ads";
import Error from "../components/Error.tsx";
import Button from "../components/Button.tsx";
import MenuSelect from "../components/MenuSelect.tsx";
import { Link } from "react-router-dom";
import { AuthContext } from "../context/AuthContext";

const Home = () => {
    const [ads, setAds] = useState<Ad[]>([]);
    const [filteredAds, setFilteredAds] = useState<Ad[]>([]);
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
    const [isReserved, setIsReserved] = useState<boolean | null>(null);
    const [activeButton, setActiveButton] = useState<string | null>(null);
    const [locationSearch, setLocationSearch] = useState<string>('');
    const [searchTerm, setSearchTerm] = useState('');
    const { user } = useContext(AuthContext);

    useEffect(() => {
        let filtered = ads;

        if (searchTerm) {
            filtered = filtered.filter(ad =>
                ad.title.toLowerCase().includes(searchTerm.toLowerCase())
            );
        }

        if (locationSearch) {
            filtered = filtered.filter(ad =>
                ad.location.toLowerCase().includes(locationSearch.toLowerCase())
            );
        }

        if (selectedCategory) {
            filtered = filtered.filter(ad => ad.category === selectedCategory);
        }

        if (isReserved !== null) {
            filtered = filtered.filter(ad => ad.adStatus === (isReserved ? "reserved" : "unreserved"));
        }

        setFilteredAds(filtered);
    }, [ads, searchTerm, locationSearch, selectedCategory, isReserved]);


    useEffect(() => {
        const fetchAds = async () => {
            try {
                const response = await fetch("http://localhost/api/ads");
                if (!response.ok) {
                    throw new Error("Erreur de chargement des annonces.");
                }
                const data = await response.json();
                setAds(data);
                setFilteredAds(data);
            } catch (error) {
                console.error("Erreur lors de la récupération des annonces:", error);
                setError("Une erreur est survenue lors du chargement des annonces.");
            } finally {
                setLoading(false);
            }
        };

        fetchAds().then(r => r);
    }, []);

    const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSearchTerm(e.target.value);
    };

    const handleLocationSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setLocationSearch(e.target.value);
    };

    const handleButtonClick = () => {
        setIsReserved(prev => (prev === null ? false : null));
        setActiveButton(prev => (prev === null ? "unreserved" : null));
    };

    return (
        <div className="min-h-screen flex flex-col">
            {error && <Error title="Erreur" text={error} />}
            <div className="top-[10rem] w-full z-10 md:top-[5rem] pt-[8rem] md:pt-[10rem]">
                <div className="fixed top-[6rem] md:top-[4.5rem] left-0 w-full bg-green-search-background p-4 z-40 lg:flex lg:justify-around lg:items-center">
                    <div className="lg:flex lg:flex-col ">
                        <div className="relative flex md:flex-row md:items-center md:space-x-4 items-center mb-2 lg:w-full">
                            <input
                                type="text"
                                placeholder="Rechercher par titre..."
                                value={searchTerm}
                                onChange={handleSearchChange}
                                className="w-full pl-10 pr-4 py-2 rounded-lg block appearance-none bg-beige border border-green-light-transparent hover:border-green-dark px-4 leading-tight shadow focus:ring focus:ring-green-light focus:shadow-lg focus:outline-none text-sm lg:text-base"
                            />
                            <svg
                                className="absolute h-5 w-5 ml-2"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                                />
                            </svg>
                        </div>
                        <div className="relative flex md:flex-row md:items-center md:space-x-4 items-center mb-2 lg:w-full">
                        <input
                            type="text"
                            placeholder="Rechercher par localisation..."
                            value={locationSearch}
                            onChange={handleLocationSearchChange}
                            className="w-full pl-10 pr-4 py-2 rounded-lg block appearance-none bg-beige border border-green-light-transparent hover:border-green-dark px-4 leading-tight shadow focus:ring focus:ring-green-light focus:shadow-lg focus:outline-none text-sm lg:text-base"
                        />
                        <svg
                            className="absolute h-5 w-5 ml-2"
                            fill="none"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                            />
                        </svg>
                    </div>
                    </div>
                    <div className="lg:w-[30%]">
                    <MenuSelect
                        options={[
                            { value: "", label: "Toutes les catégories" },
                            { value: "plantes", label: "Plantes" },
                            { value: "graines", label: "Graines" },
                            { value: "boutures", label: "Boutures" },
                            { value: "matériel", label: "Matériel" },
                        ]}
                        onChange={(value: string) => setSelectedCategory(value)}
                        name="menuSelect"
                        ariaLabel="menuSelect"
                    />
                    </div>
                    <div className="flex flex-row justify-between lg:flex-row lg:justify-between">
                        <Button
                            type="button"
                            text="Non réservé"
                            className={`rounded ${
                                activeButton === "unreserved"
                                    ? "bg-green-light text-beige hover:bg-beige hover:text-green-light mt-2 font-bold lg:m-0 text-center text-sm lg:text-base"
                                    : "bg-beige text-green-light hover:bg-green-light hover:text-beige mt-2 lg:m-0 text-center text-sm lg:text-base"
                            }`}
                            onClick={handleButtonClick}
                        />

                        {user ? (
                            <Link to={"/create-ad"}>

                                <Button
                                    type="button"
                                    text="Créer une annonce"
                                    className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold mt-2 text-center ml-2 text-sm lg:text-base lg:mt-0 lg:ml-4"
                                />
                            </Link> ) : (
                            <Link to={"/login"}>

                                <Button
                                    type="button"
                                    text="Créer une annonce"
                                    className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold mt-2 text-center ml-2 lg:text-base lg:mt-0 lg:ml-4"
                                />
                            </Link> )}
                    </div>
                </div>

                <div className="flex-grow mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-5 gap-7 place-items-center pt-[11rem] md:pt-[8rem] md:mr-5 md:ml-5 lg:mr-10 lg:ml-10 lg:gap-10 lg:pt-[4rem] xl:gap-4">
                    {loading ? (
                        <p>Chargement des annonces...</p>
                    ) : filteredAds.length > 0 ? (
                        filteredAds.map((ad) => <Card key={ad.id} adCard={ad} />)
                    ) : (
                        <p>Aucune annonce trouvée.</p>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Home;