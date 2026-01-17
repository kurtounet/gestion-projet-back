<?php

namespace App\ApiResource\State\TaskInstance;

use App\Entity\TaskInstance;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\ApiResource\Dto\TaskInstance\TaskInstanceItemDto;
use App\Entity\User;
use App\Entity\TaskTemplate;
use App\Entity\SprintInstance;
use App\Entity\Priority;
use App\Entity\Status;
use App\Entity\TypeTask;
use App\Entity\Comment;


final readonly class TaskInstanceCreateProcessor implements ProcessorInterface
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
        if (!($operation instanceof Post) || !($data instanceof TaskInstanceCreateDto)) {
            return $data;
        }

        // Créer et mapper l'entité depuis le DTO
        $entity = $this->mapDtoToEntity($data);

        // Persister l'entité
        $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        // Retourner le DTO pour l'output
        return $this->entityToDto($entity);

    }

    private function mapDtoToEntity(TaskInstanceCreateDto $dto): TaskInstance
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
// TODO: Relations ToOne
            $entity->setUser($dto->user);

            $entity->setTaskTemplate($dto->taskTemplate);

            $entity->setSprintInstance($dto->sprintInstance);

            $entity->setPriority($dto->priority);

            $entity->setStatus($dto->status);

            $entity->setTypeTask($dto->typeTask);

            $entity->setParentTask($dto->parentTask);

            $entity->setDependency($dto->dependency);

            $entity->setComment($dto->comment);
// TODO: Relations ToMany
        // user (ToMany => array of IRIs)
        $entity->setUser($this->resolveIri($dto->user ?? null, User::class, 'user', required: true));
        // tasktemplate (ToMany => array of IRIs)
        $entity->setTaskTemplate($this->resolveIri($dto->tasktemplate ?? null, TaskTemplate::class, 'tasktemplate', required: true));
        // sprintinstance (ToMany => array of IRIs)
        $entity->setSprintInstance($this->resolveIri($dto->sprintinstance ?? null, SprintInstance::class, 'sprintinstance', required: true));
        // priority (ToMany => array of IRIs)
        $entity->setPriority($this->resolveIri($dto->priority ?? null, Priority::class, 'priority', required: true));
        // status (ToMany => array of IRIs)
        $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));
        // typetask (ToMany => array of IRIs)
        $entity->setTypeTask($this->resolveIri($dto->typetask ?? null, TypeTask::class, 'typetask', required: true));
        // taskinstance (ToMany => array of IRIs)
        $entity->setTaskInstance($this->resolveIri($dto->taskinstance ?? null, TaskInstance::class, 'taskinstance', required: false));
        // taskinstance (ToMany => array of IRIs)
        $entity->setTaskInstance($this->resolveIri($dto->taskinstance ?? null, TaskInstance::class, 'taskinstance', required: false));
        // comment (ToMany => array of IRIs)
        $entity->setComment($this->resolveIri($dto->comment ?? null, Comment::class, 'comment', required: false));

        return $entity;
    }

    private function entityToDto(TaskInstance $entity): TaskInstanceItemDto
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
// TODO: Relations ToOne
        // user (ToOne => IRI)
        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(User::class,$entity->getUser()->getId())
            : null;
        // tasktemplate (ToOne => IRI)
        $dto->tasktemplate = $entity->getTasktemplate()
            ? ($this->iriFromResource)(TaskTemplate::class,$entity->getTasktemplate()->getId())
            : null;
        // sprintinstance (ToOne => IRI)
        $dto->sprintinstance = $entity->getSprintinstance()
            ? ($this->iriFromResource)(SprintInstance::class,$entity->getSprintinstance()->getId())
            : null;
        // priority (ToOne => IRI)
        $dto->priority = $entity->getPriority()
            ? ($this->iriFromResource)(Priority::class,$entity->getPriority()->getId())
            : null;
        // status (ToOne => IRI)
        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
            : null;
        // typetask (ToOne => IRI)
        $dto->typetask = $entity->getTypetask()
            ? ($this->iriFromResource)(TypeTask::class,$entity->getTypetask()->getId())
            : null;
        // taskinstance (ToOne => IRI)
        $dto->taskinstance = $entity->getTaskinstance()
            ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
            : null;
        // taskinstance (ToOne => IRI)
        $dto->taskinstance = $entity->getTaskinstance()
            ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
            : null;
        // comment (ToOne => IRI)
        $dto->comment = $entity->getComment()
            ? ($this->iriFromResource)(Comment::class,$entity->getComment()->getId())
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
