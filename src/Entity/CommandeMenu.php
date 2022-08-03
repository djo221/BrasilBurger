<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeMenuRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: CommandeMenuRepository::class)]
#[ApiResource]
class CommandeMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'commandeMenus')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeMenus')]
    private $commande;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
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
