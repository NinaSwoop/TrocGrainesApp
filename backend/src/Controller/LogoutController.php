<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\LogoutUserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogoutController
{
    private LogoutUserService $logoutUserService;
    public function __construct(LogoutUserService $logoutUserService)
    {
        $this->logoutUserService = $logoutUserService;
    }
    #[Route('/auth/logout', name: 'auth_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        $this->logoutUserService->logout();

        return new JsonResponse('Déconnexion réussie', Response::HTTP_OK);
    }
}
