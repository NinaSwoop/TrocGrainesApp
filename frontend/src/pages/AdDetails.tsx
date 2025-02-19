import { Link, useLocation } from "react-router-dom";
import { Ad } from "../@types/ads";
import { formatDistanceToNow, parseISO } from "date-fns";
import { fr } from "date-fns/locale";
import placeholder from "../assets/placeholder-ad.webp";
import Button from "../components/Button.tsx";
import { useContext } from "react";
import { AuthContext } from "../context/AuthContext.tsx";

export default function AdDetails() {
  const { user } = useContext(AuthContext);
  const location = useLocation();
  const ad: Ad = location.state?.ad;
  const imageFileName = ad.picture;
  const baseUrl = "http://localhost/uploads";
  const imageUrl = imageFileName ? `${baseUrl}/${imageFileName}` : placeholder;
  const createdAt = ad.createdAt ? parseISO(ad.createdAt) : new Date();
  const timeAgo = formatDistanceToNow(createdAt, {
    addSuffix: false,
    locale: fr,
  });
  const ownerCreatedAtTimeAgo = formatDistanceToNow(parseISO(ad["owner"][2]), {
    addSuffix: false,
    locale: fr,
  });
  const ownerUsername = ad["owner"][1];

  if (!ad) {
    return (
      <p className="text-red-500 text-center mt-10">Aucune annonce trouvée.</p>
    );
  }

  return (
    <div className="container mx-auto px-4 py-10 pt-[7rem]">
      <h1 className="text-3xl font-bold text-green-dark text-center">
        {ad.title}
      </h1>
      <div className="flex flex-col items-center mt-6">
        <img
          src={imageUrl || placeholder}
          alt={ad.title}
          className="w-80 h-80 object-cover rounded-lg shadow-md"
        />
        <p className="mt-4 text-sm lg:text-xl text-green-dark">
          {ad.description}
        </p>
        <p className="mt-2 text-sm lg:text-base text-green-dark">
          Publié par {ownerUsername} il y'a {timeAgo}
        </p>
        <p className="mt-2 text-sm lg:text-base text-green-dark">
          Membre depuis {ownerCreatedAtTimeAgo}
        </p>
        <p className="mt-2 text-sm lg:text-base text-green-dark">
          Lieu : {ad.location}
        </p>
        <p className="mt-2 text-sm lg:text-base text-green-dark">
          Catégorie : {ad.category}
        </p>
        {ad.adStatus === "reserved" && (
          <p className="text-red-500 font-semibold mt-4">
            Cette annonce est réservée
          </p>
        )}
        {user ? (
          <Link to={"/messaging"}>
            <Button
              type="button"
              text="Contacter"
              className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold mt-2 text-center ml-2 text-sm lg:text-base lg:mt-4 lg:ml-4"
            />
          </Link>
        ) : (
          <Link to={"/login"}>
            <Button
              type="button"
              text="Contacter"
              className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold mt-2 text-center ml-2 lg:text-base lg:mt-4 lg:ml-4"
            />
          </Link>
        )}
      </div>
    </div>
  );
}
