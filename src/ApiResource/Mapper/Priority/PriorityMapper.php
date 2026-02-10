<?php

namespace App\ApiResource\Mapper\Priority;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\Priority\PriorityCollectionItemDto;
use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Dto\Priority\PriorityItemDto;
use App\ApiResource\Dto\Priority\PriorityUpdateDto;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Priority;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PriorityMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(Priority $entity): PriorityItemDto
    {
        $dto = new PriorityItemDto();
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->color = $entity->getColor();
        $dto->priorityNumber = $entity->getPriorityNumber();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        return $dto;
    }

    public function entityToCollectionDto(Priority $entity): PriorityCollectionItemDto
    {
        $dto = new PriorityCollectionItemDto();
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->color = $entity->getColor();
        $dto->priorityNumber = $entity->getPriorityNumber();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        return $dto;
    }

    public function createDtoToEntity(PriorityCreateDto $dto): Priority
    {
        $entity = new Priority();
        $entity->setLabel($dto->label);
        $entity->setColor($dto->color);
        $entity->setPriorityNumber($dto->priorityNumber);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        return $entity;
    }

    public function updateDtoToEntity(Priority $entity, PriorityUpdateDto $dto): Priority
    {
        $entity = new Priority();
        $entity->setLabel($dto->label);
        $entity->setColor($dto->color);
        $entity->setPriorityNumber($dto->priorityNumber);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        return $entity;
    }

    /*
    public function mapEntityToCreateDto(Priority $entity): PriorityCreateDto
    {
               $dto = new PriorityCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(Priority $entity, object $dto): void
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
