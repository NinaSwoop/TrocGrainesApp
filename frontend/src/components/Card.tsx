import { AdCardProps } from '../@types/ads';
// import './Card.css';
import { formatDistanceToNow, parseISO } from 'date-fns';
import { fr } from 'date-fns/locale';
import placeholder from '../assets/placeholder-ad.webp';
// import Button from '../components/Button';
// import { useContext } from "react";
// import { AuthContext } from "../context/AuthContext";
// import { useAuth } from "../context/AuthContext";

export default function Card({ adCard, onClick }: AdCardProps) {
    const imageUrl = adCard.picture ? adCard.picture : placeholder;
    const createdAt = adCard.createdAt ? parseISO(adCard.createdAt) : new Date();
    const timeAgo = formatDistanceToNow(createdAt, {
        addSuffix: false,
        locale: fr,
    });

    // const { user } = useAuth();

    // const handleDeleteButton = async () => {
    //     try {
    //         if (!token) {
    //             throw new Error("Token manquant ou invalide.");
    //         }
    //
    //         const response = await fetch(`${import.meta.env.VITE_API_URL_BUSINESS}/api-business/ads/${adCard.ad_id}`, {
    //             method: "DELETE",
    //             headers: {
    //                 authorization: `Bearer ${token}`,
    //             },
    //         });
    //
    //         if (!response.ok) {
    //             throw new Error(`Echec de la supression. Statut : ${response.status} ${response.statusText}`);
    //         }
    //
    //         if(onDelete) onDelete();
    //     } catch (error) {
    //         console.error("Erreur lors de la supression ", (error as Error).message);
    //     }
    // };

    return (
        <div className="flex justify-between text-center" onClick={onClick}>
            <div className="flex justify-center bg-beige hover:bg-beige-light border-green-light border-1 shadow-md hover:shadow-m hover:shadow-gray-dark transition-shadow duration-300 rounded-lg p-2 w-60 min-h-80">
                <div className="">
                    <div className="flex justify-center mt-5">
                        <img
                            src={imageUrl}
                            alt={adCard.title}
                            className="size-32 rounded-t-lg"
                        />
                    </div>
                    <h3 className="text-green-dark font-bold mt-2">
                        {adCard.title}
                    </h3>
                    <div className="flex items-center justify-center text-green-dark mt-3">
                        <svg
                            width="20px"
                            height="20px"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            className="mr-2"
                        >
                            <path
                                d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                stroke='#395144'
                                strokeWidth="1.5"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            />
                            <path
                                d="M12 6V12"
                                stroke='#395144'
                                strokeWidth="1.5"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            />
                            <path
                                d="M16.24 16.24L12 12"
                                stroke='#395144'
                                strokeWidth="1.5"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            />
                        </svg>
                        <span className="text-green-dark text-center">{timeAgo}</span>
                    </div>
                    <div className="flex items-center justify-center text-green-dark mb-2 mt-2">
                        <svg
                            fill="#478746"
                            height="24px"
                            width="24px"
                            version="1.1"
                            id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 511.953 511.953"
                            className="mr-2"
                        >
                            <g transform="translate(-1)">
                                <g>
                                    <g>
                                        <path
                                            d="M256.995,149.287c-11.776,0-21.333,9.579-21.333,21.333c0,11.755,9.557,21.333,21.333,21.333s21.333-9.579,21.333-21.333
                      C278.328,158.865,268.771,149.287,256.995,149.287z"
                                        />
                                        <path
                                            d="M365.518,38.887C325.987,6.311,274.04-6.639,223.011,3.239C154.147,16.615,100.152,72.273,88.718,141.735
                      c-6.784,41.003,0.725,81.216,21.696,116.267l8.704,14.528c27.861,46.443,56.64,94.485,79.701,143.893l38.848,83.221
                      c3.499,7.509,11.029,12.309,19.328,12.309s15.829-4.8,19.328-12.309l34.965-74.923c23.317-49.984,52.096-98.688,79.957-145.792
                      l12.971-22.016c15.339-26.091,23.445-55.936,23.445-86.293C427.662,119.484,405.006,71.463,365.518,38.887z M256.995,234.62
                      c-35.285,0-64-28.715-64-64s28.715-64,64-64s64,28.715,64,64S292.28,234.62,256.995,234.62z"
                                        />
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span>{adCard.location}</span>
                    </div>
                    <div className="text-center text-green-dark">
                        <span>Catégorie : {adCard.category}</span>
                    </div>
                    {/*{*/}
                    {/*    onDelete &&*/}
                    {/*    <Button*/}
                    {/*        text="Supprimer"*/}
                    {/*        type="button"*/}
                    {/*        className="bg-red hover:bg-beige hover:text-red text-beige font-bold mb-6"*/}
                    {/*        onClick={(event: React.MouseEvent<HTMLButtonElement>) => {*/}
                    {/*            event.stopPropagation();*/}
                    {/*            handleDeleteButton();*/}
                    {/*        }}*/}
                    {/*    />*/}
                    {/*}*/}
                </div>
                {adCard.adStatut && (
                    <div className="absolute bottom-0 left-0 w-full bg-green-light py-1 rounded-b-lg text-center text-beige-light hover:text-beige text-xs shadow-md hover:shadow-m hover:shadow-gray-dark transition-shadow duration-300 border-2 border-green-light">
                        Réservé
                    </div>
                )}
            </div>
        </div>
    );
}