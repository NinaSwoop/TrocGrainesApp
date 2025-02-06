import React, { useState } from 'react';

export interface SearchbarProps {
    isOpen: boolean,
    toggle: () => void,
    onSearch: (searchTerm: string) => void;
};

export default function Searchbar({isOpen, toggle, onSearch}: SearchbarProps) {
    const [searchTerm, setSearchTerm] = useState('');

    const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSearchTerm(e.target.value);
        onSearch(e.target.value);
    };

    return (
        <>
            <div
                className={`md:flex relative w-full max-w-md transition-all duration-300`}
            >
                <input
                    type="text"
                    placeholder="Rechercher..."
                    value={searchTerm}
                    onChange={handleSearchChange}
                    className={`${isOpen ? 'flex' : 'max-md:hidden flex'} w-full pl-10 pr-4 py-2 rounded-lg block appearance-none w-full bg-beige-less-transparent border border-green-light-transparent hover:border-green-dark px-4 py-2 pr-8 rounded leading-tight shadow focus:ring focus:ring-green-light focus:ring-1 focus:shadow-lg focus:outline-none`}
                />
                <button
                    className="absolute inset-y-0 left-0 pl-3 flex items-center"
                    onClick={toggle}>
                    <svg
                        className="h-5 w-5 text-green-dark"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                        />
                    </svg>
                </button>
            </div>
        </>
    );
}