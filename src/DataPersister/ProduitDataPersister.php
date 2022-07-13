<?php

namespace App\DataPersister;


use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Permet de redefinir un entité
 */
class ProduitDataPersister implements DataPersisterInterface
{


    private $security;

    public function __construct(TokenStorageInterface $token, Security $security)
    {
        $this->token = $token;
        $this->security = $security;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
    }
    /**
     * @param Produit $data
     * 
     */
    public function persist($data,  array $context = [])
    {
    


        

        if ($data instanceof Produit) {
            $data->setGestionnaire($this->token->getToken()->getUser());
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
