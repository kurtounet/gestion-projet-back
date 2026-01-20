<?php
namespace App\ApiResource\State\TaskTemplate;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\TaskTemplate\TaskTemplateMapper;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;


final readonly class TaskTemplateCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private TaskTemplateMapper $taskTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof TaskTemplateCreateDto)) {
            return $data;
        }

        $entity = $this->taskTemplateMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->taskTemplateMapper->entityToItemDto($entity);
    }
}
