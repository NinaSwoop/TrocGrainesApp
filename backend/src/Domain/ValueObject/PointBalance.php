<?php

namespace App\Domain\ValueObject;

class PointBalance
{
    private int $points;

    // Déplacer dans le modèl avec enum
    public const int TRANSACTION_POINT = 1;
    public const int DEFAULT_POINTS = 3;

    public function __construct(int $points = self::DEFAULT_POINTS)
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

    public function add(): PointBalance
    {
        return new PointBalance($this->points + self::TRANSACTION_POINT);
    }

    public function subtract(): PointBalance
    {
        if (!$this->hasFundsAvailable(self::TRANSACTION_POINT)) {
            throw new \InvalidArgumentException('Le solde de points est insuffisant pour cette transaction.');
        }

        return new PointBalance($this->points - self::TRANSACTION_POINT);
    }

    public function hasFundsAvailable(int $points): bool
    {
        return $this->points >= $points;
    }
}