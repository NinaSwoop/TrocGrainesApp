<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Exception\EmailAlreadyUsedException;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Security\PasswordHasherInterface;
use App\Domain\ValueObject\PointBalance;

class RegisterUserService
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(UserRepositoryInterface $userRepository, PasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function register(RegisterUserDto $registerUserDTO): void
    {
        if ($this->userRepository->findByEmail($registerUserDTO->email) instanceof User) {
            throw new EmailAlreadyUsedException();
        }

        $hashedPassword = $this->passwordHasher->hash($registerUserDTO->password);

        $user = new User(
            id: 0,
            username: $registerUserDTO->username,
            firstname: $registerUserDTO->firstname,
            lastname: $registerUserDTO->lastname,
            email: $registerUserDTO->email,
            birthdate: new \DateTime($registerUserDTO->birthdate),
            picture: $registerUserDTO->picture,
            password: $hashedPassword,
            pointBalance: new PointBalance(3),
            roles: ['ROLE_USER'],
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable()
        );

        $this->userRepository->add($user);
    }
}
