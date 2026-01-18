<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Operation;
use App\Mapper\ProjectInstanceMapper;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;


final readonly class ProjectInstanceUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProjectInstanceMapper $projectInstanceMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof ProjectInstanceUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (!$entity instanceof ProjectInstance) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', ProjectInstance::class, (string) $id));
        }

        $updatedEntity = $this->projectInstanceMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return  $this->projectInstanceMapper->entityToItemDto($entity);
    }
}
