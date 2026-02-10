<?php

namespace App\ApiResource\State\Priority;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Mapper\Priority\PriorityMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class PriorityCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private PriorityMapper $priorityMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Post) || ! ($data instanceof PriorityCreateDto)) {
            return $data;
        }

        $entity = $this->priorityMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->priorityMapper->entityToItemDto($entity);
    }
}
