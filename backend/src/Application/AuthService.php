<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Exception\InvalidCredentialsException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Security\PasswordHasherInterface;
use App\Application\LoginUserDTO;

class AuthService
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(UserRepositoryInterface $userRepository, PasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function login(LoginUserDTO $loginUserDTO): string
    {
        $user = $this->userRepository->findByEmail($loginUserDTO->email);

        if (!$user || !$this->passwordHasher->verify($loginUserDTO->password, $user->password())) {
            throw new InvalidCredentialsException();
        }

        // Retourner le JWT
        return $user;
    }
}