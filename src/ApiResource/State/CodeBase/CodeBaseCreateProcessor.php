<?php

namespace App\ApiResource\State\CodeBase;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\CodeBase\CodeBaseCreateDto;
use App\ApiResource\Mapper\CodeBase\CodeBaseMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CodeBaseCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private CodeBaseMapper $codeBaseMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Post) || ! ($data instanceof CodeBaseCreateDto)) {
            return $data;
        }

        $entity = $this->codeBaseMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->codeBaseMapper->entityToItemDto($entity);
    }
}
