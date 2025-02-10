<?php

declare(strict_types=1);

namespace App\Application;
use App\Domain\Model\AdCategory;
use App\Domain\Model\AdStatus;
use App\Domain\Model\User;

class InputAdDto
{
    public int $id;
    public string $title;
    public string $description;
    public ?string $pictureUrl = null;
    public string $location;
    public int $owner;
    public string $category;
    public string $status;
    public bool $isActivated;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;

//    public function __construct(
//        int $id,
//        string $title,
//        string $description,
//        string $picture,
//        string $location,
//        int $owner,
//        string $category,
//        string $status,
//        bool $isActivated,
//        \DateTimeImmutable $createdAt,
//        \DateTimeImmutable $updatedAt
//    ) {
//        $this->id = $id;
//        $this->title = $title;
//        $this->description = $description;
//        $this->picture = $picture;
//        $this->location = $location;
//        $this->owner = $owner;
//        $this->category = $category;
//        $this->status = $status;
//        $this->isActivated = $isActivated;
//        $this->createdAt = $createdAt;
//        $this->updatedAt = $updatedAt;
//    }


}