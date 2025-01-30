<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\LoginUserDto;
use App\Application\LoginUserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class LoginController
{
    private LoginUserService $loginUserService;
    private LoggerInterface $logger;

    public function __construct(LoginUserService $loginUserService, LoggerInterface $logger)
    {
        $this->loginUserService = $loginUserService;
        $this->logger = $logger;
    }

    #[Route('/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        $this->logger->info('Raw request content:', [$request->getContent()]);

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->error('JSON decoding error: ' . json_last_error_msg());
            return new Response('Invalid JSON format', Response::HTTP_BAD_REQUEST);
        }

        $this->logger->info('Received login data: ', $data);

        if (!$data) {
            $this->logger->error('Invalid JSON');

            return new Response('Invalid JSON', Response::HTTP_BAD_REQUEST);
        }

        $loginUserDTO = new LoginUserDTO(
            email: $data['security']['credentials']['email'],
            password: $data['security']['credentials']['password']
        );

        $user = $this->loginUserService->login($loginUserDTO);

        $session->set('user_id', $user->id());
        $session->set('user_email', $user->email());
        $session->set('user_role', $user->roles());

        return new Response('Connexion réussie', Response::HTTP_OK);
    }
}
