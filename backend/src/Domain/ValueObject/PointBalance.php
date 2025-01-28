<?php

namespace App\Domain\ValueObject;

use App\Domain\Model\Point;

class PointBalance
{
    private int $points;

    public function __construct(int $points = Point::DEFAULT->value)
    {
        $this->points = $points;
    }

    public function getValue(): int
    {
        return $this->points;
    }

    public function add(): PointBalance
    {
        return new PointBalance($this->points + Point::TRANSACTION->value);
    }

    public function subtract(): PointBalance
    {
        if (!$this->hasFundsAvailable(Point::TRANSACTION->value)) {
            throw new \InvalidArgumentException('Le solde de points est insuffisant pour cette transaction.');
        }

        return new PointBalance($this->points - Point::TRANSACTION->value);
    }

    public function hasFundsAvailable(int $points): bool
    {
        return $this->points >= $points;
    }
}