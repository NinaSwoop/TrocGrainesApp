<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;
interface UserRepositoryInterface
{
    public function create(User $user): void;
    public function update(User $user): void;
    public function delete(User $user): void;
    public function findAll(): array;
    public function findUserById(int $id): ?User;
}