<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Entity\Category;
use App\Entity\SymfonyUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\AdService;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;

class AdController extends AbstractController
{
    private AdService $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    #[Route('/ads', name: 'ads', methods: ['GET'])]
    public function getAllAds(SerializerInterface $serializer): Response
    {
        $ads = $this->adService->allAds();

//        foreach ($ads as $ad => $value) {
//
//        }

        $context = [
            AbstractNormalizer::CALLBACKS => [
                'owner' => function ($user) {
                    return [
                        $user->getId(),
                        $user->getUsername(),
                        $user->getCreatedAt()->format('Y-m-d H:i:s'),
                        $user->getPicture()
                    ];
                },
                'category' => function ($category) {
                    return $category->getCategory();
                },
                'adStatus' => function ($status) {
                    return $status->getStatus();
                },
                'createdAt' => function ($createdAt) {
                    return $createdAt->format('Y-m-d H:i:s');
                },
                'updatedAt' => function ($updatedAt) {
                    return $updatedAt->format('Y-m-d H:i:s');
                }
            ],
        ];

        $jsonContent = $serializer->serialize($ads, 'json', $context);

        return new Response($jsonContent, 200);
    }
}
