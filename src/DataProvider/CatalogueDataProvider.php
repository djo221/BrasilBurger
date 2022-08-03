<?php
namespace App\DataProvider;

use App\Entity\dto\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;


class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $menusRepo;
    private $burgerRepo;

    public function __construct(MenuRepository $menusRepo, BurgerRepository $burgerRepo)
    {
        $this->menusRepo=$menusRepo;
        $this->burgerRepo=$burgerRepo;
    }


    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
      
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {   
        if( Catalogue::class === $resourceClass){
            //dd($this->menusRepo->findAll());
            return [ 
                ["menu" => $this->menusRepo->findAll()], //return $this->menus->findall
                ["burger"=> $this->burgerRepo->findAll()]
            ];
        }
    }

}