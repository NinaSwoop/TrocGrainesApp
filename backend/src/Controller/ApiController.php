<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiController
{
    #[Route('/home', name: 'home')]
    public function test(): JsonResponse
    {
        return new JsonResponse(['message' => 'Hello from backend']);
    }
}