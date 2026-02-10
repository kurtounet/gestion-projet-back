<?php

namespace App\ApiResource\Mapper\ContextStatus;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ContextStatus\ContextStatusCollectionItemDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusCreateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusItemDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusUpdateDto;
use App\ApiResource\Service\IriFromResource;
use App\Entity\ContextStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContextStatusMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(ContextStatus $entity): ContextStatusItemDto
    {
        $dto = new ContextStatusItemDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

        $dto->context = $entity->getContext()
            ? ($this->iriFromResource)(Context::class,$entity->getContext()->getId())
            : null;

        $dto->status = $entity->getStatus()
            ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
            : null;


        */
        return $dto;
    }

    public function entityToCollectionDto(ContextStatus $entity): ContextStatusCollectionItemDto
    {
        $dto = new ContextStatusCollectionItemDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

         $dto->context = $entity->getContext()
             ? ($this->iriFromResource)(Context::class,$entity->getContext()->getId())
             : null;

         $dto->status = $entity->getStatus()
             ? ($this->iriFromResource)(Status::class,$entity->getStatus()->getId())
             : null;


        */
        return $dto;
    }

    public function createDtoToEntity(ContextStatusCreateDto $dto): ContextStatus
    {
        $entity = new ContextStatus();
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        /*
                    $entity->setContext($dto->context);

             $entity->setStatus($dto->status);


         $entity->setContext($this->resolveIri($dto->context ?? null, Context::class, 'context', required: true));

         $entity->setStatus($this->resolveIri($dto->status ?? null, Status::class, 'status', required: true));
        */

        return $entity;
    }

    public function updateDtoToEntity(ContextStatus $entity, ContextStatusUpdateDto $dto): ContextStatus
    {
        $entity = new ContextStatus();
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        /*
                    $entity->setContext($dto->context);

             $entity->setStatus($dto->status);


        */
        return $entity;
    }

    /*
    public function mapEntityToCreateDto(ContextStatus $entity): ContextStatusCreateDto
    {
               $dto = new ContextStatusCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(ContextStatus $entity, object $dto): void
    {
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
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

    private function resolveIri(?string $iri, string $expectedClass, string $field, bool $required = false): ?object
    {
        if (null === $iri || '' === $iri) {
            if ($required) {
                throw new BadRequestHttpException(sprintf('Field "%s" is required and must be a non-empty IRI string.', $field));
            }

            // OPTIONNEL => on retourne null (et on ne throw pas)
            return null;
        }

        try {
            $resource = $this->iriConverter->getResourceFromIri($iri);
        } catch (\Throwable $e) {
            throw new BadRequestHttpException(sprintf('Invalid IRI for field "%s".', $field), $e);
        }

        // 1) Si l’IRI te donne déjà l’Entity attendue, parfait
        if ($resource instanceof $expectedClass) {
            return $resource;
        }

        // 2) Sinon, on tente de récupérer l’ID depuis l’objet ressource
        $id = null;
        if (is_object($resource) && property_exists($resource, 'id')) {
            $id = $resource->id;
        }

        // 3) Fallback: extraire l’ID de la fin de l’IRI (/api/statuses/121)
        if (null === $id && preg_match('~/(\d+)$~', $iri, $m)) {
            $id = (int) $m[1];
        }

        if (null === $id) {
            throw new BadRequestHttpException(sprintf('Invalid IRI type for field "%s". Expected "%s".', $field, $expectedClass));
        }

        $entity = $this->em->getRepository($expectedClass)->find($id);

        if (!$entity) {
            throw new BadRequestHttpException(sprintf('Resource not found for field "%s" (id: %s).', $field, (string) $id));
        }

        return $entity;
    }
}
