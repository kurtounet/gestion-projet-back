<?php

namespace App\ApiResource\Mapper\ProjectInstance;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\ProjectInstance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProjectInstanceMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(ProjectInstance $entity): ProjectInstanceResource
    {
        $dto = new ProjectInstanceResource();
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

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class, $entity->getStatus()->getId())
            : null;

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class, $entity->getPriority()->getId())
            : null;

        $dto->projectTemplate = $entity->getProjectTemplate()
            ? ($this->iriFromResource)(ProjectTemplateResource::class, $entity->getProjectTemplate()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class, $entity->getComment()->getId())
            : null;

        $dto->parent = $entity->getParent()
            ? ($this->iriFromResource)(ProjectInstanceResource::class, $entity->getParent()->getId())
            : null;

        $dto->configFramework = $entity->getConfigFramework()
            ? ($this->iriFromResource)(ConfigProjectFrameworkResource::class, $entity->getConfigFramework()->getId())
            : null;


        $dto->sprintInstances = $this->toIriList($entity->getSprintInstances(), SprintInstanceResource::class);

        $dto->projectInstances = $this->toIriList($entity->getProjectInstances(), ProjectInstanceResource::class);

        return $dto;
    }

    public function entityToCollectionDto(ProjectInstance $entity): ProjectInstanceResource
    {
        $dto = new ProjectInstanceResource();
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

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class, $entity->getStatus()->getId())
            : null;

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class, $entity->getPriority()->getId())
            : null;

        $dto->projectTemplate = $entity->getProjectTemplate()
            ? ($this->iriFromResource)(ProjectTemplateResource::class, $entity->getProjectTemplate()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class, $entity->getComment()->getId())
            : null;

        $dto->parent = $entity->getParent()
            ? ($this->iriFromResource)(ProjectInstanceResource::class, $entity->getParent()->getId())
            : null;

        $dto->configFramework = $entity->getConfigFramework()
            ? ($this->iriFromResource)(ConfigProjectFrameworkResource::class, $entity->getConfigFramework()->getId())
            : null;


        $dto->sprintInstances = $this->toIriList($entity->getSprintInstances(), SprintInstanceResource::class);

        $dto->projectInstances = $this->toIriList($entity->getProjectInstances(), ProjectInstanceResource::class);

        return $dto;
    }

    public function createDtoToEntity(ProjectInstanceCreateDto $dto): ProjectInstance
    {
        $entity = new ProjectInstance();
        if (null !== $dto->name) {
            $entity->setName($dto->name);
        }
        if (null !== $dto->pathFileDatabase) {
            $entity->setPathFileDatabase($dto->pathFileDatabase);
        }
        if (null !== $dto->pathProject) {
            $entity->setPathProject($dto->pathProject);
        }
        if (null !== $dto->description) {
            $entity->setDescription($dto->description);
        }
        if (null !== $dto->icon) {
            $entity->setIcon($dto->icon);
        }
        if (null !== $dto->color) {
            $entity->setColor($dto->color);
        }
        if (null !== $dto->isFavory) {
            $entity->setIsFavory($dto->isFavory);
        }
        if (null !== $dto->position) {
            $entity->setPosition($dto->position);
        }
        if (null !== $dto->startDate) {
            $entity->setStartDate($dto->startDate);
        }
        if (null !== $dto->endDate) {
            $entity->setEndDate($dto->endDate);
        }

        /*
        if (null !== $dto->createdByUser) {
            $entity->setCreatedByUser($dto->createdByUser);
        }
        if (null !== $dto->updatedByUser) {
            $entity->setUpdatedByUser($dto->updatedByUser);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
            */
        if (null !== $dto->status) {
            $entity->setStatus($this->resolveIri($dto->status ?? null, \App\Entity\Status::class, 'status', required: true));
        }
        if (null !== $dto->priority) {
            $entity->setPriority($this->resolveIri($dto->priority ?? null, \App\Entity\Priority::class, 'priority', required: true));
        }
        if (null !== $dto->projectTemplate) {
            $entity->setProjectTemplate($this->resolveIri($dto->projectTemplate ?? null, \App\Entity\ProjectTemplate::class, 'projectTemplate', required: false));
        }
        if (null !== $dto->comment) {
            $entity->setComment($this->resolveIri($dto->comment ?? null, \App\Entity\Comment::class, 'comment', required: false));
        }
        if (null !== $dto->parent) {
            $entity->setParent($this->resolveIri($dto->parent ?? null, ProjectInstance::class, 'parent', required: false));
        }
        if (null !== $dto->configFramework) {
            $entity->setConfigFramework($this->resolveIri($dto->configFramework ?? null, \App\Entity\ConfigProjectFramework::class, 'configFramework', required: false));
        }



        return $entity;



    }

    public function updateDtoToEntity(ProjectInstance $entity, ProjectInstanceUpdateDto $dto): ProjectInstance
    {
        if (null !== $dto->name) {
            $entity->setName($dto->name);
        }
        if (null !== $dto->pathFileDatabase) {
            $entity->setPathFileDatabase($dto->pathFileDatabase);
        }
        if (null !== $dto->pathProject) {
            $entity->setPathProject($dto->pathProject);
        }
        if (null !== $dto->description) {
            $entity->setDescription($dto->description);
        }
        if (null !== $dto->icon) {
            $entity->setIcon($dto->icon);
        }
        if (null !== $dto->color) {
            $entity->setColor($dto->color);
        }
        if (null !== $dto->isFavory) {
            $entity->setIsFavory($dto->isFavory);
        }
        if (null !== $dto->position) {
            $entity->setPosition($dto->position);
        }
        if (null !== $dto->startDate) {
            $entity->setStartDate($dto->startDate);
        }
        if (null !== $dto->endDate) {
            $entity->setEndDate($dto->endDate);
        }
        if (null !== $dto->createdByUser) {
            $entity->setCreatedByUser($dto->createdByUser);
        }
        if (null !== $dto->updatedByUser) {
            $entity->setUpdatedByUser($dto->updatedByUser);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->status) {
            $entity->setStatus($this->resolveIri($dto->status ?? null, \App\Entity\Status::class, 'status', required: true));
        }
        if (null !== $dto->priority) {
            $entity->setPriority($this->resolveIri($dto->priority ?? null, \App\Entity\Priority::class, 'priority', required: true));
        }
        if (null !== $dto->projectTemplate) {
            $entity->setProjectTemplate($this->resolveIri($dto->projectTemplate ?? null, \App\Entity\ProjectTemplate::class, 'projectTemplate', required: false));
        }
        if (null !== $dto->comment) {
            $entity->setComment($this->resolveIri($dto->comment ?? null, \App\Entity\Comment::class, 'comment', required: false));
        }
        if (null !== $dto->parent) {
            $entity->setParent($this->resolveIri($dto->parent ?? null, ProjectInstance::class, 'parent', required: false));
        }
        if (null !== $dto->configFramework) {
            $entity->setConfigFramework($this->resolveIri($dto->configFramework ?? null, \App\Entity\ConfigProjectFramework::class, 'configFramework', required: false));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(ProjectInstance $entity): ProjectInstanceCreateDto
    {
               $dto = new ProjectInstanceCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(ProjectInstance $entity, object $dto): void
    {
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
    }

    private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (! is_object($item)) {
                continue;
            }

            $iri = ($this->iriFromResource)($resourceClass, $item->getId());
            if (null !== $iri) {
                $iris[] = $iri;
            }
        }

        return $iris;
    }

    private function resolveIri(?string $iri, string $expectedClass, string $field, bool $required = false): ?object
    {
        if (null === $iri || '' === $iri) {
            if ($required) {
                throw new BadRequestHttpException(sprintf('Field "%s" is required and must be a non-empty IRI string.', $field));
            }

            // OPTIONNEL => on retourne null (et on ne throw pas)
            return null;
        }

        try {
            $resource = $this->iriConverter->getResourceFromIri($iri);
        } catch (\Throwable $e) {
            throw new BadRequestHttpException(sprintf('Invalid IRI for field "%s".', $field), $e);
        }

        // 1) Si l’IRI te donne déjà l’Entity attendue, parfait
        if ($resource instanceof $expectedClass) {
            return $resource;
        }

        // 2) Sinon, on tente de récupérer l’ID depuis l’objet ressource
        $id = null;
        if (is_object($resource) && property_exists($resource, 'id')) {
            $id = $resource->id;
        }

        // 3) Fallback: extraire l’ID de la fin de l’IRI (/api/statuses/121)
        if (null === $id && preg_match('~/(\d+)$~', $iri, $m)) {
            $id = (int) $m[1];
        }

        if (null === $id) {
            throw new BadRequestHttpException(sprintf('Invalid IRI type for field "%s". Expected "%s".', $field, $expectedClass));
        }

        $entity = $this->em->getRepository($expectedClass)->find($id);

        if (! $entity) {
            throw new BadRequestHttpException(sprintf('Resource not found for field "%s" (id: %s).', $field, (string) $id));
        }

        return $entity;
    }
}
