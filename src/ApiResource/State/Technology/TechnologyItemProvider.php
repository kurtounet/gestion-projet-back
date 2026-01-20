<?php

namespace App\ApiResource\State\Technology;

use App\Entity\Technology;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Technology\TechnologyMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TechnologyItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private TechnologyMapper $technologyMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Technology) {
            return $entity;
        }

        return $this->technologyMapper->entityToItemDto($entity);
    }
}