<?php

declare(strict_types=1);

namespace App\Security;


use App\Domain\Security\PasswordHasherInterface;
use App\Domain\ValueObject\PointBalance;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Domain\Model\User;

class SymfonyPasswordHasher implements PasswordHasherInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private LoggerInterface $logger;

    public function __construct(UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
    }

    public function hash(string $password): string
    {

        $user = new SecurityUser(
            new User(
                id: 1,
                username: 'test',
                firstname: 'test',
                lastname: 'test',
                email: 'test@example.com',
                birthdate: new \DateTime(),
                picture: "test",
                password: '',
                pointBalance: new PointBalance(3),
                roles: ['ROLE_USER'],
                createdAt: new \DateTimeImmutable(),
                updatedAt: new \DateTimeImmutable(),
            )
        );

        return $this->passwordHasher->hashPassword($user, $password);
    }

    public function verify(string $password, string $hashedPassword): bool
    {
        $user = new SecurityUser(
            new User(
                id: 1,
                username: 'test',
                firstname: 'test',
                lastname: 'test',
                email: 'test@example.com',
                birthdate: new \DateTime(),
                picture: "test",
                password: $hashedPassword,
                pointBalance: new PointBalance(3),
                roles: ['ROLE_USER'],
                createdAt: new \DateTimeImmutable(),
                updatedAt: new \DateTimeImmutable(),
            )
        );

        $isValid = $this->passwordHasher->isPasswordValid($user, $password);

        $this->logger->info('Mot de passe valide : '.$isValid);

        return $isValid;
    }
}
