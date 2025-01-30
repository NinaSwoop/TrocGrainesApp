<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Exception\InvalidCredentialsException;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Security\PasswordHasherInterface;
use Psr\Log\LoggerInterface;

class LoginUserService
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;
    private LoggerInterface $logger;

    public function __construct(UserRepositoryInterface $userRepository, PasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
    }

    public function login(LoginUserDTO $loginUserDTO): User
    {
        $this->logger->info('Tentative de connexion pour : '.$loginUserDTO->email);

        $user = $this->userRepository->findByEmail($loginUserDTO->email);

        $this->logger->info('Utilisateur trouvé : '.$user->email());

        if (!$this->passwordHasher->verify($loginUserDTO->password, $user->password())) {
            $this->logger->error('Mot de passe incorrect pour : '.$user->email());
            throw new InvalidCredentialsException();
        }

        $this->logger->info('Connexion réussie pour : '.$user->email());

        return $user;
    }
}
