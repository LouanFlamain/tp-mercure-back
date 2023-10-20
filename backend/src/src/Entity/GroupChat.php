<?php

namespace App\Entity;

use App\Repository\GroupChatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupChatRepository::class)]
class GroupChat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $last_update = null;

    #[ORM\Column(length: 255)]
    private ?string $intervenant = null;

    #[ORM\Column]
    private ?int $last_message = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLastUpdate(): ?\DateTimeImmutable
    {
        return $this->last_update;
    }

    public function setLastUpdate(\DateTimeImmutable $last_update): static
    {
        $this->last_update = $last_update;

        return $this;
    }

    public function getIntervenant(): ?string
    {
        return $this->intervenant;
    }

    public function setIntervenant(string $intervenant): static
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getLastMessage(): ?int
    {
        return $this->last_message;
    }

    public function setLastMessage(int $last_message): static
    {
        $this->last_message = $last_message;

        return $this;
    }

}
