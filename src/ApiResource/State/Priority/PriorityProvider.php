<?php

namespace App\ApiResource\State\Priority;


use App\Entity\Priority;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


/**
 * Provider custom pour Priority.
 * Décore le Provider par défaut pour ajouter une logique de lecture si besoin.
 *
 * @implements ProviderInterface<PriorityResponseDto>
 */
final readonly class PriorityProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->collectionProvider->provide($operation, $uriVariables, $context);
        }


        // Ici tu peux filtrer / transformer le résultat si nécessaire,
        // ou laisser tel quel dans un premier temps.
        return $this->itemProvider->provide($operation, $uriVariables, $context);
    }
}
