<?php

namespace App\ApiResource\State\SprintInstance;

use App\Entity\SprintInstance;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\Entity\ProjectInstance;

final readonly class SprintInstanceCollectionCurrentProjectProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $projectVar = $uriVariables['projectId'] ?? null;
        if ($projectVar === null || $projectVar === '') {
            throw new \LogicException('uriVariable "id" est absent.');
        }

        // Link peut te donner l'objet ou l'id
        $projectId = $projectVar instanceof ProjectInstance ? (string) $projectVar->getId() : (string) $projectVar;

        // Nested property en dot syntax (aligné doc)
        $context['filters'] ??= [];
        $context['filters']['projectInstance.id'] = $projectId;

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];

        foreach ($result as $entity) {
            if (!$entity instanceof SprintInstance) {
                continue;
            }

            $dto = new SprintInstanceCollectionItemDto();

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

            // 2) Relations ToOne => IRI (si présentes dans le DTO)
            /*
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

        // 3) Relations ToMany => array of IRIs (si présentes dans le DTO)
        // No ToMany relations

*/

            $items[] = $dto;
        }
        return $items;
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
