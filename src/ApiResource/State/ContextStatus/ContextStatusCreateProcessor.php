<?php
namespace App\ApiResource\State\ContextStatus;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\ContextStatus\ContextStatusMapper;
use App\ApiResource\Dto\ContextStatus\ContextStatusCreateDto;


final readonly class ContextStatusCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private ContextStatusMapper $contextStatusMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof ContextStatusCreateDto)) {
            return $data;
        }

        $entity = $this->contextStatusMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->contextStatusMapper->entityToItemDto($entity);
    }
}
