<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\DeleteAdService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteAdController
{
    private LoggerInterface $logger;

    private DeleteAdService $deleteAdService;

    public function __construct(LoggerInterface $logger, DeleteAdService $deleteAdService)
    {
        $this->logger = $logger;
        $this->deleteAdService = $deleteAdService;
    }

    #[Route('api/ads/{id}', name: 'ad_delete', methods: ['DELETE'])]
    public function deletedAd(LoggerInterface $logger, int $id): jsonresponse
    {
        $this->deleteAdService->delete($id);

        return new jsonresponse('Ad deleted', Response::HTTP_OK);
    }
}
