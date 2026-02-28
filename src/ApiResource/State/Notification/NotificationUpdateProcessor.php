<?php

namespace App\ApiResource\State\Notification;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Notification\NotificationUpdateDto;
use App\ApiResource\Mapper\Notification\NotificationMapper;
use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class NotificationUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private NotificationMapper $notificationMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! ($operation instanceof Patch) || ! ($data instanceof NotificationUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(Notification::class)->find($id);

        if (! $entity instanceof Notification) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', Notification::class, (string) $id));
        }

        $updatedEntity = $this->notificationMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);

        return $this->notificationMapper->entityToItemDto($entity);
    }
}
