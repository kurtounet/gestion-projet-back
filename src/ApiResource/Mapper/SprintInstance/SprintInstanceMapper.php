<?php

namespace App\ApiResource\Mapper\SprintInstance;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\SprintInstance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SprintInstanceMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(SprintInstance $entity): SprintInstanceResource
    {
        $dto = new SprintInstanceResource();
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

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class, $entity->getPriority()->getId())
            : null;

        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class, $entity->getSprintTemplate()->getId())
            : null;

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class, $entity->getStatus()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class, $entity->getComment()->getId())
            : null;

        $dto->sprintDependency = $entity->getSprintDependency()
            ? ($this->iriFromResource)(SprintInstanceResource::class, $entity->getSprintDependency()->getId())
            : null;

        $dto->projectInstance = $entity->getProjectInstance()
            ? ($this->iriFromResource)(ProjectInstanceResource::class, $entity->getProjectInstance()->getId())
            : null;


        return $dto;
    }

    public function entityToCollectionDto(SprintInstance $entity): SprintInstanceResource
    {
        $dto = new SprintInstanceResource();
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

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(PriorityResource::class, $entity->getPriority()->getId())
            : null;

        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class, $entity->getSprintTemplate()->getId())
            : null;

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(StatusResource::class, $entity->getStatus()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(CommentResource::class, $entity->getComment()->getId())
            : null;

        $dto->sprintDependency = $entity->getSprintDependency()
            ? ($this->iriFromResource)(SprintInstanceResource::class, $entity->getSprintDependency()->getId())
            : null;

        $dto->projectInstance = $entity->getProjectInstance()
            ? ($this->iriFromResource)(ProjectInstanceResource::class, $entity->getProjectInstance()->getId())
            : null;


        return $dto;
    }

    public function createDtoToEntity(SprintInstanceCreateDto $dto): SprintInstance
    {
        $entity = new SprintInstance();
        if (null !== $dto->name) {
            $entity->setName($dto->name);
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
        if (null !== $dto->startDate) {
            $entity->setStartDate($dto->startDate);
        }
        if (null !== $dto->endDate) {
            $entity->setEndDate($dto->endDate);
        }
        if (null !== $dto->position) {
            $entity->setPosition($dto->position);
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
        if (null !== $dto->priority) {
            $entity->setPriority($this->resolveIri($dto->priority ?? null, \App\Entity\Priority::class, 'priority', required: true));
        }
        if (null !== $dto->sprintTemplate) {
            $entity->setSprintTemplate($this->resolveIri($dto->sprintTemplate ?? null, \App\Entity\SprintTemplate::class, 'sprintTemplate', required: true));
        }
        if (null !== $dto->status) {
            $entity->setStatus($this->resolveIri($dto->status ?? null, \App\Entity\Status::class, 'status', required: true));
        }
        if (null !== $dto->comment) {
            $entity->setComment($this->resolveIri($dto->comment ?? null, \App\Entity\Comment::class, 'comment', required: false));
        }
        if (null !== $dto->sprintDependency) {
            $entity->setSprintDependency($this->resolveIri($dto->sprintDependency ?? null, SprintInstance::class, 'sprintDependency', required: false));
        }
        if (null !== $dto->projectInstance) {
            $entity->setProjectInstance($this->resolveIri($dto->projectInstance ?? null, \App\Entity\ProjectInstance::class, 'projectInstance', required: true));
        }



        return $entity;



    }

    public function updateDtoToEntity(SprintInstance $entity, SprintInstanceUpdateDto $dto): SprintInstance
    {
        if (null !== $dto->name) {
            $entity->setName($dto->name);
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
        if (null !== $dto->startDate) {
            $entity->setStartDate($dto->startDate);
        }
        if (null !== $dto->endDate) {
            $entity->setEndDate($dto->endDate);
        }
        if (null !== $dto->position) {
            $entity->setPosition($dto->position);
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
        if (null !== $dto->priority) {
            $entity->setPriority($this->resolveIri($dto->priority ?? null, \App\Entity\Priority::class, 'priority', required: true));
        }
        if (null !== $dto->sprintTemplate) {
            $entity->setSprintTemplate($this->resolveIri($dto->sprintTemplate ?? null, \App\Entity\SprintTemplate::class, 'sprintTemplate', required: true));
        }
        if (null !== $dto->status) {
            $entity->setStatus($this->resolveIri($dto->status ?? null, \App\Entity\Status::class, 'status', required: true));
        }
        if (null !== $dto->comment) {
            $entity->setComment($this->resolveIri($dto->comment ?? null, \App\Entity\Comment::class, 'comment', required: false));
        }
        if (null !== $dto->sprintDependency) {
            $entity->setSprintDependency($this->resolveIri($dto->sprintDependency ?? null, SprintInstance::class, 'sprintDependency', required: false));
        }
        if (null !== $dto->projectInstance) {
            $entity->setProjectInstance($this->resolveIri($dto->projectInstance ?? null, \App\Entity\ProjectInstance::class, 'projectInstance', required: true));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(SprintInstance $entity): SprintInstanceCreateDto
    {
               $dto = new SprintInstanceCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(SprintInstance $entity, object $dto): void
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
