<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuPortionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuPortionRepository::class)]
#[ApiResource]
class MenuPortion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:write"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:write"])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'menuPortions')]
    #[Groups(["menu:write"])]
    private $portion;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuPortions')]
    private $menu;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getPortion(): ?PortionFrite
    {
        return $this->portion;
    }

    public function setPortion(?PortionFrite $portion): self
    {
        $this->portion = $portion;

        return $this;
    }
}
