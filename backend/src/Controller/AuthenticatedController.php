<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\AuthenticatedUserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthenticatedController
{
    private LoggerInterface $logger;
    private AuthenticatedUserService $authenticatedUserService;

    public function __construct(LoggerInterface $logger, AuthenticatedUserService $authenticatedUserService)
    {
        $this->authenticatedUserService = $authenticatedUserService;
        $this->logger = $logger;
    }

    #[Route('/auth/auth_user', name: 'auth_user', methods: ['GET'])]
    public function authenticatedUser(): Response
    {
        $this->logger->info('Session avant récupération: ', [
            'session_id' => session_id(),
            'user_id' => $this->authenticatedUserService->getAuthenticatedUser()
        ]);

        $authenticatedUserDto = $this->authenticatedUserService->getAuthenticatedUser();

        $this->logger->info('Session actuelle:', [
            'session_id' => session_id(),
            'user_id' => $this->authenticatedUserService->getAuthenticatedUser()?->email ?? 'Aucun utilisateur'
        ]);

        $this->logger->info('Received authentication data: ', [$authenticatedUserDto->email, $authenticatedUserDto->roles]);

        if (null === $authenticatedUserDto) {
            $this->logger->error('Invalid JSON');

            return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $content = json_encode([
            'email' => $authenticatedUserDto->email,
            'roles' => $authenticatedUserDto->roles
        ]);

        return new Response($content, Response::HTTP_OK);
    }

}
