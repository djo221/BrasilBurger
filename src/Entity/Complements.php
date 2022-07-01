<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    collectionOperations: [

        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['complement:read:simple']]
        ]
    ]
)]
class Complements
{

    #[Groups(["complement:read:simple"])]
    private $id;
    
    private array $boissons;
    private array $portion;
}
