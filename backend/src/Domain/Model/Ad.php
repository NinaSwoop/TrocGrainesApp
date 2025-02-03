<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Ad
{
    private int $id;
    private string $title;
    private string $description;
    private string $picture;
    private string $location;
    private AdCategory $category;
    private AdStatus $status;
    private User $owner;
    private bool $isActivated;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $picture,
        string $location,
        AdCategory $category,
        AdStatus $status,
        User $owner,
        bool $isActivated,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->picture = $picture;
        $this->location = $location;
        $this->category = $category;
        $this->status = $status;
        $this->owner = $owner;
        $this->isActivated = $isActivated;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function picture(): string
    {
        return $this->picture;
    }

    public function location(): string
    {
        return $this->location;
    }

    public function category(): AdCategory
    {
        return $this->category;
    }

    public function status(): AdStatus
    {
        return $this->status;
    }

    public function owner(): User
    {
        return $this->owner;
    }

    public function isActivated(): bool
    {
        return $this->isActivated;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}