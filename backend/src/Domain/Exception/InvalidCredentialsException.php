<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class InvalidCredentialsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Identifiants incorrects', 401);
    }
}
