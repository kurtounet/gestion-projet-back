<?php

namespace App\ApiResource\Mapper\TaskTemplate;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCollectionItemDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateItemDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateUpdateDto;
use App\ApiResource\Service\IriFromResource;
use App\Entity\TaskTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TaskTemplateMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(TaskTemplate $entity): TaskTemplateItemDto
    {
        $dto = new TaskTemplateItemDto();
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
        $dto->parentTask = $entity->getParentTask();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

        $dto->sprinttemplate = $entity->getSprinttemplate()
            ? ($this->iriFromResource)(SprintTemplate::class,$entity->getSprinttemplate()->getId())
            : null;

        $dto->typetask = $entity->getTypetask()
            ? ($this->iriFromResource)(TypeTask::class,$entity->getTypetask()->getId())
            : null;


        */
        return $dto;
    }

    public function entityToCollectionDto(TaskTemplate $entity): TaskTemplateCollectionItemDto
    {
        $dto = new TaskTemplateCollectionItemDto();
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
        $dto->parentTask = $entity->getParentTask();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

         $dto->sprinttemplate = $entity->getSprinttemplate()
             ? ($this->iriFromResource)(SprintTemplate::class,$entity->getSprinttemplate()->getId())
             : null;

         $dto->typetask = $entity->getTypetask()
             ? ($this->iriFromResource)(TypeTask::class,$entity->getTypetask()->getId())
             : null;


        */
        return $dto;
    }

    public function createDtoToEntity(TaskTemplateCreateDto $dto): TaskTemplate
    {
        $entity = new TaskTemplate();
        $entity->setName($dto->name);
        $entity->setDescription($dto->description);
        $entity->setParentTask($dto->parentTask);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        /*
                    $entity->setSprintTemplate($dto->sprintTemplate);

             $entity->setTypeTask($dto->typeTask);


         $entity->setSprintTemplate($this->resolveIri($dto->sprinttemplate ?? null, SprintTemplate::class, 'sprinttemplate', required: true));

         $entity->setTypeTask($this->resolveIri($dto->typetask ?? null, TypeTask::class, 'typetask', required: true));
        */

        return $entity;
    }

    public function updateDtoToEntity(TaskTemplate $entity, TaskTemplateUpdateDto $dto): TaskTemplate
    {
        $entity = new TaskTemplate();
        $entity->setName($dto->name);
        $entity->setDescription($dto->description);
        $entity->setParentTask($dto->parentTask);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        /*
                    $entity->setSprintTemplate($dto->sprintTemplate);

             $entity->setTypeTask($dto->typeTask);


        */
        return $entity;
    }

    /*
    public function mapEntityToCreateDto(TaskTemplate $entity): TaskTemplateCreateDto
    {
               $dto = new TaskTemplateCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(TaskTemplate $entity, object $dto): void
    {
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
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

        if (!$entity) {
            throw new BadRequestHttpException(sprintf('Resource not found for field "%s" (id: %s).', $field, (string) $id));
        }

        return $entity;
    }
}
