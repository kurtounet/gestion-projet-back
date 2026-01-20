<?php
namespace App\ApiResource\State\ProjectTemplateSprintTemplate;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateMapper;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;


final readonly class ProjectTemplateSprintTemplateCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProjectTemplateSprintTemplateMapper $projectTemplateSprintTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof ProjectTemplateSprintTemplateCreateDto)) {
            return $data;
        }

        $entity = $this->projectTemplateSprintTemplateMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->projectTemplateSprintTemplateMapper->entityToItemDto($entity);
    }
}
