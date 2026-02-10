<?php

namespace App\ApiResource\State\ProjectTemplateSprintTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\ApiResource\Mapper\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateMapper;
use App\Entity\ProjectTemplateSprintTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectTemplateSprintTemplateUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProjectTemplateSprintTemplateMapper $projectTemplateSprintTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof ProjectTemplateSprintTemplateUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (!$entity instanceof ProjectTemplateSprintTemplate) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', ProjectTemplateSprintTemplate::class, (string) $id));
        }

        $updatedEntity = $this->projectTemplateSprintTemplateMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->projectTemplateSprintTemplateMapper->entityToItemDto($entity);
    }
}
