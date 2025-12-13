<?php

namespace App\ApiResource\State\ConfigProjectFramework;


use App\Entity\ConfigProjectFramework;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


/**
 * Provider custom pour ConfigProjectFramework.
 * Décore le Provider par défaut pour ajouter une logique de lecture si besoin.
 *
 * @implements ProviderInterface<ConfigProjectFrameworkResponseDto>
 */
final readonly class ConfigProjectFrameworkProvider implements ProviderInterface
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
