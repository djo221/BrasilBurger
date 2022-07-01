<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(

    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['menu:read:simple']],
        ],
        "post" => [
            'denormalization_context' => ['groups' => ['menu:write']],
            'normalization_context' => ['groups' => ['menu:read:all']]
        ]
    ],
    itemOperations: [
        "get" => [
            /* 'method' => 'get',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['burger:read:all']], */
        ],
        "put" => [
            /* "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'normalization_context' => ['groups' => ['burger:read:all']] */
        ]
    ]

)]
class Menu extends Produit
{

    #[Groups(["menu:write"])]
    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burgers;

    #[Groups(["menu:write"])]
    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    private $portions;

    #[Groups(["menu:write"])]
    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'menus')]
    private $tailles;


    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->portions = new ArrayCollection();
        $this->tailles = new ArrayCollection();
    }



    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortions(): Collection
    {
        return $this->portions;
    }

    public function addPortion(PortionFrite $portion): self
    {
        if (!$this->portions->contains($portion)) {
            $this->portions[] = $portion;
        }

        return $this;
    }

    public function removePortion(PortionFrite $portion): self
    {
        $this->portions->removeElement($portion);

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

        return $this;
    }
}
