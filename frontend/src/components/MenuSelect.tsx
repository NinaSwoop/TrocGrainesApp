interface MenuSelectProps {
    options: { value: string; label: string }[];
    onChange: (value: string) => void;
    required?: boolean;
    name: string;
}

export default function MenuSelect({
                                       options,
                                       onChange,
                                       required,
                                       name,
                                   }: MenuSelectProps) {
    return (
        <div className="inline-block relative w-64">
            <select
                className="block appearance-none w-full bg-beige-less-transparent border border-green-light-transparent hover:border-green-dark px-4 py-2 pr-8 rounded leading-tight shadow focus:ring focus:ring-green-light focus:ring-1 focus:shadow-lg focus:outline-none"
                onChange={(e) => onChange(e.target.value)}
                name={name}
                required={required}
            >
                {options.map((option) => (
                    <option key={option.value} value={option.value}>
                        {option.label}{' '}
                    </option>
                ))}
            </select>
            <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-dark">
                <svg
                    className="fill-current h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    );
}