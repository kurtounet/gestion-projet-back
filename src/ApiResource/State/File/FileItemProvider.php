<?php

namespace App\ApiResource\State\File;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\File\FileMapper;
use App\Entity\File;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FileItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private FileMapper $fileMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (! $entity instanceof File) {
            return $entity;
        }

        return $this->fileMapper->entityToItemDto($entity);
    }
}
