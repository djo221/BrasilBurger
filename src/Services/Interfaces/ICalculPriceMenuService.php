<?php

namespace App\Services\Interfaces;

use App\Entity\Menu;

interface ICalculPriceMenuService{

    public function calculateMenuPrice( Menu $data) : float;

}