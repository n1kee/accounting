<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Index(name: 'client_id_index', fields: ['CLIENT_ID'])]
#[ORM\Index(name: 'data_index', fields: ['DATA'])]
#[ORM\Index(name: 'summa_index', fields: ['SUMMA'])]
#[ORM\Index(name: 'pay_id_index', fields: ['PAY_ID'])]
#[ORM\Index(name: 'acnt_id_index', fields: ['ACNT_ID'])]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $CLIENT_ID = null;

    #[ORM\Column]
    private ?float $SUMMA = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATA = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $DESCRIPTION = null;

    #[ORM\Column]
    private ?int $ACNT_ID = null;

    #[ORM\Column]
    private ?int $PAY_ID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCLIENTID(): ?int
    {
        return $this->CLIENT_ID;
    }

    public function setCLIENTID(int $clientId): static
    {
        $this->CLIENT_ID = $clientId;

        return $this;
    }

    public function getSUMMA(): ?float
    {
        return $this->SUMMA;
    }

    public function setSUMMA(float $summa): static
    {
        $this->SUMMA = $summa;

        return $this;
    }

    public function getDATA(): ?\DateTimeInterface
    {
        return $this->DATA;
    }

    public function setDATA(\DateTimeInterface $data): static
    {
        $this->DATA = $data;

        return $this;
    }

    public function getDESCRIPTION(): ?string
    {
        return $this->DESCRIPTION;
    }

    public function setDESCRIPTION(?string $description): static
    {
        $this->DESCRIPTION = $description;

        return $this;
    }

    public function getACNTID(): ?int
    {
        return $this->ACNT_ID;
    }

    public function setACNTID(int $acntId): static
    {
        $this->ACNT_ID = $acntId;

        return $this;
    }

    public function getPAYID(): ?int
    {
        return $this->PAY_ID;
    }

    public function setPAYID(int $payId): static
    {
        $this->PAY_ID = $payId;

        return $this;
    }
}
