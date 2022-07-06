<?php

namespace App\DataPersister;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Services\CalculationPriceService;

/**
 * Permet de redefinir un entité
 */
class MenuDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;

    private $calculePrice;

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
        $this->calculePrice->calculateMenuPrice($data);
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
