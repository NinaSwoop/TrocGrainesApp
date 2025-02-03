<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Ad;
use App\Domain\Model\Transaction;
use App\Domain\Model\TransactionStatus;

interface TransactionRepositoryInterface
{
    public function reservedBySender(Ad $adId, TransactionStatus $status): void;
    public function validateBySender(Ad $adId): void;
    public function validateByRecipient(Ad $adId): void;
    public function canceledBySender(Ad $adId, TransactionStatus $status): void;

}