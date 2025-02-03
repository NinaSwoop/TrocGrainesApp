import { createContext, useContext, useState, useEffect, ReactNode } from "react";

interface AuthContextType {
    user: { email: string; roles: string[] } | null;
    login: (email: string, password: string) => Promise<void>;
    logout: () => Promise<void>;
    register: (username: string, firstname: string, lastname: string, email: string, birthdate: string, pictureUrl: string | null, password: string) => Promise<void>;
}

export const AuthContext = createContext<AuthContextType>({
    user: null,
    login: async () => { },
    logout: async () => { },
    register: async () => { }
});

interface AuthProviderProps {
    children: ReactNode;
}

export const useAuth = () => {
    const context = useContext(AuthContext);
    if (context === undefined) {
        throw new Error("useAuth must be used within an AuthProvider");
    }
    return context;
};

export const AuthProvider = ({ children }: AuthProviderProps) => {
    const [user, setUser] = useState<{ email: string; roles: string[] } | null>(null);

    useEffect(() => {
        fetch("http://localhost/auth/auth_user", {
            method: "GET",
            credentials: "include",
        })
            .then(res => res.ok ? res.json() : null)
            .then(data => {
                if (data) {
                    setUser({ email: data.email, roles: data.roles });
                }
            })
            .catch(() => setUser(null));
    }, []);

    const login = async (email: string, password: string) => {
        const res = await fetch("http://localhost/auth/login", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            credentials: "include",
            body: JSON.stringify({ security: { credentials: { email, password } } })
        });

        if (res.ok) {
            const data = await res.json();
            setUser({ email: data.email, roles: data.roles });
        } else {
            throw new Error("Échec de l'authentification");
        }
    };

    const logout = async () => {
        await fetch("http://localhost/auth/logout", {
            method: "POST",
            credentials: "include"
        });
        setUser(null);
    };

    const register = async (username: string, firstname: string, lastname: string, email: string, birthdate: string, pictureUrl: string | null, password: string) => {
        const res = await fetch("http://localhost/auth/register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ username, firstname, lastname, email, birthdate, pictureUrl, password })
        });

        if (!res.ok) {
            throw new Error("Échec de l'inscription");
        }
    };


    return (
        <AuthContext.Provider value={{ user, login, logout, register }}>
            {children}
        </AuthContext.Provider>
    );
};