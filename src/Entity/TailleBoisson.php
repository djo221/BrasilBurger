<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
class TailleBoisson
{
    #[Groups(["commande:read" , "commande:write:all" , "commande:write","detail:read:item" ])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["commande:read" , "commande:write:all" , "commande:write","detail:read:item" ])]
    #[ORM\Column(type: 'integer')]
    private $stock;

    //on ne normalise pas ici pour eviter la reference circulaire
    // parcqu'on est deja dans taille 
    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleBoissons')]
    private $taille;

    #[Groups(["detail:read:item" ])]
    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleBoissons' )]
    private $boisson;

    #[ORM\OneToMany(mappedBy: 'tailleboisson', targetEntity: CommandeTailleBoisson::class)]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $commandeTailleBoissons;

    public function __construct()
    {
        $this->commandeTailleBoissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    /**
     * @return Collection<int, CommandeTailleBoisson>
     */
    public function getCommandeTailleBoissons(): Collection
    {
        return $this->commandeTailleBoissons;
    }

    public function addCommandeTailleBoisson(CommandeTailleBoisson $commandeTailleBoisson): self
    {
        if (!$this->commandeTailleBoissons->contains($commandeTailleBoisson)) {
            $this->commandeTailleBoissons[] = $commandeTailleBoisson;
            $commandeTailleBoisson->setTailleboisson($this);
        }

        return $this;
    }

    public function removeCommandeTailleBoisson(CommandeTailleBoisson $commandeTailleBoisson): self
    {
        if ($this->commandeTailleBoissons->removeElement($commandeTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeTailleBoisson->getTailleboisson() === $this) {
                $commandeTailleBoisson->setTailleboisson(null);
            }
        }

        return $this;
    }
}
