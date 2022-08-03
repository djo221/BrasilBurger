<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['burger:read:collection']],
        ],
        "post" => [
            'denormalization_context' => ['groups' => ['burger:write:collection' ]]
        ]
    ],
    itemOperations: [
        "get" => [

            'normalization_context' => ['groups' => ['burger:read:item']],
        ],
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'normalization_context' => ['groups' => ['burger:read:all']]
        ]
    ]
)]
class Burger extends Produit
{   

    #[Groups(["burger:write:collection","burger:read:collection" , "burger:read:item"])]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'burgers', cascade:['persist'])]
    private $user;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: CommandeBurger::class)]
    private $commandeBurgers;

   

    public function __construct()
    {
        $this->menuBurgers = new ArrayCollection();
        $this->commandeBurgers = new ArrayCollection();
        $this->type='burger';
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeBurger>
     */
    public function getCommandeBurgers(): Collection
    {
        return $this->commandeBurgers;
    }

    public function addCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if (!$this->commandeBurgers->contains($commandeBurger)) {
            $this->commandeBurgers[] = $commandeBurger;
            $commandeBurger->setBurger($this);
        }

        return $this;
    }

    public function removeCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if ($this->commandeBurgers->removeElement($commandeBurger)) {
            // set the owning side to null (unless already changed)
            if ($commandeBurger->getBurger() === $this) {
                $commandeBurger->setBurger(null);
            }
        }

        return $this;
    }

   
}
