<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\LoginUserService;
use App\Application\LoginUserDTO;
use App\Domain\Exception\InvalidCredentialsException;

class LoginController
{
    private LoginUserService $loginUserService;
    private LoggerInterface $logger;

    public function __construct(LoginUserService $loginUserService, LoggerInterface $logger)
    {
        $this->loginUserService = $loginUserService;
        $this->logger = $logger;
    }

    #[Route("/auth/login", name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->logger->info('Received login data: ', $data);

        if (!$data) {
            $this->logger->error('Invalid JSON');
            return new Response('Invalid JSON', Response::HTTP_BAD_REQUEST);
        }

        $loginUserDTO = new LoginUserDTO(
            email: $data['email'],
            password: $data['password']
        );

        $jwt = $this->loginUserService->login($loginUserDTO);

        return new Response($jwt, Response::HTTP_OK);
    }

}