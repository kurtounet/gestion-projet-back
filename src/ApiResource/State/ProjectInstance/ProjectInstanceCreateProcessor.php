<?php

namespace App\ApiResource\State\ProjectInstance;


use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use App\Mapper\ProjectInstanceMapper;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;


final readonly class ProjectInstanceCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProjectInstanceMapper $projectInstanceMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

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
