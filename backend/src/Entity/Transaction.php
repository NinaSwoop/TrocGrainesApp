<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?SymfonyUser $recipient = null;

    #[ORM\OneToOne(inversedBy: 'transaction', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ad $ad = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?TransactionStatus $transaction_status = null;

    #[ORM\Column]
    private ?bool $is_validate_by_recipient = null;

    #[ORM\Column]
    private ?bool $is_validate_by_sender = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTransactionStatus(): ?TransactionStatus
    {
        return $this->transaction_status;
    }

    public function setTransactionStatus(?TransactionStatus $transaction_status): static
    {
        $this->transaction_status = $transaction_status;

        return $this;
    }

    public function isValidateByRecipient(): ?bool
    {
        return $this->is_validate_by_recipient;
    }

    public function setIsValidateByRecipient(bool $is_validate_by_recipient): static
    {
        $this->is_validate_by_recipient = $is_validate_by_recipient;

        return $this;
    }

    public function isValidateBySender(): ?bool
    {
        return $this->is_validate_by_sender;
    }

    public function setIsValidateBySender(bool $is_validate_by_sender): static
    {
        $this->is_validate_by_sender = $is_validate_by_sender;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getRecipient(): ?SymfonyUser
    {
        return $this->recipient;
    }

    public function setRecipient(?SymfonyUser $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(Ad $ad): static
    {
        $this->ad = $ad;

        return $this;
    }
}
