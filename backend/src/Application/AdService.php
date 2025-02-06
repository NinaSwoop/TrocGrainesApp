<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Model\AdStatus;
use App\Domain\Repository\AdRepositoryInterface;
use App\Domain\ValueObject\PointBalance;
use Psr\Log\LoggerInterface;
use App\Domain\Model\User;
use App\Domain\Model\AdCategory;

class AdService
{
    private AdRepositoryInterface $adRepository;
    private LoggerInterface $logger;

    public function __construct(AdRepositoryInterface $adRepository, LoggerInterface $logger)
    {
        $this->adRepository = $adRepository;
        $this->logger = $logger;
    }

    public function allAds(): array
    {
        $ads = $this->adRepository->findAll();

        if (empty($ads)) {
            $this->logger->warning('Aucune annonce trouvée');
        }

        return $ads;
    }
}
