<?php

namespace App\ApiResource\State\TaskInstance;

use App\Entity\TaskInstance;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\User\UserResource;
use App\ApiResource\Resource\TaskTemplate\TaskTemplateResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Resource\TypeTask\TypeTaskResource;
use App\ApiResource\Resource\TaskInstance\TaskInstanceResource;
use App\ApiResource\Resource\Comment\CommentResource;
use App\Entity\SprintInstance;

final readonly class TaskInstanceCollectionCurrentSprintProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $sprintVar = $uriVariables['sprintId'] ?? null;
        if ($sprintVar === null || $sprintVar === '') {
            throw new \LogicException('uriVariable "id" est absent.');
        }

        // Link peut te donner l'objet ou l'id
        $sprintId = $sprintVar instanceof SprintInstance ? (string) $sprintVar->getId() : (string) $sprintVar;

        // Nested property en dot syntax (aligné doc)
        $context['filters'] ??= [];
        $context['filters']['sprintInstance.id'] = $sprintId;

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];

        foreach ($result as $entity) {
            if (!$entity instanceof TaskInstance) {
                continue;
            }

            $dto = new TaskInstanceCollectionItemDto();

            // 1) Scalars
            $dto->id = $entity->getId();
            $dto->name = $entity->getName();
            $dto->description = $entity->getDescription();
            $dto->startDate = $entity->getStartDate();
            $dto->dueDate = $entity->getDueDate();
            $dto->position = $entity->getPosition();
            $dto->icon = $entity->getIcon();
            $dto->color = $entity->getColor();
            $dto->createdAt = $entity->getCreatedAt();
            $dto->updatedAt = $entity->getUpdatedAt();
            $dto->createdByUser = $entity->getCreatedByUser();
            $dto->updatedByUser = $entity->getUpdatedByUser();

            // 2) Relations ToOne => IRI (si présentes dans le DTO)
            /*
        // user (ToOne => IRI)
        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(UserResource::class,$entity->getUser()->getId())
            : null;

        // taskTemplate (ToOne => IRI)
        $dto->taskTemplate = $entity->getTaskTemplate()
            ? ($this->iriFromResource)(TaskTemplateResource::class,$entity->getTaskTemplate()->getId())
            : null;

        // sprintInstance (ToOne => IRI)
        $dto->sprintInstance = $entity->getSprintInstance()
            ? ($this->iriFromResource)(SprintInstanceResource::class,$entity->getSprintInstance()->getId())
            : null;

        // priority (ToOne => IRI)
        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class,$entity->getPriority()->getId())
            : null;

        // status (ToOne => IRI)
        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class,$entity->getStatus()->getId())
            : null;

        // typeTask (ToOne => IRI)
        $dto->typeTask = $entity->getTypeTask()
            ? ($this->iriFromResource)(TypeTaskResource::class,$entity->getTypeTask()->getId())
            : null;

        // parentTask (ToOne => IRI)
        $dto->parentTask = $entity->getParentTask()
            ? ($this->iriFromResource)(TaskInstanceResource::class,$entity->getParentTask()->getId())
            : null;

        // dependency (ToOne => IRI)
        $dto->dependency = $entity->getDependency()
            ? ($this->iriFromResource)(TaskInstanceResource::class,$entity->getDependency()->getId())
            : null;

        // comment (ToOne => IRI)
        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class,$entity->getComment()->getId())
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
