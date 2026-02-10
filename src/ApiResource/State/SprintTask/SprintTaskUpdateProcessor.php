<?php

namespace App\ApiResource\State\SprintTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\SprintTask\SprintTaskUpdateDto;
use App\ApiResource\Mapper\SprintTask\SprintTaskMapper;
use App\Entity\SprintTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintTaskUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private SprintTaskMapper $sprintTaskMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof SprintTaskUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (! $entity instanceof SprintTask) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', SprintTask::class, (string) $id));
        }

        $updatedEntity = $this->sprintTaskMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->sprintTaskMapper->entityToItemDto($entity);
    }
}
