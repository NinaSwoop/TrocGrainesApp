export interface ProfileCard {
  ownerId: number;
  owner: array;
  ownerUsername: string;
  ownerPicture: string | null;
  ownerCreatedAt: string | null;
}

export type ProfileCardProp = {
  profileCard: ProfileCard;
};
