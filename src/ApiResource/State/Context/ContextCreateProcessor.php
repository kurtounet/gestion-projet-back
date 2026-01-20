<?php
namespace App\ApiResource\State\Context;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\Context\ContextMapper;
use App\ApiResource\Dto\Context\ContextCreateDto;


final readonly class ContextCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private ContextMapper $contextMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof ContextCreateDto)) {
            return $data;
        }

        $entity = $this->contextMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->contextMapper->entityToItemDto($entity);
    }
}
