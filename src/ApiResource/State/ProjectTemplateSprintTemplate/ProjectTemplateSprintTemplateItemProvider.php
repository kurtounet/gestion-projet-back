<?php

namespace App\ApiResource\State\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;

final readonly class ProjectTemplateSprintTemplateItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof ProjectTemplateSprintTemplate) {
            return $entity;
        }

        $dto = new ProjectTemplateSprintTemplateItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->sprintOrder = $entity->getSprintOrder();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

        // 2) Relations ToOne => IRI
        // projectTemplate (ToOne => IRI)
        $dto->projectTemplate = $entity->getProjectTemplate()
            ? ($this->iriFromResource)(ProjectTemplateResource::class,$entity->getProjectTemplate()->getId())
            : null;

        // sprintTemplate (ToOne => IRI)
        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class,$entity->getSprintTemplate()->getId())
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