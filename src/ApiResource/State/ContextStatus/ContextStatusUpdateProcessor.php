<?php

namespace App\ApiResource\State\ContextStatus;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\ContextStatus\ContextStatusUpdateDto;
use App\ApiResource\Mapper\ContextStatus\ContextStatusMapper;
use App\Entity\ContextStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ContextStatusUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ContextStatusMapper $contextStatusMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof ContextStatusUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ContextStatus::class)->find($id);

        if (! $entity instanceof ContextStatus) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', ContextStatus::class, (string) $id));
        }

        $updatedEntity = $this->contextStatusMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->contextStatusMapper->entityToItemDto($entity);
    }
}
