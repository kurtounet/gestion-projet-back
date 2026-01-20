<?php

namespace App\ApiResource\State\ProjectTemplate;

use App\Entity\ProjectTemplate;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Mapper\ProjectTemplate\ProjectTemplateMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateUpdateDto;


final readonly class ProjectTemplateUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProjectTemplateMapper $projectTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof ProjectTemplateUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (!$entity instanceof ProjectTemplate) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', ProjectTemplate::class, (string) $id));
        }

        $updatedEntity = $this->projectTemplateMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);
        return $this->projectTemplateMapper->entityToItemDto($entity);
    }
}