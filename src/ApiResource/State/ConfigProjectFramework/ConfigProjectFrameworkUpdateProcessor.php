<?php

namespace App\ApiResource\State\ConfigProjectFramework;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkUpdateDto;
use App\ApiResource\Mapper\ConfigProjectFramework\ConfigProjectFrameworkMapper;
use App\Entity\ConfigProjectFramework;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ConfigProjectFrameworkUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ConfigProjectFrameworkMapper $configProjectFrameworkMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof ConfigProjectFrameworkUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (! $entity instanceof ConfigProjectFramework) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', ConfigProjectFramework::class, (string) $id));
        }

        $updatedEntity = $this->configProjectFrameworkMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->configProjectFrameworkMapper->entityToItemDto($entity);
    }
}
