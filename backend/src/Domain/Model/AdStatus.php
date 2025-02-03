<?php

declare(strict_types=1);

namespace App\Domain\Model;
enum AdStatus
{
    case UNRESERVED;
    case RESERVED;
}
