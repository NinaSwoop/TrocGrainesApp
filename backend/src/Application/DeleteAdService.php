<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Repository\AdRepositoryInterface;
use Psr\Log\LoggerInterface;

class DeleteAdService
{
    private AdRepositoryInterface $adRepository;
    private LoggerInterface $logger;

    public function __construct(AdRepositoryInterface $adRepository, LoggerInterface $logger)
    {
        $this->adRepository = $adRepository;
        $this->logger = $logger;
    }

    public function delete(int $id): void
    {
        $this->adRepository->delete($id);
        $this->logger->info('Ad deleted');
    }

}