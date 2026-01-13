<?php

namespace App\ApiResource\State\Comment;

use App\Entity\Comment;
use App\ApiResource\Dto\Comment\CommentItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\TaskInstance\TaskInstanceResource;
use App\ApiResource\Resource\User\UserResource;

final readonly class CommentItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private IriFromResource $iriFromResource,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Comment) {
            return $entity;
        }

        $dto = new CommentItemDto();

        // 1) Scalars
            $dto->id = $entity->getId();

            $dto->subject = $entity->getSubject();

            $dto->content = $entity->getContent();

            $dto->createdAt = $entity->getCreatedAt();

            $dto->updatedAt = $entity->getUpdatedAt();

        // 2) Relations ToOne => IRI
        // task (ToOne => IRI)
        $dto->task = $entity->getTask()
            ? ($this->iriFromResource)(TaskInstanceResource::class,$entity->getTask()->getId())
            : null;

        // user (ToOne => IRI)
        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(UserResource::class,$entity->getUser()->getId())
            : null;

        // 3) Relations ToMany => array of IRIs
        // No ToMany relations


        return $dto;
    }

    private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (!is_object($item)) {
                continue;
            }

            $iri = ($this->iriFromResource)($resourceClass, $item->getId());
            if (null !== $iri) {
                $iris[] = $iri;
            }
        }

        return $iris;
    }
}