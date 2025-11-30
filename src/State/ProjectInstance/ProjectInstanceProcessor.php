<?php

declare(strict_types=1);

namespace App\State\ProjectInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\ItemOperationInterface;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ProjectInstance;

/**
 * Processor pour l'entité ProjectInstance.
 *
 * À brancher dans la ressource API Platform :
 *  - via attribut : processor: App\State\ProjectInstance\ProjectInstanceProcessor::class
 *  - ou via config YAML/XML.
 *
 * Si tu utilises des DTO (CreateProjectInstanceDto / UpdateProjectInstanceDto / ProjectInstanceResponseDto),
 * adapte la méthode process() pour transformer DTO <-> entité.
 */
final class ProjectInstanceProcessor implements ProcessorInterface
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
        // Exemple très basique si $data est déjà une entité ProjectInstance
        // À adapter si $data est un DTO :

        if ($operation instanceof CollectionOperationInterface) {
            // POST (création)
            if (!$data instanceof ProjectInstance) {
                // TODO: hydrater une entité ProjectInstance à partir d'un DTO
                // $entity = new ProjectInstance(...);
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
                if ($data instanceof ProjectInstance) {
                    $this->entityManager->remove($data);
                    $this->entityManager->flush();
                }

                return null;
            }

            // PUT/PATCH : mise à jour
            if ($data instanceof ProjectInstance) {
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
