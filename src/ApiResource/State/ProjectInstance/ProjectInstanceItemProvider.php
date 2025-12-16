<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceResponseDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionResponse;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\Status\StatusResource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

/**
 * Provider custom pour ProjectInstance.
 * Transforme les entités en DTOs pour la sortie API.
 *
 * @implements ProviderInterface<ProjectInstanceCollectionResponse|ProjectInstanceResponseDto>
 */
final readonly class ProjectInstanceItemProvider implements ProviderInterface
{
    public function __construct(
        // #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        // private ProviderInterface $itemProvider,
        private EntityManagerInterface $em,
        private IriConverterInterface $iriConverter,

    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $id = $uriVariables['id'] ?? null;

        if ($id === null || $id === '') {
            throw new BadRequestHttpException('Missing "id" uri variable for ProjectInstance item operation.');
        }
        // $entity = $this->itemProvider->provide($operation, $uriVariables, $context);
        $entity = $this->em->createQueryBuilder()
            ->select('pi, s, p, pt, c')
            ->from(ProjectInstance::class, 'pi')
            ->leftJoin('pi.status', 's')
            ->leftJoin('pi.priority', 'p')
            ->leftJoin('pi.projectTemplate', 'pt')
            ->leftJoin('pi.comment', 'c')
            ->andWhere('pi.id = :id')
            ->setParameter('id', (int) $id)
            ->getQuery()
            ->getOneOrNullResult();



        if (!$entity instanceof ProjectInstance) {
            throw new NotFoundHttpException(sprintf('ProjectInstance "%s" not found.', (string) $id));
        }

        return new ProjectInstanceItemDto(
            id: $entity->getId(),
            name: $entity->getName(),
            pathFileDatabase: $entity->getPathFileDatabase(),
            pathProject: $entity->getPathProject(),
            description: $entity->getDescription(),
            icon: $entity->getIcon(),
            color: $entity->getColor(),
            isFavory: $entity->isFavory(),
            position: $entity->getPosition(),
            startDate: $entity->getStartDate(),
            endDate: $entity->getEndDate(),
            createdByUser: $entity->getCreatedByUser(),
            updatedByUser: $entity->getUpdatedByUser(),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt(),

            status: $entity->getStatus()
                ? $this->iriConverter->getIriFromResource(
                    StatusResource::class,
                    context: ['uri_variables' => ['id' => $entity->getStatus()->getId()]]
                )
                : null,
            priority: $entity->getPriority()
                ? $this->iriConverter->getIriFromResource(
                    PriorityResource::class,
                    context: ['uri_variables' => ['id' => $entity->getPriority()->getId()]]
                )
                : null,

            projectTemplate: $this->iriFromResource(ProjectTemplateResource::class, $entity->getProjectTemplate()?->getId()),
            comment: $this->iriFromResource(CommentResource::class, $entity->getComment()?->getId()),
            // sprintInstances:$entity->getSprintInstances(),
        );
    }

    private function iriFromResource(string $resourceClass, ?int $id): ?string
    {
        if (!$id) {
            return null;
        }

        return $this->iriConverter->getIriFromResource(
            $resourceClass,
            context: ['uri_variables' => ['id' => $id]]
        );
    }
}
