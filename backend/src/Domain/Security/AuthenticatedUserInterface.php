<?php

declare(strict_types=1);

namespace App\Domain\Security;

interface AuthenticatedUserInterface
{
    public function getAuthenticatedUserId(): ?int;
    public function setAuthenticatedUserId(int $userId): void;
    public function setAuthenticatedUserEmail(string $email): void;
    public function setAuthenticatedUserRole(array $role): void;
    public function isAuthenticated(): bool;
    public function clearAuthenticatedUser(): void;

}