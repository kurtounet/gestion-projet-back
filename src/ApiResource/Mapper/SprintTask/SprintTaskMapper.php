<?php

namespace App\ApiResource\Mapper\SprintTask;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\SprintTask\SprintTaskCreateDto;
use App\ApiResource\Dto\SprintTask\SprintTaskUpdateDto;
use App\ApiResource\Resource\SprintTask\SprintTaskResource;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;
use App\ApiResource\Resource\TaskTemplate\TaskTemplateResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\SprintTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SprintTaskMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(SprintTask $entity): SprintTaskResource
    {
        $dto = new SprintTaskResource();
        $dto->id = $entity->getId();
        $dto->taskOrder = $entity->getTaskOrder();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class, $entity->getSprintTemplate()->getId())
            : null;

        $dto->taskTemplate = $entity->getTaskTemplate()
            ? ($this->iriFromResource)(TaskTemplateResource::class, $entity->getTaskTemplate()->getId())
            : null;


        return $dto;
    }

    public function entityToCollectionDto(SprintTask $entity): SprintTaskResource
    {
        $dto = new SprintTaskResource();
        $dto->id = $entity->getId();
        $dto->taskOrder = $entity->getTaskOrder();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class, $entity->getSprintTemplate()->getId())
            : null;

        $dto->taskTemplate = $entity->getTaskTemplate()
            ? ($this->iriFromResource)(TaskTemplateResource::class, $entity->getTaskTemplate()->getId())
            : null;


        return $dto;
    }

    public function createDtoToEntity(SprintTaskCreateDto $dto): SprintTask
    {
        $entity = new SprintTask();
        if (null !== $dto->taskOrder) {
            $entity->setTaskOrder($dto->taskOrder);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->sprintTemplate) {
            $entity->setSprintTemplate($this->resolveIri($dto->sprintTemplate ?? null, \App\Entity\SprintTemplate::class, 'sprintTemplate', required: true));
        }
        if (null !== $dto->taskTemplate) {
            $entity->setTaskTemplate($this->resolveIri($dto->taskTemplate ?? null, \App\Entity\TaskTemplate::class, 'taskTemplate', required: true));
        }



        return $entity;



    }

    public function updateDtoToEntity(SprintTask $entity, SprintTaskUpdateDto $dto): SprintTask
    {
        if (null !== $dto->taskOrder) {
            $entity->setTaskOrder($dto->taskOrder);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->sprintTemplate) {
            $entity->setSprintTemplate($this->resolveIri($dto->sprintTemplate ?? null, \App\Entity\SprintTemplate::class, 'sprintTemplate', required: true));
        }
        if (null !== $dto->taskTemplate) {
            $entity->setTaskTemplate($this->resolveIri($dto->taskTemplate ?? null, \App\Entity\TaskTemplate::class, 'taskTemplate', required: true));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(SprintTask $entity): SprintTaskCreateDto
    {
               $dto = new SprintTaskCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(SprintTask $entity, object $dto): void
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
