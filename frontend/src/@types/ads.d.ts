export interface Ad {
    id: number;
    owner: number;
    title: string;
    category: string;
    description: string | null;
    location: string;
    picture?: string | null;
    adStatut: boolean;
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