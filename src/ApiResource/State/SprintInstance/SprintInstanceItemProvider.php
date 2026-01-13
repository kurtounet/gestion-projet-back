<?php

namespace App\ApiResource\State\SprintInstance;

use App\Entity\SprintInstance;
use App\ApiResource\Dto\SprintInstance\SprintInstanceItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;

final readonly class SprintInstanceItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof SprintInstance) {
            return $entity;
        }

        $dto = new SprintInstanceItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->name = $entity->getName();

            $dto->description = $entity->getDescription();

            $dto->icon = $entity->getIcon();

            $dto->color = $entity->getColor();

            $dto->startDate = $entity->getStartDate();

            $dto->endDate = $entity->getEndDate();

            $dto->position = $entity->getPosition();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

            $dto->createdByUser = $entity->getCreatedByUser();

            $dto->updatedByUser = $entity->getUpdatedByUser();

        // 2) Relations ToOne => IRI
        // priority (ToOne => IRI)
        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class,$entity->getPriority()->getId())
            : null;

        // sprintTemplate (ToOne => IRI)
        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class,$entity->getSprintTemplate()->getId())
            : null;

        // status (ToOne => IRI)
        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class,$entity->getStatus()->getId())
            : null;

        // comment (ToOne => IRI)
        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class,$entity->getComment()->getId())
            : null;

        // sprintDependency (ToOne => IRI)
        $dto->sprintDependency = $entity->getSprintDependency()
            ? ($this->iriFromResource)(SprintInstanceResource::class,$entity->getSprintDependency()->getId())
            : null;

        // projectInstance (ToOne => IRI)
        $dto->projectInstance = $entity->getProjectInstance()
            ? ($this->iriFromResource)(ProjectInstanceResource::class,$entity->getProjectInstance()->getId())
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