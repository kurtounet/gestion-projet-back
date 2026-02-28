<?php

namespace App\ApiResource\Mapper\ProjectTemplateSprintTemplate;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateResource;
use App\ApiResource\Resource\SprintTemplate\SprintTemplateResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\ProjectTemplateSprintTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProjectTemplateSprintTemplateMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(ProjectTemplateSprintTemplate $entity): ProjectTemplateSprintTemplateResource
    {
        $dto = new ProjectTemplateSprintTemplateResource();
        $dto->id = $entity->getId();
        $dto->sprintOrder = $entity->getSprintOrder();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->projectTemplate = $entity->getProjectTemplate()
            ? ($this->iriFromResource)(ProjectTemplateResource::class, $entity->getProjectTemplate()->getId())
            : null;

        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class, $entity->getSprintTemplate()->getId())
            : null;


        return $dto;
    }

    public function entityToCollectionDto(ProjectTemplateSprintTemplate $entity): ProjectTemplateSprintTemplateResource
    {
        $dto = new ProjectTemplateSprintTemplateResource();
        $dto->id = $entity->getId();
        $dto->sprintOrder = $entity->getSprintOrder();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->projectTemplate = $entity->getProjectTemplate()
            ? ($this->iriFromResource)(ProjectTemplateResource::class, $entity->getProjectTemplate()->getId())
            : null;

        $dto->sprintTemplate = $entity->getSprintTemplate()
            ? ($this->iriFromResource)(SprintTemplateResource::class, $entity->getSprintTemplate()->getId())
            : null;


        return $dto;
    }

    public function createDtoToEntity(ProjectTemplateSprintTemplateCreateDto $dto): ProjectTemplateSprintTemplate
    {
        $entity = new ProjectTemplateSprintTemplate();
        if (null !== $dto->sprintOrder) {
            $entity->setSprintOrder($dto->sprintOrder);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->projectTemplate) {
            $entity->setProjectTemplate($this->resolveIri($dto->projectTemplate ?? null, \App\Entity\ProjectTemplate::class, 'projectTemplate', required: true));
        }
        if (null !== $dto->sprintTemplate) {
            $entity->setSprintTemplate($this->resolveIri($dto->sprintTemplate ?? null, \App\Entity\SprintTemplate::class, 'sprintTemplate', required: true));
        }



        return $entity;



    }

    public function updateDtoToEntity(ProjectTemplateSprintTemplate $entity, ProjectTemplateSprintTemplateUpdateDto $dto): ProjectTemplateSprintTemplate
    {
        if (null !== $dto->sprintOrder) {
            $entity->setSprintOrder($dto->sprintOrder);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->projectTemplate) {
            $entity->setProjectTemplate($this->resolveIri($dto->projectTemplate ?? null, \App\Entity\ProjectTemplate::class, 'projectTemplate', required: true));
        }
        if (null !== $dto->sprintTemplate) {
            $entity->setSprintTemplate($this->resolveIri($dto->sprintTemplate ?? null, \App\Entity\SprintTemplate::class, 'sprintTemplate', required: true));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(ProjectTemplateSprintTemplate $entity): ProjectTemplateSprintTemplateCreateDto
    {
               $dto = new ProjectTemplateSprintTemplateCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(ProjectTemplateSprintTemplate $entity, object $dto): void
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
