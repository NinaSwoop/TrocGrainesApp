import React from "react";

interface ButtonProps {
    text: string;
    type: 'button' | 'submit' | 'reset';
    className?: string;
    children?: React.ReactNode;
    onClick?: (event: React.MouseEvent<HTMLButtonElement>) => void;
    disabled?: boolean;
}

export default function Button({
                                   text,
                                   type,
                                   className,
                                   children,
                                   onClick,
                                   disabled,
                               }: ButtonProps) {
    return (
        <button
            className={`px-4 py-2 rounded ${className || ''}`}
            type={type}
            onClick={onClick}
            disabled={disabled}
        >
            {text || children}
        </button>
    );
}