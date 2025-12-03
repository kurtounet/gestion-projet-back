<?php

declare(strict_types=1);

namespace App\State\Comment;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\Comment;
use App\Dto\Comment\CommentResponseDto;


final class CommentProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

     /**
     * @return Comment|iterable<Comment>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof Comment) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof Comment) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(Comment $entity) //: CommentResponseDto
    {

        return new CommentResponseDto(

            
$entity->getId(),
$entity->getSubject(),
$entity->getContent(),
$entity->getCreatedAt(),
$entity->getUpdatedAt(),
            
$entity->getTask()->getId(),
$entity->getUser()->getId(),

        );

    }
}
