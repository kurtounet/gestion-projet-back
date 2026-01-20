<?php

namespace App\ApiResource\State\User;

use App\Entity\User;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Mapper\User\UserMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\User\UserUpdateDto;


final readonly class UserUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserMapper $userMapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof UserUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);

        if (!$entity instanceof User) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', User::class, (string) $id));
        }

        $updatedEntity = $this->userMapper->updateDtoToEntity($entity, $data);
        $entity = $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context);
        return $this->userMapper->entityToItemDto($entity);
    }
}