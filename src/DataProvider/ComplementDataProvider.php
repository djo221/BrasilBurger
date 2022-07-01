<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complements;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{

    private $boissonRepo;
    private $portionRepo;

    public function __construct(BoissonRepository $boissonRepo, PortionFriteRepository $portionRepo)
    {
        $this->boissonRepo = $boissonRepo;
        $this->portionRepo = $portionRepo;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complements::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        // Retrieve the blog post collection from somewhere

        if (Complements::class === $resourceClass) {

            return [

                ["boisson" => $this->boissonRepo->findAll()],
                ["portion" => $this->portionRepo->findAll()]
            ];
        }
    }
}
