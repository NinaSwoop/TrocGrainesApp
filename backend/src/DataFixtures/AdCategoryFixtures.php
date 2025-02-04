<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdCategoryFixtures extends Fixture implements DependentFixtureInterface
{

    public const string AD_CATEGORY_PLANTS = 'plants';
    public const string AD_CATEGORY_CUTTINGS = 'cuttings';
    public const string AD_CATEGORY_SEEDS = 'seeds';
    public const string AD_CATEGORY_GARDENING_TOOLS = 'gardening_tools';
    public const string AD_CATEGORY_CONSUMABLES = 'consumables';

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
    public function load(ObjectManager $manager): void
    {
        $adCategories = [
            self::AD_CATEGORY_PLANTS,
            self::AD_CATEGORY_CUTTINGS,
            self::AD_CATEGORY_SEEDS,
            self::AD_CATEGORY_GARDENING_TOOLS,
            self::AD_CATEGORY_CONSUMABLES,
        ];

        foreach ($adCategories as $adCategory) {
            $category = new Category();
            $category->setCategory($adCategory);
            $manager->persist($category);

            $this->addReference($adCategory, $category);

        }
        $manager->flush();
    }
}