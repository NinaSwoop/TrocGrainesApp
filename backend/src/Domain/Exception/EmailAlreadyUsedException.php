<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class EmailAlreadyUsedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Cet email est déjà utilisé.', 409);
    }
}
