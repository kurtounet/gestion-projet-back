<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;

final readonly class ProjectInstanceCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!($operation instanceof CollectionOperationInterface)) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];

        foreach ($result as $entity) {
            if (!$entity instanceof ProjectInstance) {
                continue;
            }

            $dto = new ProjectInstanceCollectionItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->name = $entity->getName();

            $dto->pathFileDatabase = $entity->getPathFileDatabase();

            $dto->pathProject = $entity->getPathProject();

            $dto->description = $entity->getDescription();

            $dto->icon = $entity->getIcon();

            $dto->color = $entity->getColor();

            $dto->isFavory = $entity->getIsFavory();

            $dto->position = $entity->getPosition();

            $dto->startDate = $entity->getStartDate();

            $dto->endDate = $entity->getEndDate();

            $dto->createdByUser = $entity->getCreatedByUser();

            $dto->updatedByUser = $entity->getUpdatedByUser();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

         // 2) Relations ToOne => IRI (si présentes dans le DTO)
        // status (ToOne => IRI)
        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class,$entity->getStatus()->getId())
            : null;

        // priority (ToOne => IRI)
        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class,$entity->getPriority()->getId())
            : null;

        // projectTemplate (ToOne => IRI)
        $dto->projectTemplate = $entity->getProjectTemplate()
            ? ($this->iriFromResource)(ProjectTemplateResource::class,$entity->getProjectTemplate()->getId())
            : null;

        // comment (ToOne => IRI)
        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class,$entity->getComment()->getId())
            : null;

        // parent (ToOne => IRI)
        $dto->parent = $entity->getParent()
            ? ($this->iriFromResource)(ProjectInstanceResource::class,$entity->getParent()->getId())
            : null;

        // configFramework (ToOne => IRI)
        $dto->configFramework = $entity->getConfigFramework()
            ? ($this->iriFromResource)(ConfigProjectFrameworkResource::class,$entity->getConfigFramework()->getId())
            : null;

        // 3) Relations ToMany => array of IRIs (si présentes dans le DTO)
        // sprintInstances (ToMany => array of IRIs)
        $dto->sprintInstances = $this->toIriList($entity->getSprintInstances(), SprintInstanceResource::class);

        // projectInstances (ToMany => array of IRIs)
        $dto->projectInstances = $this->toIriList($entity->getProjectInstances(), ProjectInstanceResource::class);


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