<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\UserId;

class Ad
{
    private int $id;
    private string $title;
    private string $description;
    private ?string $picture;
    private string $location;
    private AdCategory $category;
    private AdStatus $status;
    private UserId $ownerId;
    private bool $isActivated;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $location,
        AdCategory $category,
        AdStatus $status,
        UserId $ownerId,
        bool $isActivated,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?string $picture
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->picture = $picture;
        $this->location = $location;
        $this->category = $category;
        $this->status = $status;
        $this->ownerId = $ownerId;
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

    public function picture(): string | null
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

    public function owner(): UserId
    {
        return $this->ownerId;
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