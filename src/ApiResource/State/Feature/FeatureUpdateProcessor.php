<?php

namespace App\ApiResource\State\Feature;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Feature\FeatureUpdateDto;
use App\ApiResource\Mapper\Feature\FeatureMapper;
use App\Entity\Feature;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FeatureUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private FeatureMapper $featureMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof FeatureUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(Feature::class)->find($id);

        if (! $entity instanceof Feature) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', Feature::class, (string) $id));
        }

        $updatedEntity = $this->featureMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->featureMapper->entityToItemDto($entity);
    }
}
