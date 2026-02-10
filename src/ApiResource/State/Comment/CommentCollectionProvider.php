<?php

namespace App\ApiResource\State\Comment;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Comment\CommentMapper;
use App\Entity\Comment;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CommentCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private CommentMapper $commentMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (! $operation instanceof CollectionOperationInterface) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (! is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {
            if (! $entity instanceof Comment) {
                continue;
            }
            $items[] = $this->commentMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
