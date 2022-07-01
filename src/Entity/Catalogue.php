<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;



#[ApiResource()]
class Catalogue
{ 

    private $id;

    private array $burgers;
    private array $menus;

}
