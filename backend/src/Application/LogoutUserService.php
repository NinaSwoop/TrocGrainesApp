<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Security\AuthenticatedUserInterface;

class LogoutUserService
{
    private AuthenticatedUserInterface $authenticatedUser;

    public function __construct(AuthenticatedUserInterface $authenticatedUser)
    {
        $this->authenticatedUser = $authenticatedUser;
    }

    public function logout(): void
    {
        $this->authenticatedUser->clearAuthenticatedUser();
    }
}