<?php

namespace App\ApiResource\Mapper\Context;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\Context\ContextCollectionItemDto;
use App\ApiResource\Dto\Context\ContextCreateDto;
use App\ApiResource\Dto\Context\ContextItemDto;
use App\ApiResource\Dto\Context\ContextUpdateDto;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Context;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContextMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(Context $entity): ContextItemDto
    {
        $dto = new ContextItemDto();
        $dto->id = $entity->getId();
        $dto->contextLabel = $entity->getContextLabel();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        return $dto;
    }

    public function entityToCollectionDto(Context $entity): ContextCollectionItemDto
    {
        $dto = new ContextCollectionItemDto();
        $dto->id = $entity->getId();
        $dto->contextLabel = $entity->getContextLabel();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        return $dto;
    }

    public function createDtoToEntity(ContextCreateDto $dto): Context
    {
        $entity = new Context();
        $entity->setContextLabel($dto->contextLabel);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        return $entity;
    }

    public function updateDtoToEntity(Context $entity, ContextUpdateDto $dto): Context
    {
        $entity = new Context();
        $entity->setContextLabel($dto->contextLabel);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        return $entity;
    }

    /*
    public function mapEntityToCreateDto(Context $entity): ContextCreateDto
    {
               $dto = new ContextCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(Context $entity, object $dto): void
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
