<?php
namespace App\ApiResource\State\TaskInstance;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\TaskInstance\TaskInstanceMapper;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;


final readonly class TaskInstanceCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private TaskInstanceMapper $taskInstanceMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof TaskInstanceCreateDto)) {
            return $data;
        }

        $entity = $this->taskInstanceMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->taskInstanceMapper->entityToItemDto($entity);
    }
}
