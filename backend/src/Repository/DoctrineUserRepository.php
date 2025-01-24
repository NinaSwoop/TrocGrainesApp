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
        parent::__construct($registry, User::class);
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
    public function register(User $user): void
    {
        // TODO: Implement register() method.
    }

    public function update(User $user): void
    {
        // TODO: Implement update() method.
    }

    public function delete(User $user): void
    {
        // TODO: Implement delete() method.
    }

    public function findUserById(int $id): ?User
    {
        // TODO: Implement findUserById() method.
    }

    public function findUserByEmail(string $email): ?User
    {
        // TODO: Implement findUserByEmail() method.
    }

    public function findUserByUsername(string $username): ?User
    {
        // TODO: Implement findUserByUsername() method.
    }
}
