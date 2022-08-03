<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartiersRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartiersRepository::class)]
#[ApiResource]
class Quartiers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["zone:read:simple", "zone:read:all",  "zone:write" , "commande:write"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["zone:read:simple", "zone:read:all",  "zone:write"])]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'quartier', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setQuartier($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getQuartier() === $this) {
                $commande->setQuartier(null);
            }
        }

        return $this;
    }
}
