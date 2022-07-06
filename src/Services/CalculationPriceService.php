<?php

namespace App\Services;

use App\Entity\Menu;
use App\Services\Interfaces\ICalculPriceMenuService;

class CalculationPriceService implements ICalculPriceMenuService
{

    public function calculateMenuPrice($data): void
    {

        if ($data instanceof Menu) {
            $prix = 0;
            foreach ($data->getMenuBurgers() as $burger) {
                $menu= $burger->getBurger();
                $prix += $menu->getPrix();
            }
            foreach ($data->getMenuTailles() as $taille) {
                $menu= $taille->getTaille();
                $prix += $menu->getPrix();
            }
            foreach ($data->getMenuPortions() as $portion) {
                $menu= $portion->getPortion();
                $prix += $menu->getPrix();
            }
            $data->setPrix($prix);
        }
    }
}
