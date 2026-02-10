<?php

namespace App\ApiResource\State\Framework;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use App\ApiResource\Mapper\Framework\FrameworkMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FrameworkCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private FrameworkMapper $frameworkMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof FrameworkCreateDto)) {
            return $data;
        }

        $entity = $this->frameworkMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->frameworkMapper->entityToItemDto($entity);
    }
}
