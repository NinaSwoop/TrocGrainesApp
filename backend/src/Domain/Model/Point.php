<?php

declare(strict_types=1);

namespace App\Domain\Model;

enum Point: int
{
    case DEFAULT = 3;
    case TRANSACTION = 1;
}
