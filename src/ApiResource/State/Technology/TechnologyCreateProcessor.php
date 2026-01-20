<?php
namespace App\ApiResource\State\Technology;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\Technology\TechnologyMapper;
use App\ApiResource\Dto\Technology\TechnologyCreateDto;


final readonly class TechnologyCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private TechnologyMapper $technologyMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof TechnologyCreateDto)) {
            return $data;
        }

        $entity = $this->technologyMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->technologyMapper->entityToItemDto($entity);
    }
}
