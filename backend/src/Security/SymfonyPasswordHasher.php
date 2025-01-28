<?php

declare(strict_types=1);

namespace App\Security;

use App\Domain\Security\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SymfonyPasswordHasher implements PasswordHasherInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function hash(string $password): string
    {
        return $this->passwordHasher->hashPassword(new SymfonyUser(), $password);
    }

    public function verify(string $password, string $hashedPassword): bool
    {
        return $this->passwordHasher->isPasswordValid(new SymfonyUser(), $password, $hashedPassword);
    }
}