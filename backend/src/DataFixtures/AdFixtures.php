<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Entity\Category;
use App\Entity\SymfonyUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    const string AD_REFERENCE = "ad_";

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AdCategoryFixtures::class,
            AdStatusFixtures::class,
        ];
    }
    public function load(ObjectManager $manager): void
    {
        $adCategories = [
            AdCategoryFixtures::AD_CATEGORY_PLANTS,
            AdCategoryFixtures::AD_CATEGORY_CUTTINGS,
            AdCategoryFixtures::AD_CATEGORY_SEEDS,
            AdCategoryFixtures::AD_CATEGORY_GARDENING_TOOLS,
            AdCategoryFixtures::AD_CATEGORY_CONSUMABLES,
        ];

        for ($i = 0; $i < 10; $i++) {

            $randomOwnerIndex = rand(0, 9);

            $faker = \Faker\Factory::create('fr_FR');
            $ad = new Ad();
            $ad->setTitle($faker->sentence(2));
            $ad->setDescription($faker->sentence(10));
            $ad->setPicture('public/placeholder-ad.jpeg');
            $ad->setLocation($faker->city());
            $ad->setOwner($this->getReference("user_$randomOwnerIndex", SymfonyUser::class));
            $ad->setCategory($this->getReference($adCategories[array_rand($adCategories)], Category::class));
            $ad->setAdStatus($this->getReference(AdStatusFixtures::UNRESERVED_REFERENCE, AdStatus::class));
            $ad->setIsActive(true);
            $ad->setCreatedAt(new \DateTimeImmutable());
            $ad->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($ad);

            $this->addReference(self::AD_REFERENCE . $i, $ad);

        }
        $manager->flush();
    }
}