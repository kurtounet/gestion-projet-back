<?php

namespace App\Command\Services;

use App\Command\CmdHelpers;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;

final class GenerateMapper
{
    public function __construct(
        private CmdHelpers $helpers,
    ) {
    }

    public function entityToItemDto($metadata, $shortEntityClass): string
    {
        [
            $resourceUsesCode,
            $entityToDtoScalar,
            $entityToDtoToOne,
            $entityToDtoToMany,
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            $typeP = 'Processor',
            $typeR = '',
            $dto = 'Resource',
            mode: 'item'
        );

        return <<<PHP
        \$dto = new {$shortEntityClass}Resource();
        {$entityToDtoScalar}
        {$entityToDtoToOne}

        {$entityToDtoToMany}
        return \$dto;
PHP;
    }

    public function entityToCollectionDto($metadata, $shortEntityClass): string
    {
        [
            $resourceUsesCode,
            $entityToDtoScalar,
            $entityToDtoToOne,
            $entityToDtoToMany,
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            $typeP = 'Processor',
            $typeR = '',
            $dto = 'Resource',
            mode: 'collection'
        );

        return <<<PHP
        \$dto = new {$shortEntityClass}Resource();
        {$entityToDtoScalar}
        {$entityToDtoToOne}

        {$entityToDtoToMany}
        return \$dto;
 PHP;
    }

    public function updateDtoToEntity($metadata, $shortEntityClass): string
    {
        $mode = 'update';
        $shortEntityClassCamelCase = $this->helpers->snakeToCamel($shortEntityClass);
        $updateDtoFqcn = $this->helpers->getNamespace('Dto')."{$shortEntityClass}\\{$shortEntityClass}UpdateDto";
        [
            $resourceUsesCode,
            $dataToEntityScalar,
            $dataToEntityToOne,
            $dataToEntityToMany,
            // $entityToDtoScalar,
            // $entityToDtoToOne,
            // $entityToDtoToMany
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            $typeP = 'Processor',
            $typeR = '',
            $dto = 'UpdateDto',
            mode: 'update'
        );

        return <<<PHP
        {$dataToEntityScalar}
        {$dataToEntityToOne}

        {$dataToEntityToMany}
        return \$entity;
 PHP;
    }

    public function createDtoToEntity($metadata, $shortEntityClass): string
    {
        $createDtoFqcn = $this->helpers->getNamespace('Dto')."{$shortEntityClass}\\{$shortEntityClass}CreateDto";
        $itemDtoFqcn = $this->helpers->getNamespace('Dto')."{$shortEntityClass}\\{$shortEntityClass}ItemDto";
        $mode = 'create';

        [
            $resourceUsesCode,
            $dataToEntityScalar,
            $dataToEntityToOne,
            $dataToEntityToMany,
            $entityToDtoScalar,
            $entityToDtoToOne,
            $entityToDtoToMany,
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            $typeP = 'Processor',
            $typeR = '',
            $dto = 'CreateDto',
            mode: 'create'
        );

        return <<<PHP
        \$entity = new {$shortEntityClass}();
        {$dataToEntityScalar}
        {$dataToEntityToOne}

        {$dataToEntityToMany}

        return \$entity;



 PHP;
    }

    public function mapEntityToCreateDto($shortEntityClass): string
    {
        return <<<PHP
        \$dto = new {$shortEntityClass}CreateDto();

        return \$dto;
 PHP;
    }

    private function commonFieldsEntityToDto(): string
    {
        return <<<'PHP'
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
PHP;
    }

    private function toIriList(): string
    {
        return <<<'PHP'
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
PHP;
    }

    private function resolveIri(): string
    {
        return
            <<<'PHP'
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

PHP;
    }

    public function createMapper(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $resourceUses = [];

        // Appels pour agréger les resourceUses
        [
            $resourceUsesCode1,
            $entityToDtoScalar,
            $entityToDtoToOne,
            $entityToDtoToMany,
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            'Processor',
            '',
            'Resource',
            'item'
        );

        [
            $resourceUsesCode2,
            $dataToEntityScalar,
            $dataToEntityToOne,
            $dataToEntityToMany,
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            'Processor',
            '',
            'UpdateDto',
            'update'
        );

        [
            $resourceUsesCode3,
            $dataToEntityScalarCreate,
            $dataToEntityToOneCreate,
            $dataToEntityToManyCreate,
        ] = $this->helpers->generatePropertyAssignmentsCode(
            $metadata,
            $shortEntityClass,
            $this->helpers->getNamespace('Dto'),
            $this->helpers->getNamespace('Entity'),
            'Processor',
            '',
            'CreateDto',
            'create'
        );

        // Combinaison des imports uniques
        $allUses = array_merge(explode("\n", trim($resourceUsesCode1)), explode("\n", trim($resourceUsesCode2)), explode("\n", trim($resourceUsesCode3)));
        $uniqueUses = array_unique(array_filter($allUses));
        $resourceUsesFinalCode = implode("\n", $uniqueUses);

        return <<<PHP
    <?php

    namespace App\ApiResource\Mapper\\{$shortEntityClass};
    use App\Entity\\{$shortEntityClass};
    use App\ApiResource\Dto\\{$shortEntityClass}\\{$shortEntityClass}CreateDto;
    use App\ApiResource\Dto\\{$shortEntityClass}\\{$shortEntityClass}UpdateDto;
    use App\ApiResource\Resource\\{$shortEntityClass}\\{$shortEntityClass}Resource;

    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\SecurityBundle\Security;
    use App\ApiResource\Service\IriFromResource;
    use ApiPlatform\Metadata\IriConverterInterface;
    use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
    {$resourceUsesFinalCode}

    class {$shortEntityClass}Mapper
    {
    public function __construct(
        private Security \$security,
        private EntityManagerInterface \$em,
        private IriFromResource \$iriFromResource,
        private IriConverterInterface \$iriConverter,
    ) {}

    public function entityToItemDto({$shortEntityClass} \$entity): {$shortEntityClass}Resource
    {
       {$this->entityToItemDto($metadata, $shortEntityClass)}
    }
    public function entityToCollectionDto({$shortEntityClass} \$entity): {$shortEntityClass}Resource
    {
         {$this->entityToCollectionDto($metadata, $shortEntityClass)}
    }
    public function createDtoToEntity({$shortEntityClass}CreateDto \$dto): {$shortEntityClass}
    {
        {$this->createDtoToEntity($metadata, $shortEntityClass)}
    }
    public function updateDtoToEntity({$shortEntityClass} \$entity, {$shortEntityClass}UpdateDto \$dto): {$shortEntityClass}
    {
        {$this->updateDtoToEntity($metadata, $shortEntityClass)}
    }
    /*
    public function mapEntityToCreateDto({$shortEntityClass} \$entity): {$shortEntityClass}CreateDto
    {
        {$this->mapEntityToCreateDto($shortEntityClass)}
    }
    */
    private function commonFieldsEntityToDto({$shortEntityClass} \$entity, object \$dto): void
    {
        {$this->commonFieldsEntityToDto()}
    }

    {$this->toIriList()}

    {$this->resolveIri()}

    }

    PHP;
    }

    public function extractIdFromIri(): string
    {
        return <<<'PHP'
    /**
     * Extrait l'ID depuis un IRI sans faire de requête SQL
     */
    private function extractIdFromIri(string $iri): int
    {
        $parts = explode('/', trim($iri, '/'));
        $id = end($parts);
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException(
                sprintf('ID invalide extrait de l\'IRI "%s"', \iri)
            );
        }
        return (int) $id;
    }
PHP;
    }
}
