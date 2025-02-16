<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Repository\AdRepositoryInterface;
use Psr\Log\LoggerInterface;

class AdService
{
    private AdRepositoryInterface $adRepository;
    private ?LoggerInterface $logger;

    public function __construct(AdRepositoryInterface $adRepository, ?LoggerInterface $logger)
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

    public function AdsByOwner(int $id): array
    {
        $adsByOwner = $this->adRepository->findByOwner($id);

        if (empty($adsByOwner)) {
            $this->logger->warning('Aucune annonce trouvée');
        }

        return $adsByOwner;
    }
}
