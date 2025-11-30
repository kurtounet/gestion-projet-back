<?php

declare(strict_types=1);

namespace App\State\TypeTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\ItemOperationInterface;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\TypeTask;

/**
 * Provider pour l'entité TypeTask.
 *
 * À brancher dans la ressource API Platform :
 *  - via attribut : provider: App\State\TypeTask\TypeTaskProvider::class
 *  - ou via config YAML/XML.
 */
final class TypeTaskProvider implements ProviderInterface
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
    }

    /**
     * @return TypeTask|TypeTask[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $repository = $this->registry->getRepository(TypeTask::class);

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
