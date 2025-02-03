<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\ValidationTransactionStatus;

class Transaction
{
    private int $id;
    private User $recipient;
    private Ad $ad;
    private ValidationTransactionStatus $validationStatus;
    private AdStatus $status;

    public function __construct(
        int $id,
        User $recipient,
        Ad $ad,
        ValidationTransactionStatus $validationStatus,
        AdStatus $status
    ) {
        $this->id = $id;
        $this->recipient = $recipient;
        $this->ad = $ad;
        $this->validationStatus = $validationStatus;
        $this->status = $status;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function recipient(): User
    {
        return $this->recipient;
    }

    public function ad(): Ad
    {
        return $this->ad;
    }

    public function validationStatus(): ValidationTransactionStatus
    {
        return $this->validationStatus;
    }

    public function status(): AdStatus
    {
        return $this->status;
    }
}