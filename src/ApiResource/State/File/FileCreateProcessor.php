<?php
namespace App\ApiResource\State\File;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\File\FileMapper;
use App\ApiResource\Dto\File\FileCreateDto;


final readonly class FileCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private FileMapper $fileMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof FileCreateDto)) {
            return $data;
        }

        $entity = $this->fileMapper->createDtoToEntity($data);
        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
        return $this->fileMapper->entityToItemDto($entity);
    }
}
