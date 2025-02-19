import ProfileCard from "../components/ProfileCard.tsx";
import SenderAdProfile from "../components/SenderAdProfile.tsx";
import { useContext, useEffect, useState } from "react";
import { Ad } from "../@types/ads";
import Error from "../components/Error.tsx";
import { AuthContext } from "../context/AuthContext.tsx";

export default function Profile() {
  const [ads, setAds] = useState<Ad[]>([]);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const { user } = useContext(AuthContext);

  useEffect(() => {
    if (!user || !user.id) {
      setError("Utilisateur non authentifié.");
      setLoading(false);
      return;
    }
    const fetchAdsByOwner = async () => {
      try {
        const response = await fetch(
          `http://localhost/api/users/${user?.id}/ads`,
        );
        if (!response.ok) {
          throw new Error("Erreur de chargement des annonces.");
        }
        const data = await response.json();
        setAds(data);
      } catch (error) {
        console.error("Erreur lors de la récupération des annonces:", error);
        setError("Une erreur est survenue lors du chargement des annonces.");
      } finally {
        setLoading(false);
      }
    };

    fetchAdsByOwner().then((r) => r);
  }, [user]);

  return (
    <>
      <div className="flex flex-col lg:flex-row lg:justify-around bg-gray-100 pt-[5rem] lg:pt-[5rem]">
        <div className="flex flex-col bg-gray-100 pt-[5rem] lg:p-10">
          <div className="">
            <h1 className="text-3xl font-bold text-green-dark text-center">
              Mon profil
            </h1>
          </div>
          <div className="flex items-center justify-center p-10">
            <ProfileCard />
          </div>
        </div>
        <div className="flex flex-col items-center justify-center p-10">
          <h1 className="text-3xl font-bold mb-10 text-green-dark text-center">
            Mes annonces
          </h1>
          {loading ? (
            <p>Chargement des annonces...</p>
          ) : ads.length > 0 ? (
            ads.map((ad) => <SenderAdProfile key={ad.id} adCard={ad} />)
          ) : (
            <p>Aucune annonce publiée</p>
          )}
        </div>
      </div>
    </>
  );
}
