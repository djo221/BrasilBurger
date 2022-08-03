<?php

namespace App\Entity;

use App\Entity\CommandePortion;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Monolog\DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['commande:read']],
        ],
        "post" => [
            'denormalization_context' => ['groups' => ['commande:write']],
            'normalization_context' => ['groups' => ['commande:write:all']]
        ]
    ],
    itemOperations: [
        "get" => [
             'method' => 'get',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['commande:read:details']], 
        ],
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'normalization_context' => ['groups' => ['all']] 
        ]
    ]

)] 
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["commande:read" ,  "commande:write"])]
    private $etat;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read"  , "commande:write"])]
    private $montant;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    private $zone;
    
    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    #[Groups(["commande:read"  , "commande:write"])]
    private $livraison;
    
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;
    
    #[ORM\ManyToOne(targetEntity: Quartiers::class, inversedBy: 'commandes')]
    #[Groups(["commande:read"  , "commande:write"])]
    private $quartier;


    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBurger::class  , cascade:['persist'])]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $commandeBurgers;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenu::class  , cascade:['persist'])]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $commandeMenus;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeTailleBoisson::class , cascade:['persist'])]
    #[Groups(["commande:read" , "commande:write:all" , "commande:write"])]
    private $commandeTailleBoissons;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandePortion::class  , cascade:['persist'])]
    #[Groups(["commande:write"])]
    private $commandePortions;


    public function __construct()
    {
        $this->commandeTailleBoissons = new ArrayCollection();
        $this->commandePortions = new ArrayCollection();
        $this->commandeBurgers = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
        $this->date= new DateTimeImmutable("now");
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return new DateTimeImmutable("now");
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

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
            $commandeBurger->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if ($this->commandeBurgers->removeElement($commandeBurger)) {
            // set the owning side to null (unless already changed)
            if ($commandeBurger->getCommande() === $this) {
                $commandeBurger->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandeMenus(): Collection
    {
        return $this->commandeMenus;
    }

    public function addCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if (!$this->commandeMenus->contains($commandeMenu)) {
            $this->commandeMenus[] = $commandeMenu;
            $commandeMenu->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getCommande() === $this) {
                $commandeMenu->setCommande(null);
            }
        }

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
            $commandeTailleBoisson->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeTailleBoisson(CommandeTailleBoisson $commandeTailleBoisson): self
    {
        if ($this->commandeTailleBoissons->removeElement($commandeTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeTailleBoisson->getCommande() === $this) {
                $commandeTailleBoisson->setCommande(null);
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
            $commandePortion->setCommande($this);
        }

        return $this;
    }

    public function removeCommandePortion(CommandePortion $commandePortion): self
    {
        if ($this->commandePortions->removeElement($commandePortion)) {
            // set the owning side to null (unless already changed)
            if ($commandePortion->getCommande() === $this) {
                $commandePortion->setCommande(null);
            }
        }

        return $this;
    }

    public function getQuartier(): ?Quartiers
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartiers $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    

    
}
