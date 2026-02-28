<?php

namespace App\ApiResource\Mapper\TaskInstance;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Resource\TaskInstance\TaskInstanceResource;
use App\ApiResource\Resource\TaskTemplate\TaskTemplateResource;
use App\ApiResource\Resource\TypeTask\TypeTaskResource;
use App\ApiResource\Resource\User\UserResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\TaskInstance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TaskInstanceMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(TaskInstance $entity): TaskInstanceResource
    {
        $dto = new TaskInstanceResource();
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

        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(UserResource::class, $entity->getUser()->getId())
            : null;

        $dto->taskTemplate = $entity->getTaskTemplate()
            ? ($this->iriFromResource)(TaskTemplateResource::class, $entity->getTaskTemplate()->getId())
            : null;

        $dto->sprintInstance = $entity->getSprintInstance()
            ? ($this->iriFromResource)(SprintInstanceResource::class, $entity->getSprintInstance()->getId())
            : null;

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class, $entity->getPriority()->getId())
            : null;

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class, $entity->getStatus()->getId())
            : null;

        $dto->typeTask = $entity->getTypeTask()
            ? ($this->iriFromResource)(TypeTaskResource::class, $entity->getTypeTask()->getId())
            : null;

        $dto->parentTask = $entity->getParentTask()
            ? ($this->iriFromResource)(TaskInstanceResource::class, $entity->getParentTask()->getId())
            : null;

        $dto->dependency = $entity->getDependency()
            ? ($this->iriFromResource)(TaskInstanceResource::class, $entity->getDependency()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class, $entity->getComment()->getId())
            : null;


        return $dto;
    }

    public function entityToCollectionDto(TaskInstance $entity): TaskInstanceResource
    {
        $dto = new TaskInstanceResource();
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

        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(UserResource::class, $entity->getUser()->getId())
            : null;

        $dto->taskTemplate = $entity->getTaskTemplate()
            ? ($this->iriFromResource)(TaskTemplateResource::class, $entity->getTaskTemplate()->getId())
            : null;

        $dto->sprintInstance = $entity->getSprintInstance()
            ? ($this->iriFromResource)(SprintInstanceResource::class, $entity->getSprintInstance()->getId())
            : null;

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class, $entity->getPriority()->getId())
            : null;

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class, $entity->getStatus()->getId())
            : null;

        $dto->typeTask = $entity->getTypeTask()
            ? ($this->iriFromResource)(TypeTaskResource::class, $entity->getTypeTask()->getId())
            : null;

        $dto->parentTask = $entity->getParentTask()
            ? ($this->iriFromResource)(TaskInstanceResource::class, $entity->getParentTask()->getId())
            : null;

        $dto->dependency = $entity->getDependency()
            ? ($this->iriFromResource)(TaskInstanceResource::class, $entity->getDependency()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class, $entity->getComment()->getId())
            : null;


        return $dto;
    }

    public function createDtoToEntity(TaskInstanceCreateDto $dto): TaskInstance
    {
        $entity = new TaskInstance();
        if (null !== $dto->name) {
            $entity->setName($dto->name);
        }
        if (null !== $dto->description) {
            $entity->setDescription($dto->description);
        }
        if (null !== $dto->startDate) {
            $entity->setStartDate($dto->startDate);
        }
        if (null !== $dto->dueDate) {
            $entity->setDueDate($dto->dueDate);
        }
        if (null !== $dto->position) {
            $entity->setPosition($dto->position);
        }
        if (null !== $dto->icon) {
            $entity->setIcon($dto->icon);
        }
        if (null !== $dto->color) {
            $entity->setColor($dto->color);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->createdByUser) {
            $entity->setCreatedByUser($dto->createdByUser);
        }
        if (null !== $dto->updatedByUser) {
            $entity->setUpdatedByUser($dto->updatedByUser);
        }
        if (null !== $dto->user) {
            $entity->setUser($this->resolveIri($dto->user ?? null, \App\Entity\User::class, 'user', required: true));
        }
        if (null !== $dto->taskTemplate) {
            $entity->setTaskTemplate($this->resolveIri($dto->taskTemplate ?? null, \App\Entity\TaskTemplate::class, 'taskTemplate', required: true));
        }
        if (null !== $dto->sprintInstance) {
            $entity->setSprintInstance($this->resolveIri($dto->sprintInstance ?? null, \App\Entity\SprintInstance::class, 'sprintInstance', required: true));
        }
        if (null !== $dto->priority) {
            $entity->setPriority($this->resolveIri($dto->priority ?? null, \App\Entity\Priority::class, 'priority', required: true));
        }
        if (null !== $dto->status) {
            $entity->setStatus($this->resolveIri($dto->status ?? null, \App\Entity\Status::class, 'status', required: true));
        }
        if (null !== $dto->typeTask) {
            $entity->setTypeTask($this->resolveIri($dto->typeTask ?? null, \App\Entity\TypeTask::class, 'typeTask', required: true));
        }
        if (null !== $dto->parentTask) {
            $entity->setParentTask($this->resolveIri($dto->parentTask ?? null, TaskInstance::class, 'parentTask', required: false));
        }
        if (null !== $dto->dependency) {
            $entity->setDependency($this->resolveIri($dto->dependency ?? null, TaskInstance::class, 'dependency', required: false));
        }
        if (null !== $dto->comment) {
            $entity->setComment($this->resolveIri($dto->comment ?? null, \App\Entity\Comment::class, 'comment', required: false));
        }



        return $entity;



    }

    public function updateDtoToEntity(TaskInstance $entity, TaskInstanceUpdateDto $dto): TaskInstance
    {
        if (null !== $dto->name) {
            $entity->setName($dto->name);
        }
        if (null !== $dto->description) {
            $entity->setDescription($dto->description);
        }
        if (null !== $dto->startDate) {
            $entity->setStartDate($dto->startDate);
        }
        if (null !== $dto->dueDate) {
            $entity->setDueDate($dto->dueDate);
        }
        if (null !== $dto->position) {
            $entity->setPosition($dto->position);
        }
        if (null !== $dto->icon) {
            $entity->setIcon($dto->icon);
        }
        if (null !== $dto->color) {
            $entity->setColor($dto->color);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->createdByUser) {
            $entity->setCreatedByUser($dto->createdByUser);
        }
        if (null !== $dto->updatedByUser) {
            $entity->setUpdatedByUser($dto->updatedByUser);
        }
        if (null !== $dto->user) {
            $entity->setUser($this->resolveIri($dto->user ?? null, \App\Entity\User::class, 'user', required: true));
        }
        if (null !== $dto->taskTemplate) {
            $entity->setTaskTemplate($this->resolveIri($dto->taskTemplate ?? null, \App\Entity\TaskTemplate::class, 'taskTemplate', required: true));
        }
        if (null !== $dto->sprintInstance) {
            $entity->setSprintInstance($this->resolveIri($dto->sprintInstance ?? null, \App\Entity\SprintInstance::class, 'sprintInstance', required: true));
        }
        if (null !== $dto->priority) {
            $entity->setPriority($this->resolveIri($dto->priority ?? null, \App\Entity\Priority::class, 'priority', required: true));
        }
        if (null !== $dto->status) {
            $entity->setStatus($this->resolveIri($dto->status ?? null, \App\Entity\Status::class, 'status', required: true));
        }
        if (null !== $dto->typeTask) {
            $entity->setTypeTask($this->resolveIri($dto->typeTask ?? null, \App\Entity\TypeTask::class, 'typeTask', required: true));
        }
        if (null !== $dto->parentTask) {
            $entity->setParentTask($this->resolveIri($dto->parentTask ?? null, TaskInstance::class, 'parentTask', required: false));
        }
        if (null !== $dto->dependency) {
            $entity->setDependency($this->resolveIri($dto->dependency ?? null, TaskInstance::class, 'dependency', required: false));
        }
        if (null !== $dto->comment) {
            $entity->setComment($this->resolveIri($dto->comment ?? null, \App\Entity\Comment::class, 'comment', required: false));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(TaskInstance $entity): TaskInstanceCreateDto
    {
               $dto = new TaskInstanceCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(TaskInstance $entity, object $dto): void
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
