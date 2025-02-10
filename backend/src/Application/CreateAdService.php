<?php
declare(strict_types=1);
namespace App\Application;

use App\Domain\Model\Ad;
use App\Domain\Model\AdCategory;
use App\Domain\Model\AdStatus;
use App\Domain\Repository\AdRepositoryInterface;
use App\Domain\ValueObject\UserId;
use Psr\Log\LoggerInterface;

class CreateAdService
{
    private AdRepositoryInterface $adRepository;
    private LoggerInterface $logger;

    public function __construct(AdRepositoryInterface $adRepository, LoggerInterface $logger)
    {
        $this->adRepository = $adRepository;
        $this->logger = $logger;
    }

    public function create(InputAdDto $inputAdDto): void
    {

        $adDomain = new Ad(
            id: 1,
            title: $inputAdDto->title,
            description: $inputAdDto->description,
            location: $inputAdDto->location,
            category: AdCategory::from($inputAdDto->category),
            status: AdStatus::UNRESERVED,
            ownerId: new UserId($inputAdDto->owner),
            isActivated: true,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
            picture: $inputAdDto->pictureUrl
        );

        $this->adRepository->add($adDomain);
        $this->logger->info('Ad created');
    }

}