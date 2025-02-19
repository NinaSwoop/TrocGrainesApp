import { AdCardProps } from "../@types/ads";
import { formatDistanceToNow, parseISO } from "date-fns";
import { fr } from "date-fns/locale";
import placeholder from "../assets/placeholder-ad.webp";
import { useState } from "react";
import Button from "./Button.tsx";

export default function adCardOwner({ adCard }: AdCardProps) {
  const baseUrl = "http://localhost/uploads";
  const imageFileName = adCard.picture;
  const imageUrl = imageFileName ? `${baseUrl}/${imageFileName}` : placeholder;
  const createdAt = adCard.createdAt ? parseISO(adCard.createdAt) : new Date();
  const timeAgo = formatDistanceToNow(createdAt, {
    addSuffix: false,
    locale: fr,
  });

  const [isModalOpen, setIsModalOpen] = useState<boolean>(false);

  const openModal = () => setIsModalOpen(true);
  const closeModal = () => setIsModalOpen(false);
  const handleCancel = () => {
    closeModal();
  };

  function handleDelete() {
    fetch(`http://localhost/ads/${adCard.id}`, {
      method: "DELETE",
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Une erreur est survenue.");
        }
        window.location.reload();
      })
      .catch((error) => {
        console.error("Erreur lors de la suppression de l'annonce:", error);
      });
  }

  return (
    <>
      <div className="bg-beige p-10 rounded-lg shadow-md mb-10 lg:grid">
        <div>
          <p className="text-l font-bold mb-6 text-center text-green-dark">
            {adCard.title}
          </p>
        </div>
        <div className="flex justify-center mt-5">
          <img
            src={imageUrl}
            alt={adCard.title}
            className="size-32 lg:size-32 lg:rounded-full rounded-t-lg object-cover"
          />
        </div>
        <div>
          <p className="mt-4 text-sm lg:text-xl text-green-dark">
            Publiée il y a : {timeAgo}
          </p>
        </div>
        {adCard.adStatus === "reserved" && (
          <div className="">Vous avez réservé cette annonce</div>
        )}
        <div className="flex flex-col md:flex-row justify-around">
          <div className="flex items-center justify-center md:mt-2">
            <Button
              text="Modifier"
              type="submit"
              className="bg-green-light hover:bg-beige hover:text-green-light text-beige font-bold text-sm lg:text-base"
            />
          </div>
          <div className="flex items-center justify-center mt-4 md:mt-2">
            <Button
              text="Supprimer"
              type="button"
              className="bg-red hover:bg-beige hover:text-red text-beige font-bold text-sm lg:text-base"
              onClick={openModal}
            />
          </div>
        </div>
        {isModalOpen && (
          <div className="fixed inset-0 z-50 flex items-center justify-center bg-gray-light bg-opacity-75 p-10">
            <div className="bg-beige rounded-lg shadow-xl sm:w-full sm:max-w-lg">
              <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div className="sm:flex sm:items-start">
                  <div className="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                    <svg
                      className="size-6 text-red-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth="1.5"
                      stroke="currentColor"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                      />
                    </svg>
                  </div>
                  <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 className="text-base font-semibold text-gray-900">
                      Supprimer l'annonce
                    </h3>
                    <p className="text-sm text-gray-500">
                      Êtes-vous sûr de vouloir supprimer l'annonce ?
                    </p>
                    <span className="text-sm text-gray-500">
                      Cette action est irréversible.
                    </span>
                  </div>
                </div>
              </div>
              <div className="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button
                  onClick={() => {
                    handleCancel();
                    handleDelete();
                  }}
                  className="inline-flex w-full justify-center rounded-md bg-red px-3 py-2 text-sm font-semibold text-beige shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto"
                >
                  Supprimer l'annonce
                </button>
                <button
                  onClick={closeModal}
                  className="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-green-dark ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto"
                >
                  Annuler
                </button>
              </div>
            </div>
          </div>
        )}
      </div>
    </>
  );
}
