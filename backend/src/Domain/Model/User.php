<?php

namespace App\Domain\Model;

use App\Domain\ValueObject\PointBalance;

class User
{
    private int $id;
    private string $username;
    private string $firstname;
    private string $lastname;
    private string $email;
    private \DateTime $birthdate;
    private string $picture;
    private string $password;
    private PointBalance $pointBalance;
    private TransactionRole $transactionRole;

    private array $roles;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $username,
        string $firstname,
        string $lastname,
        string $email,
        \DateTime $birthdate,
        string $picture,
        string $password,
        PointBalance $pointBalance,
        array $roles,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->picture = $picture;
        $this->password = $password;
        $this->pointBalance = $pointBalance;
        $this->roles = $roles;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function birthdate(): \DateTime
    {
        return $this->birthdate;
    }

    public function picture(): string
    {
        return $this->picture;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function pointBalance(): PointBalance
    {
        return $this->pointBalance;
    }

    public function transactionRole(): TransactionRole
    {
        return $this->transactionRole;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    //    public function earnPoints() : void {
    //
    //    }
}
