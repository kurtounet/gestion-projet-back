<?php

namespace App\ApiResource\Mapper\ConfigProjectFramework;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCreateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkUpdateDto;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\ApiResource\Resource\Framework\FrameworkResource;
use App\ApiResource\Resource\ProjectInstance\ProjectInstanceResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\ConfigProjectFramework;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ConfigProjectFrameworkMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(ConfigProjectFramework $entity): ConfigProjectFrameworkResource
    {
        $dto = new ConfigProjectFrameworkResource();
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->configuration = $entity->getConfiguration();
        $dto->architecture = $entity->getArchitecture();
        $dto->script = $entity->getScript();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->projectInstance = $entity->getProjectInstance()
            ? ($this->iriFromResource)(ProjectInstanceResource::class, $entity->getProjectInstance()->getId())
            : null;

        $dto->framework = $entity->getFramework()
            ? ($this->iriFromResource)(FrameworkResource::class, $entity->getFramework()->getId())
            : null;


        return $dto;
    }

    public function entityToCollectionDto(ConfigProjectFramework $entity): ConfigProjectFrameworkResource
    {
        $dto = new ConfigProjectFrameworkResource();
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->configuration = $entity->getConfiguration();
        $dto->architecture = $entity->getArchitecture();
        $dto->script = $entity->getScript();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->projectInstance = $entity->getProjectInstance()
            ? ($this->iriFromResource)(ProjectInstanceResource::class, $entity->getProjectInstance()->getId())
            : null;

        $dto->framework = $entity->getFramework()
            ? ($this->iriFromResource)(FrameworkResource::class, $entity->getFramework()->getId())
            : null;


        return $dto;
    }

    public function createDtoToEntity(ConfigProjectFrameworkCreateDto $dto): ConfigProjectFramework
    {
        $entity = new ConfigProjectFramework();
        if (null !== $dto->name) {
            $entity->setName($dto->name);
        }
        if (null !== $dto->configuration) {
            $entity->setConfiguration($dto->configuration);
        }
        if (null !== $dto->architecture) {
            $entity->setArchitecture($dto->architecture);
        }
        if (null !== $dto->script) {
            $entity->setScript($dto->script);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->projectInstance) {
            $entity->setProjectInstance($this->resolveIri($dto->projectInstance ?? null, \App\Entity\ProjectInstance::class, 'projectInstance', required: false));
        }
        if (null !== $dto->framework) {
            $entity->setFramework($this->resolveIri($dto->framework ?? null, \App\Entity\Framework::class, 'framework', required: false));
        }



        return $entity;



    }

    public function updateDtoToEntity(ConfigProjectFramework $entity, ConfigProjectFrameworkUpdateDto $dto): ConfigProjectFramework
    {
        if (null !== $dto->name) {
            $entity->setName($dto->name);
        }
        if (null !== $dto->configuration) {
            $entity->setConfiguration($dto->configuration);
        }
        if (null !== $dto->architecture) {
            $entity->setArchitecture($dto->architecture);
        }
        if (null !== $dto->script) {
            $entity->setScript($dto->script);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->projectInstance) {
            $entity->setProjectInstance($this->resolveIri($dto->projectInstance ?? null, \App\Entity\ProjectInstance::class, 'projectInstance', required: false));
        }
        if (null !== $dto->framework) {
            $entity->setFramework($this->resolveIri($dto->framework ?? null, \App\Entity\Framework::class, 'framework', required: false));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(ConfigProjectFramework $entity): ConfigProjectFrameworkCreateDto
    {
               $dto = new ConfigProjectFrameworkCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(ConfigProjectFramework $entity, object $dto): void
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
