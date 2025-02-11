<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\AdService;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class AdsByOwnerController extends AbstractController
{
    private AdService $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    #[Route('/users/{id}/ads', name: 'ads_by_owner', methods: ['GET'])]
    public function getAdsByOwner(int $id, SerializerInterface $serializer): Response
    {
        $ads = $this->adService->adsByOwner($id);

        $context = [
            AbstractNormalizer::CALLBACKS => [
                'owner' => function ($user) {
                    return $user->getId();
                },
                'category' => function ($category) {
                    return $category->getCategory();
                },
                'adStatus' => function ($status) {
                    return $status->getStatus();
                },
            ],
        ];

        $jsonContent = $serializer->serialize($ads, 'json', $context);

        return new Response($jsonContent, 200);
    }
}
