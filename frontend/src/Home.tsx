import { useEffect, useState } from "react";

const Home = () => {
    const [message, setMessage] = useState('');  // Etat pour stocker le message
    const [loading, setLoading] = useState(true);  // Etat pour savoir si les données sont en cours de chargement

    useEffect(() => {
        // Faire une requête GET vers l'API Symfony
        fetch('http://localhost/home')  // URL de ton API Symfony
            .then(response => response.json())  // Convertir la réponse en JSON
            .then(data => {
                setMessage(data.message);  // Mettre à jour l'état avec le message
                setLoading(false);  // Changer l'état pour indiquer que les données sont chargées
            })
            .catch(error => {
                console.error('Erreur lors de la récupération du message:', error);
                setLoading(false);
            });
    }, []);  // [] signifie que cet effet se déclenche une seule fois après le premier rendu

    return (
        <div>
            <h1>Message from Backend</h1>
            {loading ? <p>Loading...</p> : <p>{message}</p>}  {/* Afficher un message de chargement ou le message */}
        </div>
    );
};

export default Home;