<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\CreateAdService;
use App\Application\InputAdDto;
use App\Domain\ValueObject\UserId;
use App\Entity\Ad;
use App\Entity\SymfonyUser;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CreateAdController
{
    private LoggerInterface $logger;

    private CreateAdService $createAdService;

    public function __construct(LoggerInterface $logger, CreateAdService $createAdService)
    {
        $this->logger = $logger;
        $this->createAdService = $createAdService;
    }
    #[Route('api/ads', name: 'ad_create', methods: ['POST'])]
    public function createAd(Request $request, SerializerInterface $serializer, LoggerInterface $logger) : jsonresponse
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $jsonData = $request->getContent();

        $ad = $serializer->deserialize($jsonData, InputAdDto::class, 'json');

       $this->createAdService->create($ad);

        return new jsonresponse('Ad created', Response::HTTP_CREATED);
    }
}
