export const AuthProvider = ({ children }: { children: ReactNode }) => {
    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState<User | null>(null);

    useEffect(() => {
        const validateToken = async () => {
            try {
                const response = await fetch(`${import.meta.env.VITE_API_URL_USERS}/auth/validate`, {
                    method: 'GET',
                    credentials: 'include', // Inclut les cookies
                });

                if (response.ok) {
                    const data = await response.json();
                    setIsAuthenticated(true);
                    setUser(data.user);
                } else {
                    setIsAuthenticated(false);
                    setUser(null);
                }
            } catch (error) {
                console.error('Erreur de validation du token', error);
                setIsAuthenticated(false);
                setUser(null);
            }
        };

        validateToken();
    }, []);

    const login = async (email: string, password: string): Promise<User | null> => {
        try {
            const response = await fetch(`${import.meta.env.VITE_API_URL_USERS}/auth/login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password }),
                credentials: 'include', // Inclut les cookies
            });

            if (!response.ok) throw new Error('Erreur lors de la connexion.');
            const data = await response.json();
            setIsAuthenticated(true);
            setUser(data.user);
            return data.user;
        } catch (error) {
            console.error(error);
            return null;
        }
    };

    const logout = () => {
        setIsAuthenticated(false);
        setUser(null);
    };

    return (
        <AuthContext.Provider value={{ isAuthenticated, user, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
};
