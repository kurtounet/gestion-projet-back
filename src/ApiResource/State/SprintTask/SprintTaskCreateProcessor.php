<?php

namespace App\ApiResource\State\SprintTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\SprintTask\SprintTaskCreateDto;
use App\ApiResource\Mapper\SprintTask\SprintTaskMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintTaskCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private SprintTaskMapper $sprintTaskMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof SprintTaskCreateDto)) {
            return $data;
        }

        $entity = $this->sprintTaskMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->sprintTaskMapper->entityToItemDto($entity);
    }
}
