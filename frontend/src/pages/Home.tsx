import { useEffect, useState } from "react";
import Card from "../components/Card.tsx";
import { Ad } from "../@types/ads";
import Error from "../components/Error.tsx";

const Home = () => {
    const [ads, setAds] = useState<Ad[]>([]);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchAds = async () => {
            try {
                const response = await fetch('http://localhost/ads');
                const data = await response.json();
                console.log(data);
                setAds(data);
            } catch (error) {
                console.error("Erreur lors de la récupération des annonces:", error);
                setError("Une erreur est survenue lors du chargement des annonces.");
            }
        };

        fetchAds().then(r => r);
    }, []);
    return (
        <div>
            {error && <Error title="Erreur" text={error} />}
            <div className="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 mt-5 gap-4 place-items-center">
                {ads.map((ad) => (
                    <Card key={ad.id} adCard={ad} />
                ))}
            </div>
        </div>
    );
};

export default Home;