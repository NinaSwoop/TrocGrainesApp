<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class LogoutController
{
    #[Route('/auth/logout', name: 'auth_logout', methods: ['POST'])]
    public function logout(SessionInterface $session): Response
    {
        $session->invalidate();

        return new Response('Déconnexion réussie', Response::HTTP_OK);
    }
}
