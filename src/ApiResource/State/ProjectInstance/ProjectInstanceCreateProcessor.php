<?php

namespace App\ApiResource\State\ProjectInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Mapper\ProjectInstance\ProjectInstanceMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectInstanceCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProjectInstanceMapper $projectInstanceMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof ProjectInstanceCreateDto)) {
            return $data;
        }

        $entity = $this->projectInstanceMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->projectInstanceMapper->entityToItemDto($entity);
    }
}
