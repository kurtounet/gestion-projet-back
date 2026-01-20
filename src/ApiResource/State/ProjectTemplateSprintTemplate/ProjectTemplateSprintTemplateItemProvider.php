<?php

namespace App\ApiResource\State\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectTemplateSprintTemplateItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private ProjectTemplateSprintTemplateMapper $projectTemplateSprintTemplateMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof ProjectTemplateSprintTemplate) {
            return $entity;
        }

        return $this->projectTemplateSprintTemplateMapper->entityToItemDto($entity);
    }
}