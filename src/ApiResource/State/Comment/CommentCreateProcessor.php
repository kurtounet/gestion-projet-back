<?php

namespace App\ApiResource\State\Comment;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Dto\Comment\CommentCreateDto;
use App\ApiResource\Mapper\Comment\CommentMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CommentCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private CommentMapper $commentMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof CommentCreateDto)) {
            return $data;
        }

        $entity = $this->commentMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        return $this->commentMapper->entityToItemDto($entity);
    }
}
