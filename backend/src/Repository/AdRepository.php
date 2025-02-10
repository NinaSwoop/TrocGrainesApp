<?php

namespace App\Repository;

use App\Domain\Repository\AdRepositoryInterface;
use App\Entity\Ad;
use App\Domain\Model\Ad as AdModel;
use App\Entity\AdStatus;
use App\Entity\Category;
use App\Entity\SymfonyUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AdStatusRepository;

/**
 * @extends ServiceEntityRepository<Ad>
 */
class AdRepository extends ServiceEntityRepository implements AdRepositoryInterface
{
    private AdStatusRepository $adStatusRepository;
    private CategoryRepository $categoryRepository;
    public function __construct(ManagerRegistry $registry, AdStatusRepository $adStatusRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct($registry, Ad::class);
        $this->adStatusRepository = $adStatusRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('ad')
            ->where('ad.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('ad.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Ad[] Returns an array of Ad objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ad
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @throws ORMException
     */
    public function add(AdModel $ad): void
    {
        // On convertit l'objet Domain en entité
        $adEntity = new Ad();
        $adEntity->setTitle($ad->title());
        $adEntity->setDescription($ad->description());
        $adEntity->setPicture($ad->picture());
        $adEntity->setLocation($ad->location());
        $ownerIdValue = $ad->owner()->id();
        $symfonyUser = $this->getEntityManager()->getReference(SymfonyUser::class, $ownerIdValue);
        $adEntity->setOwner($symfonyUser);

        $categoryId = $this->categoryRepository->findOneBySomeField($ad->category()->value);
        $category = $this->getEntityManager()->getReference(Category::class, $categoryId->getId());
        $adEntity->setCategory($category);

        $statusId = $this->adStatusRepository->findOneBySomeField('unreserved');
        $adStatus = $this->getEntityManager()->getReference(AdStatus::class, $statusId->getId());

        $adEntity->setAdStatus($adStatus);

        $adEntity->setIsActive(true);
        $adEntity->setCreatedAt($ad->createdAt());
        $adEntity->setUpdatedAt($ad->updatedAt());

        $this->getEntityManager()->persist($adEntity);
        $this->getEntityManager()->flush();
    }
}
