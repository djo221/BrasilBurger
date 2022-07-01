<?php

namespace App\DataPersister;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


/**
 * Permet de redefinir un entité
 */
class MenuDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
     
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Menu;
    }
    

    public function persist($data)
    {
     


        if ($data instanceof Menu) {
            $prix = 0;
            foreach ($data->getBurgers() as $burger) {
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

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
