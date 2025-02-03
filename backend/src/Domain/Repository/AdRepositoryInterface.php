<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Ad;

interface AdRepositoryInterface
{
//    public function add(Ad $ad): void;
//
//    public function update(Ad $ad): void;
//
//    public function delete(Ad $ad): void;

    public function findAll(): array;

//    public function findById(int $id): ?Ad;
//
//    public function findByTitle(string $title): ?Ad;
//
//    public function findByLocation(string $location): array;
//
//    public function findByCategory(string $category): array;
//
//    public function findByStatus(string $status): array;
}