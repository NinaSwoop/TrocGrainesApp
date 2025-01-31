<?php

declare(strict_types=1);

namespace App\Application;

class AuthenticatedUserDto
{
    public string $email;
    public array $roles;

    public function __construct(string $email, array $roles)
    {
        $this->email = $email;
        $this->roles = $roles;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function roles(): array
    {
        return $this->roles;
    }
}