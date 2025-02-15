<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;

interface UserRepositoryInterface
{
    public function add(User $user): void;
    public function update(User $user): void;
    public function findByEmail(string $email): ?User;
}


