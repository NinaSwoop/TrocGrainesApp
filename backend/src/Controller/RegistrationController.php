<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\RegisterUserDto;
use App\Application\RegisterUserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController
{
    private RegisterUserService $registerUserService;
    private LoggerInterface $logger;

    public function __construct(RegisterUserService $registerUserService, LoggerInterface $logger)
    {
        $this->registerUserService = $registerUserService;
        $this->logger = $logger;
    }

    #[Route('/auth/register', name: 'auth_register', methods: ['POST', 'GET'])]
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->logger->info('Received registration data: ', $data);

        if (!$data) {
            $this->logger->error('Invalid JSON');

            return new Response('Invalid JSON', Response::HTTP_BAD_REQUEST);
        }

        $registerUserDTO = new RegisterUserDto(
            username: $data['username'],
            firstname: $data['firstname'],
            lastname: $data['lastname'],
            email: $data['email'],
            birthdate: $data['birthdate'],
            password: $data['password'],
            picture: $data['pictureUrl'],
            pointBalance: 3,
            createdAt: new \DateTime(),
            updatedAt: new \DateTime(),
        );

        $this->registerUserService->register($registerUserDTO);

        $status = Response::HTTP_CREATED;

        return new Response('user created', $status);
    }
}
