<?php

declare(strict_types=1);

namespace App\Application;

class LoginUserService
{
    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginUserDto $loginUserDto): string
    {
        return $this->authService->login($loginUserDto);
    }
}