<?php
declare(strict_types=1);

namespace App\Application;

use App\Application\AuthenticatedUserDto;
use App\Domain\Security\AuthenticatedUserInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

class AuthenticatedUserService
{
    private AuthenticatedUserInterface $authenticatedUser;
    private UserRepositoryInterface $userRepository;
    private LoggerInterface $logger;

    public function __construct(AuthenticatedUserInterface $authenticatedUser, UserRepositoryInterface $userRepository, LoggerInterface $logger)
    {
        $this->authenticatedUser = $authenticatedUser;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function getAuthenticatedUser(): ?AuthenticatedUserDto
    {
        $userId = $this->authenticatedUser->getAuthenticatedUserId();

        $this->logger->info('User ID : '.$userId);

        if (null === $userId) {
            return null;
        }

        $user = $this->userRepository->findById($userId);

        if (!$user) {
            $this->logger->warning("Aucun utilisateur trouvé pour l'ID : $userId");
            return null;
        }

        $this->logger->info('User : '.$user->email());

        return new AuthenticatedUserDto($user->email(), $user->roles());
    }
}
