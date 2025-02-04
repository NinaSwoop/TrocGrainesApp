<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Domain\Model\User;
use App\Domain\ValueObject\PointBalance;
use App\Entity\SymfonyUser;
use App\Security\SecurityUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const string USER_REFERENCE = 'user_';
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $faker = \Faker\Factory::create('fr_FR');
            $user = new SymfonyUser();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setUsername($faker->userName());
            $user->setEmail($faker->email());
            $user->setPassword('');
            $user->setBirthdate($faker->dateTimeThisCentury());
            $user->setPicture('public/placeholder-avatar.jpg');
            $user->setPointBalance(3);
            $user->setRole(['ROLE_USER']);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());

            $domainUser = new User(
                id: 1,
                username: $user->getUsername(),
                firstname: $user->getFirstname(),
                lastname: $user->getLastname(),
                email: $user->getEmail(),
                birthdate: new \DateTime,
                picture: $user->getPicture(),
                password: '',
                pointBalance: new PointBalance($user->getPointBalance()),
                roles: $user->getRoles(),
                createdAt: new \DateTimeImmutable(),
                updatedAt: new \DateTimeImmutable(),
            );

            $hashedPassword = $this->passwordHasher->hashPassword(new SecurityUser($domainUser), $faker->password());
            $user->setPassword($hashedPassword);

            $manager->persist($user);

            $this->addReference(self::USER_REFERENCE . $i, $user);
        }
        $manager->flush();
    }
}