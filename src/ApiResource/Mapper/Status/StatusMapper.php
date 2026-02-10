<?php

namespace App\ApiResource\Mapper\Status;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\Status\StatusCollectionItemDto;
use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Dto\Status\StatusItemDto;
use App\ApiResource\Dto\Status\StatusUpdateDto;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class StatusMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(Status $entity): StatusItemDto
    {
        $dto = new StatusItemDto();
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->color = $entity->getColor();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

        $dto->context = $entity->getContext()
            ? ($this->iriFromResource)(Context::class,$entity->getContext()->getId())
            : null;


        */
        return $dto;
    }

    public function entityToCollectionDto(Status $entity): StatusCollectionItemDto
    {
        $dto = new StatusCollectionItemDto();
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->color = $entity->getColor();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

         $dto->context = $entity->getContext()
             ? ($this->iriFromResource)(Context::class,$entity->getContext()->getId())
             : null;


        */
        return $dto;
    }

    public function createDtoToEntity(StatusCreateDto $dto): Status
    {
        $entity = new Status();
        $entity->setLabel($dto->label);
        $entity->setColor($dto->color);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        /*
                    $entity->setContext($dto->context);


         $entity->setContext($this->resolveIri($dto->context ?? null, Context::class, 'context', required: true));
        */

        return $entity;
    }

    public function updateDtoToEntity(Status $entity, StatusUpdateDto $dto): Status
    {
        $entity = new Status();
        $entity->setLabel($dto->label);
        $entity->setColor($dto->color);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        /*
                    $entity->setContext($dto->context);


        */
        return $entity;
    }

    /*
    public function mapEntityToCreateDto(Status $entity): StatusCreateDto
    {
               $dto = new StatusCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(Status $entity, object $dto): void
    {
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
    }

    private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (! is_object($item)) {
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

        if (! $entity) {
            throw new BadRequestHttpException(sprintf('Resource not found for field "%s" (id: %s).', $field, (string) $id));
        }

        return $entity;
    }
}
