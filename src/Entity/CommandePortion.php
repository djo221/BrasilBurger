<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandePortionRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandePortionRepository::class)]
#[ApiResource]
class CommandePortion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'commandePortions')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $portionFrite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandePortions')]
    #[Groups(["commande:read" , "commande:write:all"])]
    private $commande;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortionFrite(): ?PortionFrite
    {
        return $this->portionFrite;
    }

    public function setPortionFrite(?PortionFrite $portionFrite): self
    {
        $this->portionFrite = $portionFrite;

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
