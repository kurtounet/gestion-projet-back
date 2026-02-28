<?php

namespace App\ApiResource\State\Context;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Context\ContextUpdateDto;
use App\ApiResource\Mapper\Context\ContextMapper;
use App\Entity\Context;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ContextUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ContextMapper $contextMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof ContextUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(Context::class)->find($id);

        if (! $entity instanceof Context) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', Context::class, (string) $id));
        }

        $updatedEntity = $this->contextMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->contextMapper->entityToItemDto($entity);
    }
}
