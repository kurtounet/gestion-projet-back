<?php

namespace App\ApiResource\State\Comment;

use App\Entity\Comment;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Comment\CommentMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CommentItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private CommentMapper $commentMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Comment) {
            return $entity;
        }

        return $this->commentMapper->entityToItemDto($entity);
    }
}