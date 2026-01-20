<?php

namespace App\ApiResource\State\TaskInstance;

use App\Entity\TaskInstance;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Mapper\TaskInstance\TaskInstanceMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;


final readonly class TaskInstanceUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TaskInstanceMapper $taskInstanceMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof TaskInstanceUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (!$entity instanceof TaskInstance) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', TaskInstance::class, (string) $id));
        }

        $updatedEntity = $this->taskInstanceMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);
        return $this->taskInstanceMapper->entityToItemDto($entity);
    }
}