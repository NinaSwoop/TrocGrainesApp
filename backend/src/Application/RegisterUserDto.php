<?php

namespace App\Application;

class RegisterUserDto
{
    public string $username;
    public string $firstname;
    public string $lastname;

    public string $email;
    public string $birthdate;

    public string $password;
    public ?string $picture = null;
    public int $pointBalance;

    public string $role;
    public \DateTime $createdAt;
    public \DateTime $updatedAt;

    public function __construct(
        string $username,
        string $firstname,
        string $lastname,
        string $email,
        string $birthdate,
        string $password,
        int $pointBalance,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        ?string $picture = null)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->password = $password;
        $this->picture = $picture;
        $this->pointBalance = $pointBalance;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
