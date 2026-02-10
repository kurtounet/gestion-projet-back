<?php

namespace App\ApiResource\State\Feature;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Feature\FeatureCreateDto;
use App\ApiResource\Mapper\Feature\FeatureMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FeatureCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private FeatureMapper $featureMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof FeatureCreateDto)) {
            return $data;
        }

        $entity = $this->featureMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->featureMapper->entityToItemDto($entity);
    }
}
