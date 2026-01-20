<?php
namespace App\ApiResource\State\SprintInstance;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\SprintInstance\SprintInstanceMapper;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;


final readonly class SprintInstanceCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private SprintInstanceMapper $sprintInstanceMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof SprintInstanceCreateDto)) {
            return $data;
        }

        $entity = $this->sprintInstanceMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->sprintInstanceMapper->entityToItemDto($entity);
    }
}
