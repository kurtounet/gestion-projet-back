<?php

namespace App\ApiResource\Mapper\TypeTask;
use App\Entity\TypeTask;
use App\ApiResource\Dto\TypeTask\TypeTaskItemDto;
use App\ApiResource\Dto\TypeTask\TypeTaskCreateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskUpdateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskCollectionItemDto;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\IriConverterInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TypeTaskMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {}


    public function entityToItemDto(TypeTask $entity): TypeTaskItemDto
    {
               $dto = new TypeTaskItemDto();
                     $dto->id = $entity->getId();
             $dto->name = $entity->getName();
             $dto->color = $entity->getColor();
             $dto->pathFileScript = $entity->getPathFileScript();
             $dto->description = $entity->getDescription();
             $dto->automatique = $entity->getAutomatique();
             $dto->createdAt = $entity->getCreatedAt();
             $dto->updatedAt = $entity->getUpdatedAt();
        /*
        
        $dto->codebase = $entity->getCodebase()
            ? ($this->iriFromResource)(CodeBase::class,$entity->getCodebase()->getId())
            : null;

        
        */
        return $dto;
    }

    public function entityToCollectionDto(TypeTask $entity): TypeTaskCollectionItemDto
    {
                $dto = new TypeTaskCollectionItemDto();
                    $dto->id = $entity->getId();
             $dto->name = $entity->getName();
             $dto->color = $entity->getColor();
             $dto->pathFileScript = $entity->getPathFileScript();
             $dto->description = $entity->getDescription();
             $dto->automatique = $entity->getAutomatique();
             $dto->createdAt = $entity->getCreatedAt();
             $dto->updatedAt = $entity->getUpdatedAt();
       /*
       
        $dto->codebase = $entity->getCodebase()
            ? ($this->iriFromResource)(CodeBase::class,$entity->getCodebase()->getId())
            : null;

       
       */
       return $dto;


    }
    public function createDtoToEntity(TypeTaskCreateDto $dto): TypeTask
    {
               $entity = new TypeTask();
                   $entity->setName($dto->name);
            $entity->setColor($dto->color);
            $entity->setPathFileScript($dto->pathFileScript);
            $entity->setDescription($dto->description);
            $entity->setAutomatique($dto->automatique);
            $entity->setCreatedAt($dto->createdAt);
            $entity->setUpdatedAt($dto->updatedAt);
       /*
                   $entity->setCode($dto->code);

       
        $entity->setCodeBase($this->resolveIri($dto->codebase ?? null, CodeBase::class, 'codebase', required: true));
       */

       return $entity;



    }
    public function updateDtoToEntity(TypeTask $entity, TypeTaskUpdateDto $dto): TypeTask
    {
               $entity = new TypeTask();
                   $entity->setName($dto->name);
            $entity->setColor($dto->color);
            $entity->setPathFileScript($dto->pathFileScript);
            $entity->setDescription($dto->description);
            $entity->setAutomatique($dto->automatique);
            $entity->setCreatedAt($dto->createdAt);
            $entity->setUpdatedAt($dto->updatedAt);
       /*
                   $entity->setCode($dto->code);

       
       */
       return $entity;
    }
    /*
    public function mapEntityToCreateDto(TypeTask $entity): TypeTaskCreateDto
    {
               $dto = new TypeTaskCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(TypeTask $entity, object $dto): void
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
        if ($iri === null || $iri === '') {
            if ($required) {
                throw new BadRequestHttpException(sprintf(
                    'Field "%s" is required and must be a non-empty IRI string.',
                    $field
                ));
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
        if ($id === null && preg_match('~/(\d+)$~', $iri, $m)) {
            $id = (int) $m[1];
        }

        if ($id === null) {
            throw new BadRequestHttpException(sprintf(
                'Invalid IRI type for field "%s". Expected "%s".',
                $field,
                $expectedClass
            ));
        }

        $entity = $this->em->getRepository($expectedClass)->find($id);

        if (!$entity) {
            throw new BadRequestHttpException(sprintf(
                'Resource not found for field "%s" (id: %s).',
                $field,
                (string) $id
            ));
        }

        return $entity;
    }


}
