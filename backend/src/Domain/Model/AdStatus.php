<?php

declare(strict_types=1);

namespace App\Domain\Model;
enum AdStatus: string
{
    case UNRESERVED = 'unreserved';
    case RESERVED = 'reserved';
}
