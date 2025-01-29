<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use RuntimeException;

class InvalidCredentialsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Identifiants incorrects', 401);
    }
}