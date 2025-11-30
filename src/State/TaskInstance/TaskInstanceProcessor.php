<?php

declare(strict_types=1);

namespace App\State\TaskInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\ItemOperationInterface;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TaskInstance;

/**
 * Processor pour l'entité TaskInstance.
 *
 * À brancher dans la ressource API Platform :
 *  - via attribut : processor: App\State\TaskInstance\TaskInstanceProcessor::class
 *  - ou via config YAML/XML.
 *
 * Si tu utilises des DTO (CreateTaskInstanceDto / UpdateTaskInstanceDto / TaskInstanceResponseDto),
 * adapte la méthode process() pour transformer DTO <-> entité.
 */
final class TaskInstanceProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param mixed $data DTO ou entité selon ta config API Platform
     * @return mixed
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // Exemple très basique si $data est déjà une entité TaskInstance
        // À adapter si $data est un DTO :

        if ($operation instanceof CollectionOperationInterface) {
            // POST (création)
            if (!$data instanceof TaskInstance) {
                // TODO: hydrater une entité TaskInstance à partir d'un DTO
                // $entity = new TaskInstance(...);
                // $this->entityManager->persist($entity);
                // $this->entityManager->flush();
                // return $entity;

                return $data;
            }

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $data;
        }

        if ($operation instanceof ItemOperationInterface) {
            // PUT/PATCH/DELETE sur un item
            if ($operation->getMethod() === 'DELETE') {
                if ($data instanceof TaskInstance) {
                    $this->entityManager->remove($data);
                    $this->entityManager->flush();
                }

                return null;
            }

            // PUT/PATCH : mise à jour
            if ($data instanceof TaskInstance) {
                $this->entityManager->persist($data);
                $this->entityManager->flush();

                return $data;
            }

            // TODO: cas DTO -> entité à gérer ici
        }

        // Autres cas (custom operation, subresource, etc.)
        return $data;
    }
}
