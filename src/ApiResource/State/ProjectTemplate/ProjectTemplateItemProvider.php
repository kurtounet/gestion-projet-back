<?php

namespace App\ApiResource\State\ProjectTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ProjectTemplate\ProjectTemplateMapper;
use App\Entity\ProjectTemplate;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectTemplateItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private ProjectTemplateMapper $projectTemplateMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof ProjectTemplate) {
            return $entity;
        }

        return $this->projectTemplateMapper->entityToItemDto($entity);
    }
}
