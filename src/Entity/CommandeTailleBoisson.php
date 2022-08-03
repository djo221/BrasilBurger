<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeTailleBoissonRepository::class)]
#[ApiResource]
class CommandeTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'commandeTailleBoissons' , cascade:['persist'])]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $tailleboisson;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeTailleBoissons')]
    private $commande;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTailleboisson(): ?TailleBoisson
    {
        return $this->tailleboisson;
    }

    public function setTailleboisson(?TailleBoisson $tailleboisson): self
    {
        $this->tailleboisson = $tailleboisson;

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
