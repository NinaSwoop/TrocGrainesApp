interface InputProps {
    label: string;
    placeholder: string;
    type: string;
    value: string;
    onChange: (value: string) => void;
    required?: boolean;
}

export default function Input({
                                  label,
                                  placeholder,
                                  type,
                                  onChange,
                                  required = false,
                              }: InputProps) {
    return (
        <div className="mb-4">
            <label
                className="block text-green-dark text-sm font-bold mb-2"
                htmlFor={label}
            >
                {label}
            <input
                className="block appearance-none bg-beige-light w-full border border-green-light-transparent hover:border-green-dark px-4 py-2 pr-8 rounded leading-tight shadow focus:ring focus:ring-green-light focus:shadow-lg focus:outline-none"
                type={type}
                placeholder={placeholder}
                onChange={(e) => onChange(e.target.value)}
                required={required}
            />
            </label>
        </div>
    );
}