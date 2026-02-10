<?php

namespace App\ApiResource\State\Status;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Mapper\Status\StatusMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class StatusCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private StatusMapper $statusMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Post) || ! ($data instanceof StatusCreateDto)) {
            return $data;
        }

        $entity = $this->statusMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->statusMapper->entityToItemDto($entity);
    }
}
