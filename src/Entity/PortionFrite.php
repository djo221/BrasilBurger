<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations:["get","post"],
    itemOperations:["put","get", "patch"]
)]
class PortionFrite extends Produit
{


    #[ORM\OneToMany(mappedBy: 'portion', targetEntity: MenuPortion::class)]
    private $menuPortions;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: CommandePortion::class)]
    private $commandePortions;


    public function __construct()
    {
        $this->menuTailles = new ArrayCollection();
        $this->menuPortions = new ArrayCollection();
        $this->commandePortions = new ArrayCollection();
        $this->type='portion';
    }

  
    /**
     * @return Collection<int, MenuPortion>
     */
    public function getMenuPortions(): Collection
    {
        return $this->menuPortions;
    }

    public function addMenuPortion(MenuPortion $menuPortion): self
    {
        if (!$this->menuPortions->contains($menuPortion)) {
            $this->menuPortions[] = $menuPortion;
            $menuPortion->setPortion($this);
        }

        return $this;
    }

    public function removeMenuPortion(MenuPortion $menuPortion): self
    {
        if ($this->menuPortions->removeElement($menuPortion)) {
            // set the owning side to null (unless already changed)
            if ($menuPortion->getPortion() === $this) {
                $menuPortion->setPortion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandePortion>
     */
    public function getCommandePortions(): Collection
    {
        return $this->commandePortions;
    }

    public function addCommandePortion(CommandePortion $commandePortion): self
    {
        if (!$this->commandePortions->contains($commandePortion)) {
            $this->commandePortions[] = $commandePortion;
            $commandePortion->setPortionFrite($this);
        }

        return $this;
    }

    public function removeCommandePortion(CommandePortion $commandePortion): self
    {
        if ($this->commandePortions->removeElement($commandePortion)) {
            // set the owning side to null (unless already changed)
            if ($commandePortion->getPortionFrite() === $this) {
                $commandePortion->setPortionFrite(null);
            }
        }

        return $this;
    }

   
}
