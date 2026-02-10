<?php

namespace App\ApiResource\State\ProjectTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateCreateDto;
use App\ApiResource\Mapper\ProjectTemplate\ProjectTemplateMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectTemplateCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProjectTemplateMapper $projectTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof ProjectTemplateCreateDto)) {
            return $data;
        }

        $entity = $this->projectTemplateMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->projectTemplateMapper->entityToItemDto($entity);
    }
}
