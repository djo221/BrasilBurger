<?php

namespace App\Entity\dto;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [
        "get"=>[
            'method'=>'get',
            "normalization_context" =>[ "groups" =>["catalogue:read:collection"]]
        ] 
    ]
)]
class Catalogue
{
    
    private $id;

    #[Groups(["catalogue:read:collection"])]
    private $menu;

    #[Groups(["catalogue:read:collection"])]
    private $burger;

    #[Groups(["catalogue:read:collection"])]
    private $produit;
}
