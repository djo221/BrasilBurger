<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["burger" => "Burger", "menu" => "Menu", "boisson" => "Boisson", "portion" => "PortionFrite" ])]

#[ApiResource(

    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['produit:read']],
        ],
        "post" => [
            'normalization_context' => ['groups' => ['produit:write:details']],
            'denormalization_context' => ['groups' => ['produit:write']]
        ]
    ],
    itemOperations: [
        "get" => [
             'method' => 'get',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['produit:read:details']], 
        ],
        "put" => [
             "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'normalization_context' => ['groups' => ['produit:write:all']] 
        ]
    ]

)]
abstract class Produit
{
    #[Groups(["produit:read", "produit:read:details" , "menu:write" ])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    
    #[Groups(["produit:read", "produit:read:details"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    
    #[Groups(["produit:write","produit:read" ,"produit:read:details"])] 
    #[ORM\Column(type: 'blob', nullable: true)]
    private $image;
    


    #[SerializedName("images")]
    #[Groups(["menu:write"])]
    private string $InterseptImage;
  


    #[Groups(["burger:read:simple", "burger:read:all"])]
    #[ORM\Column(type: 'float')]
    private $prix;

   /*  #[Groups([])] */
    #[ORM\Column(type: 'boolean')]
    private $isEtat=true;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class)]
    private $produitCommandes;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

   
    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
    }

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

    public function getImage()
    {
        
        return (is_resource($this->image))? base64_encode(stream_get_contents($this->image)):$this->image ;
    }

    public function setImage($image): self
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

    /**
     * @return Collection<int, ProduitCommande>
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

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
     * Get the value of InterseptImage
     */ 
    public function getInterseptImage()
    {
        return $this->InterseptImage;
    }

    /**
     * Set the value of InterseptImage
     *
     * @return  self
     */ 
    public function setInterseptImage($InterseptImage)
    {
        $this->InterseptImage = $InterseptImage;

        return $this;
    }
}
