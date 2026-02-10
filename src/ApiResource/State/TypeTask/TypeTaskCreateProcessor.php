<?php

namespace App\ApiResource\State\TypeTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\TypeTask\TypeTaskCreateDto;
use App\ApiResource\Mapper\TypeTask\TypeTaskMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TypeTaskCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private TypeTaskMapper $typeTaskMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof TypeTaskCreateDto)) {
            return $data;
        }

        $entity = $this->typeTaskMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->typeTaskMapper->entityToItemDto($entity);
    }
}
