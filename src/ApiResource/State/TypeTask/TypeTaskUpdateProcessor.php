<?php

namespace App\ApiResource\State\TypeTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\TypeTask\TypeTaskUpdateDto;
use App\ApiResource\Mapper\TypeTask\TypeTaskMapper;
use App\Entity\TypeTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TypeTaskUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TypeTaskMapper $typeTaskMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof TypeTaskUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (! $entity instanceof TypeTask) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', TypeTask::class, (string) $id));
        }

        $updatedEntity = $this->typeTaskMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->typeTaskMapper->entityToItemDto($entity);
    }
}
