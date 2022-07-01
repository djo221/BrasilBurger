<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["burger" => "Burger", "menu" => "Menu", "boisson" => "Boisson", "portion" => "PortionFrite" ])]
abstract class Produit
{
    #[Groups(["burger:read:simple", "burger:read:all", "menu:write" , "menu:read:all"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["burger:read:simple", "burger:read:all", "write" , "complement:read:simple", "menu:write", "menu:read:all"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'object', nullable: true)]
    private $image;

    #[Groups(["burger:read:simple", "burger:read:all" , "write", "complement:read:simple" , "menu:write", "menu:read:all"])]
    #[ORM\Column(type: 'float')]
    private $prix;

    #[Groups(["burger:read:all"])]
    #[ORM\Column(type: 'boolean')]
    private $isEtat=true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?object
    {
        return $this->image;
    }

    public function setImage(object $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }
}
