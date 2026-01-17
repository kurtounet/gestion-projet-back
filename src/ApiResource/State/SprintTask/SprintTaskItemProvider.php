<?php

namespace App\ApiResource\State\SprintTask;

use App\Entity\SprintTask;
use App\ApiResource\Dto\SprintTask\SprintTaskItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;
use App\ApiResource\Resource\TaskTemplate\TaskTemplateResource;

final readonly class SprintTaskItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof SprintTask) {
            return $entity;
        }

        $dto = new SprintTaskItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->taskOrder = $entity->getTaskOrder();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

        // 2) Relations ToOne => IRI
        // sprintTemplate (ToOne => IRI)
        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class,$entity->getSprintTemplate()->getId())
            : null;

        // taskTemplate (ToOne => IRI)
        $dto->taskTemplate = $entity->getTaskTemplate()
            ? ($this->iriFromResource)(TaskTemplateResource::class,$entity->getTaskTemplate()->getId())
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