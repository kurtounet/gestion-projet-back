<?php

declare(strict_types=1);

namespace App\State\Technologie;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\ItemOperationInterface;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Technologie;

/**
 * Processor pour l'entité Technologie.
 *
 * À brancher dans la ressource API Platform :
 *  - via attribut : processor: App\State\Technologie\TechnologieProcessor::class
 *  - ou via config YAML/XML.
 *
 * Si tu utilises des DTO (CreateTechnologieDto / UpdateTechnologieDto / TechnologieResponseDto),
 * adapte la méthode process() pour transformer DTO <-> entité.
 */
final class TechnologieProcessor implements ProcessorInterface
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
        // Exemple très basique si $data est déjà une entité Technologie
        // À adapter si $data est un DTO :

        if ($operation instanceof CollectionOperationInterface) {
            // POST (création)
            if (!$data instanceof Technologie) {
                // TODO: hydrater une entité Technologie à partir d'un DTO
                // $entity = new Technologie(...);
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
                if ($data instanceof Technologie) {
                    $this->entityManager->remove($data);
                    $this->entityManager->flush();
                }

                return null;
            }

            // PUT/PATCH : mise à jour
            if ($data instanceof Technologie) {
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
