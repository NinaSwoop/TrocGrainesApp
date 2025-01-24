interface ErrorProps {
    title: string;
    text: string;
}

export default function Error({ title, text }: ErrorProps) {
    return (
        <div
            className="mb-5 bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3"
            role="alert"
            style={{ color: 'red' }}
        >
            <p className="font-bold">{title}</p>
            <p className="text-sm">{text}</p>
        </div>
    );
}