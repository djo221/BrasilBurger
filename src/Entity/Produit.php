<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
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
            'normalization_context' => ['groups' => ['produit:read:item']], 
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
    #[Groups(["produit:read", "produit:read:item" , "menu:write:collection" , "commande:read" , "commande:write" , "catalogue:read:collection" , "detail:read:item"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    
    #[Groups([ "menu:write:collection","burger:write:collection","menu:read:collection" , "burger:read:collection","produit:read", "produit:read:details" , "commande:read", "catalogue:read:collection" , "detail:read:item"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    
   // #[Groups(["produit:read","produit:read:details" , "menu:read:collection" , "produit:read:item" , "burger:read:item" , "burger:read:collection" , "catalogue:read:collection" , "detail:read:item"])] 
    #[ORM\Column(type: 'blob', nullable: true)]
    private $image;
    


    #[SerializedName("images")] 
    #[Groups(["menu:write:collectibon" ,"menu:read:collection" , "burger:write:collection"])]
    private string $InterseptImage = "";
  


    #[Groups(["burger:write:collection","burger:read:item", "burger:read:collection" , "menu:read:collection",  "catalogue:read:collection" ,  "detail:read:item"])]
    #[ORM\Column(type: 'float')]
    private $prix;

   /*  #[Groups([])] */
    #[ORM\Column(type: 'boolean')]
    private $isEtat=true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["detail:read:item"])]
    private $type;
    
    public function __construct()
    {
       
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
        // dd($this->image);
        
        return  utf8_encode(is_resource($this->image)?  base64_encode (stream_get_contents( $this->image)) : $this->image) ;
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


    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

}
