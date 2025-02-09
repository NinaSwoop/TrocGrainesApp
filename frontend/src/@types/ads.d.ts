export interface Ad {
    id: number;
    owner: array;
    ownerUsername: string;
    ownerPicture: string | null;
    ownerCreatedAt: string | null;
    title: string;
    category: string;
    description: string | null;
    location: string;
    picture?: string | null;
    adStatus: string;
    createdAt: string | null;
    updatedAt?: string | null;
}

export type AdCardProps = {
    adCard: Ad;
    onClick?: () => void;
    onDelete?: () => void;
};

export type AdFormProps = {
    userId: number;
};