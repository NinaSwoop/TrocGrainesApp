<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\AdStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdStatusFixtures extends Fixture implements DependentFixtureInterface
{
    public const string UNRESERVED_REFERENCE = 'unreserved';
    public const string RESERVED_REFERENCE = 'reserved';

    public function getDependencies(): array
    {
        return [
            AdCategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $adStatuses = [
            self::UNRESERVED_REFERENCE,
            self::RESERVED_REFERENCE,
        ];

        foreach ($adStatuses as $adStatus){
            $status = new AdStatus();
            $status->setStatus($adStatus);
            $manager->persist($status);

            $this->addReference($adStatus, $status);
        }
        $manager->flush();
    }
}