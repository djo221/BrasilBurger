<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeBurgerRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeBurgerRepository::class)]
#[ApiResource]
class CommandeBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:write"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeBurgers')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'commandeBurgers')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $burger;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
