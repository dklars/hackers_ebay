<?php

namespace App\Entity;

use App\Repository\LinkTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkTypeRepository::class)]
class LinkType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nameLink;

    #[ORM\Column(type: 'string', length: 255)]
    private $domaineLink;

    public function __toString()
    {
        return $this->nameLink;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameLink(): ?string
    {
        return $this->nameLink;
    }

    public function setNameLink(string $nameLink): self
    {
        $this->nameLink = $nameLink;

        return $this;
    }

    public function getDomaineLink(): ?string
    {
        return $this->domaineLink;
    }

    public function setDomaineLink(string $domaineLink): self
    {
        $this->domaineLink = $domaineLink;

        return $this;
    }
}
