<?php

namespace App\ApiResource\State\SprintTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateUpdateDto;
use App\ApiResource\Mapper\SprintTemplate\SprintTemplateMapper;
use App\Entity\SprintTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintTemplateUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private SprintTemplateMapper $sprintTemplateMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof SprintTemplateUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (!$entity instanceof SprintTemplate) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', SprintTemplate::class, (string) $id));
        }

        $updatedEntity = $this->sprintTemplateMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->sprintTemplateMapper->entityToItemDto($entity);
    }
}
