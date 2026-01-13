<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use App\Entity\Status;
use App\Entity\Priority;
use App\Entity\ProjectTemplate;
use App\Entity\Comment;
use App\Entity\SprintInstance;
use App\Entity\ConfigProjectFramework;


final readonly class ProjectInstanceCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriConverterInterface $iriConverter,
        private IriFromResource $iriFromResource,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof ProjectInstanceCreateDto)) {
            return $data;
        }

        // Créer et mapper l'entité depuis le DTO
        $entity = $this->mapDtoToEntity($data);

        // Persister l'entité
        $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        // Retourner le DTO pour l'output
        return $this->entityToDto($entity);

    }

    private function mapDtoToEntity(ProjectInstanceCreateDto $dto): ProjectInstance
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
// TODO: Relations ToOne
            $entity->setStatus($dto->status);

            $entity->setPriority($dto->priority);

            $entity->setProjectTemplate($dto->projectTemplate);

            $entity->setComment($dto->comment);

            $entity->setParent($dto->parent);

            $entity->setConfigFramework($dto->configFramework);
// TODO: Relations ToMany
        // status (ToMany => array of IRIs)
        $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));
        // priority (ToMany => array of IRIs)
        $entity->setPriority($this->resolveIri($dto->priority ?? null, Priority::class, 'priority', required: true));
        // projecttemplate (ToMany => array of IRIs)
        $entity->setProjectTemplate($this->resolveIri($dto->projecttemplate ?? null, ProjectTemplate::class, 'projecttemplate', required: false));
        // comment (ToMany => array of IRIs)
        $entity->setComment($this->resolveIri($dto->comment ?? null, Comment::class, 'comment', required: false));
        // projectinstance (ToMany => array of IRIs)
        $entity->setProjectInstance($this->resolveIri($dto->projectinstance ?? null, ProjectInstance::class, 'projectinstance', required: false));
        // configprojectframework (ToMany => array of IRIs)
        $entity->setConfigProjectFramework($this->resolveIri($dto->configprojectframework ?? null, ConfigProjectFramework::class, 'configprojectframework', required: false));

        return $entity;
    }

    private function entityToDto(ProjectInstance $entity): ProjectInstanceItemDto
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
// TODO: Relations ToOne
        // status (ToOne => IRI)
        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
            : null;
        // priority (ToOne => IRI)
        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
            : null;
        // projecttemplate (ToOne => IRI)
        $dto->projecttemplate = $entity->getProjecttemplate()
            ? ($this->iriFromResource)(ProjectTemplate::class,$entity->getProjecttemplate()->getId())
            : null;
        // comment (ToOne => IRI)
        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
            : null;
        // projectinstance (ToOne => IRI)
        $dto->projectinstance = $entity->getProjectinstance()
            ? ($this->iriFromResource)(ProjectInstance::class,$entity->getProjectinstance()->getId())
            : null;
        // configprojectframework (ToOne => IRI)
        $dto->configprojectframework = $entity->getConfigprojectframework()
            ? ($this->iriFromResource)(ConfigProjectFramework::class,$entity->getConfigprojectframework()->getId())
            : null;
// TODO: Relations ToMany
        // SprintInstance (ToMany => array of IRIs)
        $dto->sprintinstance = $this->toIriList($entity->getSprintInstance(), SprintInstance::class);
        // ProjectInstance (ToMany => array of IRIs)
        $dto->projectinstance = $this->toIriList($entity->getProjectInstance(), ProjectInstance::class);

        return $dto;

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
        if ($iri === null || $iri === '') {
            if ($required) {
                throw new BadRequestHttpException(sprintf(
                    'Field "%s" is required and must be a non-empty IRI string.',
                    $field
                ));
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
        if ($id === null && preg_match('~/(\d+)$~', $iri, $m)) {
            $id = (int) $m[1];
        }

        if ($id === null) {
            throw new BadRequestHttpException(sprintf(
                'Invalid IRI type for field "%s". Expected "%s".',
                $field,
                $expectedClass
            ));
        }

        $entity = $this->em->getRepository($expectedClass)->find($id);

        if (!$entity) {
            throw new BadRequestHttpException(sprintf(
                'Resource not found for field "%s" (id: %s).',
                $field,
                (string) $id
            ));
        }

        return $entity;
    }

}
