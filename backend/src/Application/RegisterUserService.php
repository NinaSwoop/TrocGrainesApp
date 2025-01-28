<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\PointBalance;

class RegisterUserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserDTO $registerUserDTO): void
    {
        $existingUser = $this->userRepository->findByEmail($registerUserDTO->email);
        if ($existingUser !== null) {
            throw new \Exception('User with this email already exists');
        }

        $user = new User(
        id: 0,
        username: $registerUserDTO->username,
        firstname: $registerUserDTO->firstname,
        lastname: $registerUserDTO->lastname,
        email: $registerUserDTO->email,
        birthdate: new \DateTime($registerUserDTO->birthdate),
        picture: $registerUserDTO->picture,
        password: $registerUserDTO->password,
        pointBalance: new PointBalance(3),
        createdAt: new \DateTime(),
        updatedAt: new \DateTime()
        );

        $this->userRepository->add($user);
    }
}