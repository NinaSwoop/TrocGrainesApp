<?php

namespace App\Repository;

use App\Domain\Model\User;
use App\Domain\ValueObject\PointBalance;
use App\Domain\Repository\UserRepositoryInterface;
use App\Security\SymfonyUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SymfonyUser>
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SymfonyUser::class);
    }

    //    /**
    //     * @return SymfonyUser[] Returns an array of SymfonyUser objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SymfonyUser
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function add(User $user): void
    {
        $symfonyUser = new SymfonyUser();
        $symfonyUser->setId($user->id());
        $symfonyUser->setUsername($user->username());
        $symfonyUser->setFirstname($user->firstname());
        $symfonyUser->setLastname($user->lastname());
        $symfonyUser->setEmail($user->email());
        $symfonyUser->setBirthdate($user->birthdate());
        $symfonyUser->setPicture($user->picture());
        $symfonyUser->setPassword($user->password());
        $symfonyUser->setPointBalance($user->pointBalance()->getValue());
        $symfonyUser->setRole($user->roles());
        $symfonyUser->setCreatedAt(new \DateTimeImmutable());

        $this->getEntityManager()->persist($symfonyUser);
        $this->getEntityManager()->flush();
    }

    public function update(User $user): void
    {
        $symfonyUser = $this->getEntityManager()
            ->getRepository(SymfonyUser::class)
            ->findOneBy(['id' => $user->id()]);

        if (!$symfonyUser) {
            throw new \RuntimeException('Utilisateur non trouvé en base.');
        }

        $symfonyUser->setUsername($user->username());
        $symfonyUser->setFirstname($user->firstname());
        $symfonyUser->setLastname($user->lastname());
        $symfonyUser->setEmail($user->email());
        $symfonyUser->setBirthdate($user->birthdate());
        $symfonyUser->setPicture($user->picture());
        $symfonyUser->setPassword($user->password());
        $symfonyUser->setPointBalance($user->pointBalance()->getValue());
        $symfonyUser->setRole($user->roles());
        $symfonyUser->setUpdatedAt(new \DateTimeImmutable());

        $this->getEntityManager()->flush();
    }

    public function delete(User $user): void
    {
        $symfonyUser = $this->getEntityManager()
            ->getRepository(SymfonyUser::class)
            ->findOneBy(['id' => $user->id()]);

        if (!$symfonyUser) {
            throw new \RuntimeException('Utilisateur non trouvé en base.');
        }

        $this->getEntityManager()->remove($symfonyUser);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?User
    {
        $symfonyUser = $this->getEntityManager()
            ->getRepository(SymfonyUser::class)
            ->find($id);

        if (!$symfonyUser) {
            return null;
        }

        return new User(
            id: $symfonyUser->getId(),
            username: $symfonyUser->getUsername(),
            firstname: $symfonyUser->getFirstname(),
            lastname: $symfonyUser->getLastname(),
            email: $symfonyUser->getEmail(),
            birthdate: $symfonyUser->getBirthdate(),
            picture: $symfonyUser->getPicture(),
            password: $symfonyUser->getPassword(),
            pointBalance: new PointBalance($symfonyUser->getPointBalance()),
            roles: $symfonyUser->getRoles(),
            createdAt: $symfonyUser->getCreatedAt(),
            updatedAt: $symfonyUser->getUpdatedAt() ?? new \DateTimeImmutable(),
        );
    }

    public function findByEmail(string $email): ?User
    {
        $symfonyUser = $this->getEntityManager()
        ->getRepository(SymfonyUser::class)
        ->findOneBy(['email' => $email]);

        if (!$symfonyUser) {
            return null;
        }

        return new User(
            id: $symfonyUser->getId(),
            username: $symfonyUser->getUsername(),
            firstname: $symfonyUser->getFirstname(),
            lastname: $symfonyUser->getLastname(),
            email: $symfonyUser->getEmail(),
            birthdate: $symfonyUser->getBirthdate(),
            picture: $symfonyUser->getPicture(),
            password: $symfonyUser->getPassword(),
            pointBalance: new PointBalance($symfonyUser->getPointBalance()),
            roles: $symfonyUser->getRoles(),
            createdAt: $symfonyUser->getCreatedAt(),
            updatedAt: $symfonyUser->getUpdatedAt() ?? new \DateTimeImmutable(),
        );
    }
}
