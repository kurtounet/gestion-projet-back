<?php

namespace App\ApiResource\Mapper\TaskInstance;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCollectionItemDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceItemDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
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

    public function entityToItemDto(TaskInstance $entity): TaskInstanceItemDto
    {
        $dto = new TaskInstanceItemDto();
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

        /*

        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(User::class,$entity->getUser()->getId())
            : null;

        $dto->tasktemplate = $entity->getTasktemplate()
            ? ($this->iriFromResource)(TaskTemplate::class,$entity->getTasktemplate()->getId())
            : null;

        $dto->sprintinstance = $entity->getSprintinstance()
            ? ($this->iriFromResource)(SprintInstance::class,$entity->getSprintinstance()->getId())
            : null;

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
            : null;

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
            : null;

        $dto->typetask = $entity->getTypetask()
            ? ($this->iriFromResource)(TypeTask::class,$entity->getTypetask()->getId())
            : null;

        $dto->taskinstance = $entity->getTaskinstance()
            ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
            : null;

        $dto->taskinstance = $entity->getTaskinstance()
            ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
            : null;


        */
        return $dto;
    }

    public function entityToCollectionDto(TaskInstance $entity): TaskInstanceCollectionItemDto
    {
        $dto = new TaskInstanceCollectionItemDto();
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

        /*

         $dto->user = $entity->getUser()
             ? ($this->iriFromResource)(User::class,$entity->getUser()->getId())
             : null;

         $dto->tasktemplate = $entity->getTasktemplate()
             ? ($this->iriFromResource)(TaskTemplate::class,$entity->getTasktemplate()->getId())
             : null;

         $dto->sprintinstance = $entity->getSprintinstance()
             ? ($this->iriFromResource)(SprintInstance::class,$entity->getSprintinstance()->getId())
             : null;

         $dto->priority = $entity->getPriority()
             ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
             : null;

         $dto->status = $entity->getStatus()
             ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
             : null;

         $dto->typetask = $entity->getTypetask()
             ? ($this->iriFromResource)(TypeTask::class,$entity->getTypetask()->getId())
             : null;

         $dto->taskinstance = $entity->getTaskinstance()
             ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
             : null;

         $dto->taskinstance = $entity->getTaskinstance()
             ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
             : null;

         $dto->comment = $entity->getComment()
             ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
             : null;


        */
        return $dto;
    }

    public function createDtoToEntity(TaskInstanceCreateDto $dto): TaskInstance
    {
        $entity = new TaskInstance();
        $entity->setName($dto->name);
        $entity->setDescription($dto->description);
        $entity->setStartDate($dto->startDate);
        $entity->setDueDate($dto->dueDate);
        $entity->setPosition($dto->position);
        $entity->setIcon($dto->icon);
        $entity->setColor($dto->color);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        $entity->setCreatedByUser($dto->createdByUser);
        $entity->setUpdatedByUser($dto->updatedByUser);
        /*
                    $entity->setUser($dto->user);

             $entity->setTaskTemplate($dto->taskTemplate);

             $entity->setSprintInstance($dto->sprintInstance);

             $entity->setPriority($dto->priority);

             $entity->setStatus($dto->status);

             $entity->setTypeTask($dto->typeTask);

             $entity->setParentTask($dto->parentTask);

             $entity->setDependency($dto->dependency);

             $entity->setComment($dto->comment);


         $entity->setUser($this->resolveIri($dto->user ?? null, User::class, 'user', required: true));

         $entity->setTaskTemplate($this->resolveIri($dto->tasktemplate ?? null, TaskTemplate::class, 'tasktemplate', required: true));

         $entity->setSprintInstance($this->resolveIri($dto->sprintinstance ?? null, SprintInstance::class, 'sprintinstance', required: true));

         $entity->setPriority($this->resolveIri($dto->priority ?? null, Priority::class, 'priority', required: true));

         $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));

         $entity->setTypeTask($this->resolveIri($dto->typetask ?? null, TypeTask::class, 'typetask', required: true));

         $entity->setTaskInstance($this->resolveIri($dto->taskinstance ?? null, TaskInstance::class, 'taskinstance', required: false));

         $entity->setTaskInstance($this->resolveIri($dto->taskinstance ?? null, TaskInstance::class, 'taskinstance', required: false));

         $entity->setComment($this->resolveIri($dto->comment ?? null, Comment::class, 'comment', required: false));
        */

        return $entity;
    }

    public function updateDtoToEntity(TaskInstance $entity, TaskInstanceUpdateDto $dto): TaskInstance
    {
        $entity = new TaskInstance();
        $entity->setName($dto->name);
        $entity->setDescription($dto->description);
        $entity->setStartDate($dto->startDate);
        $entity->setDueDate($dto->dueDate);
        $entity->setPosition($dto->position);
        $entity->setIcon($dto->icon);
        $entity->setColor($dto->color);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        $entity->setCreatedByUser($dto->createdByUser);
        $entity->setUpdatedByUser($dto->updatedByUser);

        /*
                    $entity->setUser($dto->user);

             $entity->setTaskTemplate($dto->taskTemplate);

             $entity->setSprintInstance($dto->sprintInstance);

             $entity->setPriority($dto->priority);

             $entity->setStatus($dto->status);

             $entity->setTypeTask($dto->typeTask);

             $entity->setParentTask($dto->parentTask);

             $entity->setDependency($dto->dependency);

             $entity->setComment($dto->comment);


        */
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
