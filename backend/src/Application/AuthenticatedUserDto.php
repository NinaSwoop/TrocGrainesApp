<?php

declare(strict_types=1);

namespace App\Application;

class AuthenticatedUserDto
{
    public string $email;
    public array $roles;
    public int $id;
    public int $point_balance;
    public string $username;

    public function __construct(string $email, array $roles, int $id, int $point_balance, string $username)
    {
        $this->email = $email;
        $this->roles = $roles;
        $this->id = $id;
        $this->point_balance = $point_balance;
        $this->username = $username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function point_balance(): int
    {
        return $this->point_balance;
    }

    public function username(): string
    {
        return $this->username;
    }
}