<?php

namespace App\Mapper;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Comment;
use App\Entity\ConfigProjectFramework;
use App\Entity\Priority;
use App\Entity\ProjectInstance;
use App\Entity\ProjectTemplate;
use App\Entity\Status;
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

    /**
     * Pour transformer une entité en DTO de DETAIL (Item).
     */
    public function entityToItemDto(ProjectInstance $entity): ProjectInstanceItemDto
    {
        $dto = new ProjectInstanceItemDto();

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

        // 2) Relations ToOne => IRI

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

        // 3) Relations ToMany => array of IRIs
        $dto->sprintInstances = $this->toIriList($entity->getSprintInstances(), SprintInstanceResource::class);

        $dto->projectInstances = $this->toIriList($entity->getProjectInstances(), ProjectInstanceResource::class);

        return $dto;
    }

    /**
     * Pour transformer une entité en DTO de LISTE (Collection).
     */
    public function mapEntityToCollectionDto(ProjectInstance $entity): ProjectInstanceCollectionItemDto
    {
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
        /*
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
*/

        // On peut choisir de ne pas mettre certaines relations ici pour la performance
        return $dto;
    }

    public function updateDtoToEntity(ProjectInstance $entity, ProjectInstanceUpdateDto $data): ProjectInstance
    {
        $entity->setName($data->name);
        $entity->setPathFileDatabase($data->pathFileDatabase);
        $entity->setPathProject($data->pathProject);
        $entity->setDescription($data->description);
        $entity->setIcon($data->icon);
        $entity->setColor($data->color);
        $entity->setIsFavory($data->isFavory);
        $entity->setPosition($data->position);
        $entity->setStartDate($data->startDate);
        $entity->setEndDate($data->endDate);
        $entity->setCreatedByUser($this->security->getUser()->getUserIdentifier());
        $entity->setUpdatedByUser($this->security->getUser()->getUserIdentifier());
        /*
        $entity->setCreatedAt($data->createdAt);
        $entity->setUpdatedAt($data->updatedAt);
        */
        $entity->setStatus($this->resolveIri($data->status, Status::class, 'status', required: true));
        $entity->setPriority($this->resolveIri($data->priority, Priority::class, 'priority', required: true));
        $entity->setProjectTemplate($this->resolveIri($data->projectTemplate, ProjectTemplate::class, 'projectTemplate', required: false));
        $entity->setComment($this->resolveIri($data->comment, Comment::class, 'comment', required: false));
        $entity->setParent($this->resolveIri($data->parent, ProjectInstance::class, 'parent', required: false));
        $entity->setConfigFramework($this->resolveIri($data->configFramework, ConfigProjectFramework::class, 'configFramework', required: false));

        return $entity;
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

        // TODO: Relations ToMany
        // status (ToMany => array of IRIs)
        $entity->setStatus($this->resolveIri($dto->status, Status::class, 'status', required: true));
        // $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));
        // priority (ToMany => array of IRIs)
        $entity->setPriority($this->resolveIri($dto->priority ?? null, Priority::class, 'priority', required: true));
        // projecttemplate (ToMany => array of IRIs)
        $entity->setProjectTemplate($this->resolveIri($dto->projecttemplate ?? null, ProjectTemplate::class, 'projecttemplate', required: false));
        // comment (ToMany => array of IRIs)
        $entity->setComment($this->resolveIri($dto->comment ?? null, Comment::class, 'comment', required: false));
        // projectinstance (ToMany => array of IRIs)
        // $entity->setProjectInstances($this->resolveIri($dto->projectinstance ?? null, ProjectInstance::class, 'projectinstance', required: false));
        // configprojectframework (ToMany => array of IRIs)
        // $entity->setConfigProjectFramework($this->resolveIri($dto->configprojectframework ?? null, ConfigProjectFramework::class, 'configprojectframework', required: false));

        return $entity;
    }

    public function mapEntityToCreateDto(ProjectInstance $entity): ProjectInstanceCreateDto
    {
        $dto = new ProjectInstanceCreateDto();

        // 1) Scalars

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
        // $dto->createdAt = $entity->getCreatedAt();
        // $dto->updatedAt = $entity->getUpdatedAt();
        /*
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
*/

        // On peut choisir de ne pas mettre certaines relations ici pour la performance
        return $dto;
    }

    private function mapCommonFields(ProjectInstance $entity, object $dto): void
    {
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
        // ... tous tes champs communs
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
