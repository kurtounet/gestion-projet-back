<?php

namespace App\ApiResource\State\SprintTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateCreateDto;
use App\ApiResource\Mapper\SprintTemplate\SprintTemplateMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintTemplateCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private SprintTemplateMapper $sprintTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Post) || ! ($data instanceof SprintTemplateCreateDto)) {
            return $data;
        }

        $entity = $this->sprintTemplateMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->sprintTemplateMapper->entityToItemDto($entity);
    }
}
