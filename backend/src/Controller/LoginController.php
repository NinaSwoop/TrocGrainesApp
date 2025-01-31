<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\LoginUserDto;
use App\Application\LoginUserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Security\AuthenticatedUserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController
{
    private LoginUserService $loginUserService;
    private AuthenticatedUserInterface $authenticatedUser;
    private LoggerInterface $logger;

    public function __construct(LoginUserService $loginUserService, AuthenticatedUserInterface $authenticatedUser,LoggerInterface $logger)
    {
        $this->loginUserService = $loginUserService;
        $this->authenticatedUser = $authenticatedUser;
        $this->logger = $logger;
    }

    #[Route('/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $this->logger->info('Raw request content:', [$request->getContent()]);

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->error('JSON decoding error: ' . json_last_error_msg());
            return new JsonResponse(['message' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['security']['credentials']['email'], $data['security']['credentials']['password'])) {
            $this->logger->error('Missing login credentials');
            return new JsonResponse(['message' => 'Missing email or password'], Response::HTTP_BAD_REQUEST);
        }

        $this->logger->info('Received login data: ', [$data['security']['credentials']['email'], $data['security']['credentials']['password']]);

        $loginUserDTO = new LoginUserDTO(
            email: $data['security']['credentials']['email'],
            password: $data['security']['credentials']['password']
        );

        $authenticatedUserDto = $this->loginUserService->login($loginUserDTO);

        $this->logger->info('Session après login: ', [
            'session_id' => session_id(),
            'user_id' => $this->authenticatedUser->getAuthenticatedUserId()
        ]);

        $content = json_encode([
            'email' => $authenticatedUserDto->email,
            'roles' => $authenticatedUserDto->roles
        ]);

        return new JsonResponse($content, Response::HTTP_OK);
    }
}
