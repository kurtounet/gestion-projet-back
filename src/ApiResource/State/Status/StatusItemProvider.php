<?php

namespace App\ApiResource\State\Status;

use App\Entity\Status;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Status\StatusMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class StatusItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private StatusMapper $statusMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Status) {
            return $entity;
        }

        return $this->statusMapper->entityToItemDto($entity);
    }
}