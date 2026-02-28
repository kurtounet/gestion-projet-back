<?php

namespace App\ApiResource\Mapper\Framework;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use App\ApiResource\Dto\Framework\FrameworkUpdateDto;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\ApiResource\Resource\Framework\FrameworkResource;
use App\ApiResource\Resource\Technology\TechnologyResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Framework;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FrameworkMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(Framework $entity): FrameworkResource
    {
        $dto = new FrameworkResource();
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->type = $entity->getType();
        $dto->version = $entity->getVersion();
        $dto->description = $entity->getDescription();
        $dto->configuration = $entity->getConfiguration();
        $dto->icon = $entity->getIcon();
        $dto->color = $entity->getColor();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->technology = $entity->getTechnology()
            ? ($this->iriFromResource)(TechnologyResource::class, $entity->getTechnology()->getId())
            : null;


        $dto->configProjectFrameworks = $this->toIriList($entity->getConfigProjectFrameworks(), ConfigProjectFrameworkResource::class);

        return $dto;
    }

    public function entityToCollectionDto(Framework $entity): FrameworkResource
    {
        $dto = new FrameworkResource();
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->type = $entity->getType();
        $dto->version = $entity->getVersion();
        $dto->description = $entity->getDescription();
        $dto->configuration = $entity->getConfiguration();
        $dto->icon = $entity->getIcon();
        $dto->color = $entity->getColor();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->technology = $entity->getTechnology()
            ? ($this->iriFromResource)(TechnologyResource::class, $entity->getTechnology()->getId())
            : null;


        $dto->configProjectFrameworks = $this->toIriList($entity->getConfigProjectFrameworks(), ConfigProjectFrameworkResource::class);

        return $dto;
    }

    public function createDtoToEntity(FrameworkCreateDto $dto): Framework
    {
        $entity = new Framework();
        if (null !== $dto->label) {
            $entity->setLabel($dto->label);
        }
        if (null !== $dto->type) {
            $entity->setType($dto->type);
        }
        if (null !== $dto->version) {
            $entity->setVersion($dto->version);
        }
        if (null !== $dto->description) {
            $entity->setDescription($dto->description);
        }
        if (null !== $dto->configuration) {
            $entity->setConfiguration($dto->configuration);
        }
        if (null !== $dto->icon) {
            $entity->setIcon($dto->icon);
        }
        if (null !== $dto->color) {
            $entity->setColor($dto->color);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->technology) {
            $entity->setTechnology($this->resolveIri($dto->technology ?? null, \App\Entity\Technology::class, 'technology', required: false));
        }



        return $entity;



    }

    public function updateDtoToEntity(Framework $entity, FrameworkUpdateDto $dto): Framework
    {
        if (null !== $dto->label) {
            $entity->setLabel($dto->label);
        }
        if (null !== $dto->type) {
            $entity->setType($dto->type);
        }
        if (null !== $dto->version) {
            $entity->setVersion($dto->version);
        }
        if (null !== $dto->description) {
            $entity->setDescription($dto->description);
        }
        if (null !== $dto->configuration) {
            $entity->setConfiguration($dto->configuration);
        }
        if (null !== $dto->icon) {
            $entity->setIcon($dto->icon);
        }
        if (null !== $dto->color) {
            $entity->setColor($dto->color);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->technology) {
            $entity->setTechnology($this->resolveIri($dto->technology ?? null, \App\Entity\Technology::class, 'technology', required: false));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(Framework $entity): FrameworkCreateDto
    {
               $dto = new FrameworkCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(Framework $entity, object $dto): void
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
