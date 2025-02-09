interface TextAreaProps {
    label: string;
    placeholder: string;
    value: string;
    onChange: (value: string) => void;
    required?: boolean;
    rows: number;
}
export default function TextArea({
                                     label,
                                     placeholder,
                                     onChange,
                                     required = false,
                                     rows,
                                 }: TextAreaProps) {
    return (
        <div className="mb-4">
            <label
                className="block text-green-dark text-sm font-bold mb-2"
                htmlFor={label}
            >
                {label}
            </label>
            <textarea
                className="block appearance-none w-full bg-beige-light border border-green-light-transparent hover:border-green-dark px-4 py-2 pr-8 rounded leading-tight shadow focus:ring-green-light focus:ring-1 focus:shadow-lg focus:outline-none"
                placeholder={placeholder}
                onChange={(e) => onChange(e.target.value)}
                required={required}
                rows={rows}
                aria-describedby={label}
            />
        </div>
    );
}