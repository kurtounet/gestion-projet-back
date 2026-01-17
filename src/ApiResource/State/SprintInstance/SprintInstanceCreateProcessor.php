<?php

namespace App\ApiResource\State\SprintInstance;

use App\Entity\SprintInstance;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\ApiResource\Dto\SprintInstance\SprintInstanceItemDto;
use App\Entity\Priority;
use App\Entity\SprintTemplate;
use App\Entity\Status;
use App\Entity\Comment;
use App\Entity\ProjectInstance;


final readonly class SprintInstanceCreateProcessor implements ProcessorInterface
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
        if (!($operation instanceof Post) || !($data instanceof SprintInstanceCreateDto)) {
            return $data;
        }

        // Créer et mapper l'entité depuis le DTO
        $entity = $this->mapDtoToEntity($data);

        // Persister l'entité
        $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        // Retourner le DTO pour l'output
        return $this->entityToDto($entity);

    }

    private function mapDtoToEntity(SprintInstanceCreateDto $dto): SprintInstance
    {
        $entity = new SprintInstance();

            $entity->setName($dto->name);

            $entity->setDescription($dto->description);

            $entity->setIcon($dto->icon);

            $entity->setColor($dto->color);

            $entity->setStartDate($dto->startDate);

            $entity->setEndDate($dto->endDate);

            $entity->setPosition($dto->position);

            $entity->setCreatedAt($dto->createdAt);

            $entity->setUpdatedAt($dto->updatedAt);

            $entity->setCreatedByUser($dto->createdByUser);

            $entity->setUpdatedByUser($dto->updatedByUser);
// TODO: Relations ToOne
            $entity->setPriority($dto->priority);

            $entity->setSprintTemplate($dto->sprintTemplate);

            $entity->setStatus($dto->status);

            $entity->setComment($dto->comment);

            $entity->setSprintDependency($dto->sprintDependency);

            $entity->setProjectInstance($dto->projectInstance);
// TODO: Relations ToMany
        // priority (ToMany => array of IRIs)
        $entity->setPriority($this->resolveIri($dto->priority ?? null, Priority::class, 'priority', required: true));
        // sprinttemplate (ToMany => array of IRIs)
        $entity->setSprintTemplate($this->resolveIri($dto->sprinttemplate ?? null, SprintTemplate::class, 'sprinttemplate', required: true));
        // status (ToMany => array of IRIs)
        $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));
        // comment (ToMany => array of IRIs)
        $entity->setComment($this->resolveIri($dto->comment ?? null, Comment::class, 'comment', required: false));
        // sprintinstance (ToMany => array of IRIs)
        $entity->setSprintInstance($this->resolveIri($dto->sprintinstance ?? null, SprintInstance::class, 'sprintinstance', required: false));
        // projectinstance (ToMany => array of IRIs)
        $entity->setProjectInstance($this->resolveIri($dto->projectinstance ?? null, ProjectInstance::class, 'projectinstance', required: true));

        return $entity;
    }

    private function entityToDto(SprintInstance $entity): SprintInstanceItemDto
    {
        $dto = new SprintInstanceItemDto();


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
// TODO: Relations ToOne
        // priority (ToOne => IRI)
        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
            : null;
        // sprinttemplate (ToOne => IRI)
        $dto->sprinttemplate = $entity->getSprinttemplate()
            ? ($this->iriFromResource)(SprintTemplate::class,$entity->getSprinttemplate()->getId())
            : null;
        // status (ToOne => IRI)
        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
            : null;
        // comment (ToOne => IRI)
        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
            : null;
        // sprintinstance (ToOne => IRI)
        $dto->sprintinstance = $entity->getSprintinstance()
            ? ($this->iriFromResource)(SprintInstance::class,$entity->getSprintinstance()->getId())
            : null;
        // projectinstance (ToOne => IRI)
        $dto->projectinstance = $entity->getProjectinstance()
            ? ($this->iriFromResource)(ProjectInstance::class,$entity->getProjectinstance()->getId())
            : null;
// TODO: Relations ToMany


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
