<?php

namespace App\ApiResource\State\TypeTask;

use App\Entity\TypeTask;
use App\ApiResource\Dto\TypeTask\TypeTaskItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\CodeBase\CodeBaseResource;

final readonly class TypeTaskItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof TypeTask) {
            return $entity;
        }

        $dto = new TypeTaskItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->name = $entity->getName();

            $dto->color = $entity->getColor();

            $dto->pathFileScript = $entity->getPathFileScript();

            $dto->description = $entity->getDescription();

            $dto->automatique = $entity->getAutomatique();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

        // 2) Relations ToOne => IRI
        // code (ToOne => IRI)
        $dto->code = $entity->getCode()
            ? ($this->iriFromResource)(CodeBaseResource::class,$entity->getCode()->getId())
            : null;

        // 3) Relations ToMany => array of IRIs
        // No ToMany relations


        return $dto;
    }

    private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (!is_object($item)) {
                continue;
            }

            $iri = ($this->iriFromResource)($resourceClass, $item->getId());
            if (null !== $iri) {
                $iris[] = $iri;
            }
        }

        return $iris;
    }
}