<?php

namespace App\ApiResource\State\Technology;

use App\Entity\Technology;
use App\ApiResource\Dto\Technology\TechnologyItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\Framework\FrameworkResource;

final readonly class TechnologyItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Technology) {
            return $entity;
        }

        $dto = new TechnologyItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->label = $entity->getLabel();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

        // 2) Relations ToOne => IRI
        // No ToOne relations


        // 3) Relations ToMany => array of IRIs
        // framework (ToMany => array of IRIs)
        $dto->framework = $this->toIriList($entity->getFramework(), FrameworkResource::class);

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