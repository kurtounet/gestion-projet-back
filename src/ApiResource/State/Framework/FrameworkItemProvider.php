<?php

namespace App\ApiResource\State\Framework;

use App\Entity\Framework;
use App\ApiResource\Dto\Framework\FrameworkItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\ApiResource\Resource\Technology\TechnologyResource;

final readonly class FrameworkItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Framework) {
            return $entity;
        }

        $dto = new FrameworkItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->name = $entity->getName();

            $dto->version = $entity->getVersion();

            $dto->configuration = $entity->getConfiguration();

            $dto->icon = $entity->getIcon();

            $dto->color = $entity->getColor();

        // 2) Relations ToOne => IRI
        // technology (ToOne => IRI)
        $dto->technology = $entity->getTechnology()
            ? ($this->iriFromResource)(TechnologyResource::class,$entity->getTechnology()->getId())
            : null;

        // 3) Relations ToMany => array of IRIs
        // configProjectFrameworks (ToMany => array of IRIs)
        $dto->configProjectFrameworks = $this->toIriList($entity->getConfigProjectFrameworks(), ConfigProjectFrameworkResource::class);

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
}