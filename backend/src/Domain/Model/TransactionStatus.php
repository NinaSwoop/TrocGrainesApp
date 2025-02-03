<?php
declare(strict_types=1);

namespace App\Domain\Model;

enum TransactionStatus
{
    case PENDING;
    case DONE;
    case CANCELLED;
}