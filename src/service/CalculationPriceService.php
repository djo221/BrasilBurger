<?php

namespace App\service;

use App\Entity\Menu;

class CalculationPriceService
{
    

    public function calculateMenuPrice($data): void
    {

    

        if ($data instanceof Menu) {

            $prix = 0;
            foreach ($data->getBurgers() as $burger) {
                dd($data->getBurgers());
                $prix += $burger->getPrix();
            }
            foreach ($data->getTailles() as $taille) {
                $prix += $taille->getPrix();
            }
            foreach ($data->getPortions() as $portion) {
                $prix += $portion->getPrix();
            }

            $data->setPrix($prix);
        }
    }
}
