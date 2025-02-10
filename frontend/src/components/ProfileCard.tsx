import { formatDistanceToNow, parseISO } from 'date-fns';
import { fr } from 'date-fns/locale';
import placeholder from '../assets/placeholder-user.webp';
import { AuthContext } from "../context/AuthContext";
import {useContext} from "react";

export default function ProfileCard() {
    const { user } = useContext(AuthContext);
    const imageFileName = user?.picture ? user.picture : "";
    const baseUrl = 'http://localhost/uploads';
    const imageUrl = imageFileName ? `${baseUrl}/${imageFileName}` : placeholder;
    const createdAt = user?.createdAt ? parseISO(user.createdAt) : new Date();
    const timeAgo = formatDistanceToNow(createdAt, {
        addSuffix: false,
        locale: fr,
    });

    return (
     <>
         {user ? (
                 <div className="bg-beige p-10 rounded-lg shadow-md">
                     <h2 className="text-2xl font-bold mb-6 text-center text-green-dark">
                     {user.username}
                     </h2>
                     <div className="">
                         <div className="flex justify-center mt-5">
                             <img
                                 src={imageUrl}
                                 alt={user.username}
                                 className="size-32 rounded-t-lg object-cover"/>
                         </div>

                         <div className="flex items-center justify-center text-green-dark mt-3">
                             <span className="text-green-dark text-center">Je suis membre depuis : {timeAgo}</span>
                         </div>
                     </div>
                    </div>
         ) : (
                <p className="text-red-500 text-center mt-10">Aucun utilisateur trouvé.</p>
         )}
     </>
    );
}