<?php

namespace App\Domain\ValueObject;

class PointBalance
{
    private int $points;
    public const int TRANSACTION_POINT = 1;

    public function __construct(int $points)
    {
        if ($points < 0) {
            throw new \InvalidArgumentException('Le solde de points ne peut pas être négatif.');
        }
        $this->points = $points;
    }

    public function getValue(): int
    {
        return $this->points;
    }

    public function add(): self
    {
        return new self($this->points + self::TRANSACTION_POINT);
    }

    public function subtract(): self
    {
        if ($this->hasSufficientBalance()) {
            return new self($this->points - self::TRANSACTION_POINT);
        }
        return $this;
    }

    public function hasSufficientBalance(): bool
    {
        if ($this->points <= 0) {
            throw new \InvalidArgumentException('Le solde de points ne peut pas être négatif.');
        }
        return true;
    }
}
