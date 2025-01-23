import { useState } from 'react';

interface UploadImageZoneProps {
    label: string;
    placeholder: string;
    type: string;
    onChange: (file: File | null) => void;
    required?: boolean;
    accept?: string;
    value?: File | null;
}

export default function UploadImageZone({
                                            onChange,
                                            accept,
                                            required = false,
                                        }: UploadImageZoneProps) {
    const [preview, setPreview] = useState<string | null>(null);

    const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const file = event.target.files ? event.target.files[0] : null;
        if (file) {
            setPreview(URL.createObjectURL(file));
            onChange(file);
        } else {
            setPreview(null);
            onChange(null);
        }
    };


    return (
        <div className="flex items-center justify-center w-full">
            <label
                htmlFor="dropzone-file"
                className="flex flex-col items-center justify-center w-full h-64 border-2 border-green-light-transparent border-dashed rounded-lg cursor-pointer bg-beige-less-transparent hover:bg-beige-transparent"
            >
                <div className="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg
                        className="w-8 h-8 mb-4 text-green-dark dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 16"
                    >
                        <path
                            stroke="currentColor"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                        />
                    </svg>
                    <p className="mb-2 text-sm text-green-dark dark:text-gray-400">
                        <span className="font-semibold">Click to upload</span>
                    </p>
                    <p className="text-xs text-green-dark dark:text-gray-400">
                        SVG, PNG, JPG, WEBP (MAX. 800x400px)
                    </p>
                </div>
                <input
                    id="dropzone-file"
                    type="file"
                    className="hidden"
                    name="picture"
                    onChange={handleFileChange}
                    required={required}
                    accept={accept}
                />

                {preview && (
                    <img
                        src={preview}
                        alt="Preview uploaded image"
                        className="mb-4 max-w-xs max-h-32 object-contain"
                    />
                )}
            </label>
        </div>
    );
}