<?php

namespace App\Services;

use App\Entity\Menu;
use App\Services\Interfaces\ICalculPriceMenuService;

class CalculationPriceService implements ICalculPriceMenuService
{

    public function calculateMenuPrice(Menu $data ): float
    {
       
            $prix = 0;
            foreach ($data->getMenuBurgers() as $burger) {
                $menu= $burger->getBurger();
               /*  dd("Voici quantité burger bi" ,$burger->getQuantite()); */
                $prix += $menu->getPrix() * $burger->getQuantite();
            }
            foreach ($data->getMenuTailles() as $taille) {
                $menu= $taille->getTaille();
                $prix += $menu->getPrix() * $taille->getQuantite();;
            }
            foreach ($data->getMenuPortions() as $portion) {
                $menu= $portion->getPortion();
                $prix += $menu->getPrix() * $portion->getQuantite();;
            }

            $data->setPrix($prix);
          

        return $prix;
    }
/* 
    public function manageDoublon(MenuBurder $data){

    } */
}
