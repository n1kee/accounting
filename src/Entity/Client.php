<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Type\ClientTypes;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`client`')]
#[ORM\Index(name: 'type_index', fields: ['TYPE'])]
class Client
{
    public const TYPES = ClientTypes::class;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $NAME = null;

    #[ORM\Column]
    private ?int $TYPE = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNAME(): ?string
    {
        return $this->NAME;
    }

    public function setNAME(string $name): static
    {
        $this->NAME = $name;

        return $this;
    }

    public function getTYPE(): ?int
    {
        return $this->TYPE;
    }

    public function setTYPE(int $type): static
    {
        $this->TYPE = $type;

        return $this;
    }
}
