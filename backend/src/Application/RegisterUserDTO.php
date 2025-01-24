<?php

namespace App\Application;

use App\Domain\ValueObject\PointBalance;
use DateTime;

class RegisterUserDTO
{
    private string $username;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $birthdate;
    private string $password;
    private string $picture;
    private int $pointBalance;
    private string $role;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(string $username, string $firstname, string $lastname, string $email, string $birthdate, string $password, string $picture, int $pointBalance, string $role, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->password = $password;
        $this->picture = $picture;
        $this->pointBalance = $pointBalance;
        $this->role = $role;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

}