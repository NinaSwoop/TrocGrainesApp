<?php

namespace App\Security;

use App\Domain\Security\AuthenticatedUserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SymfonySessionAuthentication implements AuthenticatedUserInterface
{
    private SessionInterface $session;
    private LoggerInterface $logger;

    public function __construct(SessionInterface $session, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->logger = $logger;
    }

    public function getAuthenticatedUserId(): ?int
    {
        $userId = $this->session->get('authenticated_user_id');
        $this->logger->info('Récupération ID utilisateur de la session:', [
            'session_id' => session_id(),
            'user_id' => $userId
        ]);

        return $this->session->get('authenticated_user_id');
    }

    public function setAuthenticatedUserId(int $userId): void
    {
        $this->session->set('authenticated_user_id', $userId);

        $this->logger->info('ID utilisateur stocké en session', [
            'session_id' => session_id(),
            'user_id_stocké' => $this->session->get('authenticated_user_id'),
            'session_data' => $this->session->all()
        ]);
    }

    public function setAuthenticatedUserEmail(string $email): void
    {
        $this->session->set('authenticated_user_email', $email);
    }

    public function setAuthenticatedUserRole(array $role): void
    {
        $this->session->set('authenticated_user_role', $role);
    }

    public function isAuthenticated(): bool
    {
        return $this->session->has('authenticated_user_id');
    }

    public function clearAuthenticatedUser(): void
    {
        $this->session->remove('authenticated_user_id');
    }
}
