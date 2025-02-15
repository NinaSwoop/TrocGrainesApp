<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Ad;

interface AdRepositoryInterface
{
    public function add(Ad $ad): void;

    public function findAll(): array;

    public function findByOwner(int $id): array;
    public function delete(int $id);
}


