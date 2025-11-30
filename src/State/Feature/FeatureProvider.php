<?php

declare(strict_types=1);

namespace App\State\Feature;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\ItemOperationInterface;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Feature;

/**
 * Provider pour l'entité Feature.
 *
 * À brancher dans la ressource API Platform :
 *  - via attribut : provider: App\State\Feature\FeatureProvider::class
 *  - ou via config YAML/XML.
 */
final class FeatureProvider implements ProviderInterface
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
    }

    /**
     * @return Feature|Feature[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $repository = $this->registry->getRepository(Feature::class);

        // Exemple basique à adapter :
        if ($operation instanceof CollectionOperationInterface) {
            // Collection : GET /{resource}
            return $repository->findAll();
        }

        if ($operation instanceof ItemOperationInterface) {
            // Item : GET /{resource}/{id}
            $id = $uriVariables['id'] ?? null;

            if ($id === null) {
                return null;
            }

            return $repository->find($id);
        }

        // Autres cas (subresource, custom operation...) : à gérer si besoin
        return null;
    }
}
