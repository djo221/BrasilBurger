<?php

namespace App\Entity\dto;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get"=>[
            'method'=>'get',
            "normalization_context" =>[ "groups" =>["detail:read:item"]]
        ] 
    ]
)]
class Detail{

    public function __construct()
    {
    
    }
    
    #[Groups(["detail:read:item" ])]
    public $id;

    #[Groups(["detail:read:item" ])]
    public $produit;

    #[Groups(["detail:read:item" ])]
    public array $boisson;

    #[Groups(["detail:read:item" ])]
    public array $portionFrite;


    
}
