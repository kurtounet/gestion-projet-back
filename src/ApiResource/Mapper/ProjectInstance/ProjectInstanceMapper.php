<?php

namespace App\ApiResource\Mapper\ProjectInstance;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
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

    public function entityToItemDto(ProjectInstance $entity): ProjectInstanceItemDto
    {
        $dto = new ProjectInstanceItemDto();
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

        /*

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
            : null;

        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
            : null;

        $dto->projecttemplate = $entity->getProjecttemplate()
            ? ($this->iriFromResource)(ProjectTemplate::class,$entity->getProjecttemplate()->getId())
            : null;

        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
            : null;

        $dto->projectinstance = $entity->getProjectinstance()
            ? ($this->iriFromResource)(ProjectInstance::class,$entity->getProjectinstance()->getId())
            : null;

        $dto->configprojectframework = $entity->getConfigprojectframework()
            ? ($this->iriFromResource)(ConfigProjectFramework::class,$entity->getConfigprojectframework()->getId())
            : null;


        $dto->sprintinstance = $this->toIriList($entity->getSprintInstance(), SprintInstance::class);

        $dto->projectinstance = $this->toIriList($entity->getProjectInstance(), ProjectInstance::class);
        */
        return $dto;
    }

    public function entityToCollectionDto(ProjectInstance $entity): ProjectInstanceCollectionItemDto
    {
        $dto = new ProjectInstanceCollectionItemDto();
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

        /*

         $dto->status = $entity->getStatus()
             ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
             : null;

         $dto->priority = $entity->getPriority()
             ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
             : null;

         $dto->projecttemplate = $entity->getProjecttemplate()
             ? ($this->iriFromResource)(ProjectTemplate::class,$entity->getProjecttemplate()->getId())
             : null;

         $dto->comment = $entity->getComment()
             ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
             : null;

         $dto->projectinstance = $entity->getProjectinstance()
             ? ($this->iriFromResource)(ProjectInstance::class,$entity->getProjectinstance()->getId())
             : null;

         $dto->configprojectframework = $entity->getConfigprojectframework()
             ? ($this->iriFromResource)(ConfigProjectFramework::class,$entity->getConfigprojectframework()->getId())
             : null;


         $dto->sprintinstance = $this->toIriList($entity->getSprintInstance(), SprintInstance::class);

         $dto->projectinstance = $this->toIriList($entity->getProjectInstance(), ProjectInstance::class);
        */
        return $dto;
    }

    public function createDtoToEntity(ProjectInstanceCreateDto $dto): ProjectInstance
    {
        $entity = new ProjectInstance();
        $entity->setName($dto->name);
        $entity->setPathFileDatabase($dto->pathFileDatabase);
        $entity->setPathProject($dto->pathProject);
        $entity->setDescription($dto->description);
        $entity->setIcon($dto->icon);
        $entity->setColor($dto->color);
        $entity->setIsFavory($dto->isFavory);
        $entity->setPosition($dto->position);
        $entity->setStartDate($dto->startDate);
        $entity->setEndDate($dto->endDate);
        $entity->setCreatedByUser($dto->createdByUser);
        $entity->setUpdatedByUser($dto->updatedByUser);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        /*
                    $entity->setStatus($dto->status);

             $entity->setPriority($dto->priority);

             $entity->setProjectTemplate($dto->projectTemplate);

             $entity->setComment($dto->comment);

             $entity->setParent($dto->parent);

             $entity->setConfigFramework($dto->configFramework);


         $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));

         $entity->setPriority($this->resolveIri($dto->priority ?? null, Priority::class, 'priority', required: true));

         $entity->setProjectTemplate($this->resolveIri($dto->projecttemplate ?? null, ProjectTemplate::class, 'projecttemplate', required: false));

         $entity->setComment($this->resolveIri($dto->comment ?? null, Comment::class, 'comment', required: false));

         $entity->setProjectInstance($this->resolveIri($dto->projectinstance ?? null, ProjectInstance::class, 'projectinstance', required: false));

         $entity->setConfigProjectFramework($this->resolveIri($dto->configprojectframework ?? null, ConfigProjectFramework::class, 'configprojectframework', required: false));
        */

        return $entity;
    }

    public function updateDtoToEntity(ProjectInstance $entity, ProjectInstanceUpdateDto $dto): ProjectInstance
    {
        $entity = new ProjectInstance();
        $entity->setName($dto->name);
        $entity->setPathFileDatabase($dto->pathFileDatabase);
        $entity->setPathProject($dto->pathProject);
        $entity->setDescription($dto->description);
        $entity->setIcon($dto->icon);
        $entity->setColor($dto->color);
        $entity->setIsFavory($dto->isFavory);
        $entity->setPosition($dto->position);
        $entity->setStartDate($dto->startDate);
        $entity->setEndDate($dto->endDate);
        $entity->setCreatedByUser($dto->createdByUser);
        $entity->setUpdatedByUser($dto->updatedByUser);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        /*
                    $entity->setStatus($dto->status);

             $entity->setPriority($dto->priority);

             $entity->setProjectTemplate($dto->projectTemplate);

             $entity->setComment($dto->comment);

             $entity->setParent($dto->parent);

             $entity->setConfigFramework($dto->configFramework);


         $entity->setSprintInstance($this->resolveIri($dto->sprintinstance ?? null, SprintInstance::class, 'sprintinstance', required: true));

         $entity->setProjectInstance($this->resolveIri($dto->projectinstance ?? null, ProjectInstance::class, 'projectinstance', required: true));
        */
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
