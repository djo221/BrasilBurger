<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CalculationPriceService;
use App\Services\Interfaces\ICalculPriceMenuService;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

/**
 * Permet de redefinir un entité
 */
class MenuDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;

    private ICalculPriceMenuService $calculePrice;

    public function __construct(EntityManagerInterface $entityManager, CalculationPriceService $calculePrice ) {
     
        $this->entityManager = $entityManager;
        $this->calculePrice = $calculePrice;
    }

    public function supports($data): bool
    {
        return $data instanceof Menu;
    }
    

    public function persist($data)
    {
        if ($data instanceof Produit) {

            if ($data->getInterseptImage()) {
                $data->setImage(file_get_contents($data->getInterseptImage())
            );
            }
            // dd($data);

        }
        
        $this->calculePrice->calculateMenuPrice( $data);

        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
