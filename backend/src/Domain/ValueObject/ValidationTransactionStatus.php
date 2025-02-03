<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class ValidationTransactionStatus
{
    private bool $isValidatedBySender;
    private bool $isValidatedByRecipient;

    public function __construct(bool $isValidatedBySender, bool $isValidatedByRecipient)
    {
        $this->isValidatedBySender = $isValidatedBySender;
        $this->isValidatedByRecipient = $isValidatedByRecipient;
    }

    public function isValidatedBySender(): bool
    {
        return $this->isValidatedBySender;
    }

    public function isValidatedByRecipient(): bool
    {
        return $this->isValidatedByRecipient;
    }

    public function validateBySender(): ValidationTransactionStatus
    {
        return new ValidationTransactionStatus(true, $this->isValidatedByRecipient);
    }

    public function validateByRecipient(): ValidationTransactionStatus
    {
        return new ValidationTransactionStatus($this->isValidatedBySender, true);
    }

    public function isValidated(): bool
    {
        return $this->isValidatedBySender && $this->isValidatedByRecipient;
    }
}