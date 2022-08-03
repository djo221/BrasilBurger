<?php
namespace App\DataProvider;


// api/src/DataProvider/DetailDataProvider.php


use App\Entity\dto\Detail;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\BoissonRepository;

final class DetailDataProvier implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $id;
    private $menuRepository;
    private $burgerRepository;
    private $boissonRepository;
    private $portionFriteRepository;


    

    
    public function __construct(
        MenuRepository $menusRepository,
        BurgerRepository $burgerRepository,
        BoissonRepository $boissonRepository,
        PortionFriteRepository $portionFriteRepository
    )
    {
        $this->menuRepository = $menusRepository;
        $this->burgerRepository = $burgerRepository;
        $this->boissonRepository = $boissonRepository;
        $this->portionFriteRepository = $portionFriteRepository;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
       return Detail::class === $resourceClass;
    
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {

        $detail = new Detail();

        $detail->id = $id;
        $menu = $this->menuRepository->find($id);
        $burger = $this->burgerRepository->find($id);

        if ($menu == null) {
            $detail->produit = $burger;
        }
        if ($burger == null) {
            $detail->produit = $menu;
        }
        
        $detail->boisson = $this->boissonRepository->findAll();
        $detail->portionFrite = $this->portionFriteRepository->findAll();

        //dd( $this->boissonRepository->findAll());
        //dd($detail);

        return $detail;

    }
}
