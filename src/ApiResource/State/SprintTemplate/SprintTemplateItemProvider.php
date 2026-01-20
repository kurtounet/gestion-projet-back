<?php

namespace App\ApiResource\State\SprintTemplate;

use App\Entity\SprintTemplate;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\SprintTemplate\SprintTemplateMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintTemplateItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private SprintTemplateMapper $sprintTemplateMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof SprintTemplate) {
            return $entity;
        }

        return $this->sprintTemplateMapper->entityToItemDto($entity);
    }
}