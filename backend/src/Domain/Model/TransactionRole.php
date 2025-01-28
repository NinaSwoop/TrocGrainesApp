<?php
declare(strict_types=1);

namespace App\Domain\Model;

enum TransactionRole
{
    case SENDER;
    case RECIPIENT;
}