<?php

declare(strict_types=1);

namespace Application;

use App\Application\AdService;
use App\Domain\Model\Ad;
use App\Domain\Model\AdCategory;
use App\Domain\Model\AdStatus;
use App\Domain\Repository\AdRepositoryInterface;
use App\Domain\ValueObject\UserId;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class AllAdsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testAllAds(): void
    {
        $adRepositoryInterfaceStub = $this->createStub(adRepositoryInterface::class);

        $adRepositoryInterfaceStub->method('findAll')
            ->willReturn([
                new Ad(
                    id: 1,
                    title: 'title',
                    description: 'description',
                    location: 'location',
                    category: AdCategory::from('plantes'),
                    status: AdStatus::UNRESERVED,
                    ownerId: new UserId(1),
                    isActivated: true,
                    createdAt: new \DateTimeImmutable(),
                    updatedAt: new \DateTimeImmutable(),
                    picture: 'picture'
                ),
                new Ad(
                    id: 2,
                    title: 'title',
                    description: 'description',
                    location: 'location',
                    category: AdCategory::from('boutures'),
                    status: AdStatus::UNRESERVED,
                    ownerId: new UserId(1),
                    isActivated: true,
                    createdAt: new \DateTimeImmutable(),
                    updatedAt: new \DateTimeImmutable(),
                    picture: 'picture'
                )
            ]);

        $adService = new AdService($adRepositoryInterfaceStub, $logger = null);

        $ads = $adService->allAds();

        $this->assertNotEmpty($ads);
        $this->assertInstanceOf(Ad::class, $ads[0]);

    }
}