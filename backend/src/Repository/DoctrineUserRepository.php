<?php

namespace App\Repository;

use App\Domain\Model\User;
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
        $symfonyUser->setPointBalance(3);
        $symfonyUser->setRole($symfonyUser->getRoles());
        $symfonyUser->setCreatedAt(new \DateTimeImmutable());

        $this->getEntityManager()->persist($symfonyUser);
        $this->getEntityManager()->flush();

    }

    public function update(User $user): void
    {
        // TODO: Implement update() method.
    }

    public function delete(User $user): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(int $id): ?User
    {
        // TODO: Implement findById() method.
    }

    public function findByEmail(string $email): ?SymfonyUser
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Security\SymfonyUser u
                WHERE u.email = :query'
        )
            ->setParameter('query', $email)
            ->getOneOrNullResult();
    }

    public function findByUsername(string $username): ?User
    {
        // TODO: Implement findByUsername() method.
    }
}
