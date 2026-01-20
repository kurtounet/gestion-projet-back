<?php
namespace App\ApiResource\State\Notification;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\Notification\NotificationMapper;
use App\ApiResource\Dto\Notification\NotificationCreateDto;


final readonly class NotificationCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private NotificationMapper $notificationMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof NotificationCreateDto)) {
            return $data;
        }

        $entity = $this->notificationMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->notificationMapper->entityToItemDto($entity);
    }
}
