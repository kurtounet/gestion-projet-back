<?php

namespace App\ApiResource\State\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Resource\Framework\FrameworkResource;

final readonly class ConfigProjectFrameworkItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof ConfigProjectFramework) {
            return $entity;
        }

        $dto = new ConfigProjectFrameworkItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->name = $entity->getName();

            $dto->configuration = $entity->getConfiguration();

            $dto->architecture = $entity->getArchitecture();

            $dto->script = $entity->getScript();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

        // 2) Relations ToOne => IRI
        // projectInstance (ToOne => IRI)
        $dto->projectInstance = $entity->getProjectInstance()
            ? ($this->iriFromResource)(ProjectInstanceResource::class,$entity->getProjectInstance()->getId())
            : null;

        // framework (ToOne => IRI)
        $dto->framework = $entity->getFramework()
            ? ($this->iriFromResource)(FrameworkResource::class,$entity->getFramework()->getId())
            : null;

        // 3) Relations ToMany => array of IRIs
        // No ToMany relations


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