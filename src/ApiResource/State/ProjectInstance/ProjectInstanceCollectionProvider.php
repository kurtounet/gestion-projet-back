<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\ApiResource\Resource\ProjectTemplate\ProjectTemplateResource;
use App\ApiResource\Resource\Comment\CommentResource;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\Mapper\ProjectInstanceMapper;

final readonly class ProjectInstanceCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private ProjectInstanceMapper $projectInstanceMapper
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!($operation instanceof CollectionOperationInterface)) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {

            if (!$entity instanceof ProjectInstance) {
                continue;
            }
            $items[] = $this->projectInstanceMapper->mapEntityToCollectionDto($entity);
        }
        return $items;
    }
}
