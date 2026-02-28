<?php

namespace App\Command\Services;

use App\Command\CmdHelpers;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;

final class GenerateProvider
{
    public const BASE_RESOURCE_NAMESPACE = 'App\\ApiResource\\Resource\\';
    public const BASE_DTO_NAMESPACE = 'App\\ApiResource\\Dto\\';
    public const BASE_STATE_NAMESPACE = 'App\\ApiResource\\State\\';
    public const BASE_SERVICE_NAMESPACE = 'App\\ApiResource\\Service';

    public function __construct(
        private CmdHelpers $helpers,
    ) {
    }

    public function collectionProvider(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $shortEntityClassCamelCase = $this->helpers->snakeToCamel($shortEntityClass); // ok
        // $baseDtoNamespace = self::BASE_DTO_NAMESPACE;
        // $collectionDtoFqcn = "{$baseDtoNamespace}{$shortEntityClass}\\{$shortEntityClass}CollectionItemDto";

        // Scalars (Doctrine fields)
        $fieldNames = $metadata->getFieldNames();

        // Associations
        $toOne = []; // [field => resourceFqcn]
        $toMany = []; // [field => resourceFqcn]
        $resourceUses = [];

        foreach ($metadata->getAssociationMappings() as $mappingRaw) {
            $m = $this->helpers->normalizeAssociationMapping($mappingRaw);

            $field = $m['fieldName'] ?? null;
            $type = $m['type'] ?? null;
            $targetFqcn = $m['targetEntity'] ?? null;

            if (! $field || ! $type || ! $targetFqcn) {
                continue;
            }

            $targetShort = $this->helpers->getShortClassName($targetFqcn);
            $targetResourceFqcn = self::BASE_RESOURCE_NAMESPACE."{$targetShort}\\{$targetShort}Resource";
            $resourceUses[$targetResourceFqcn] = "use {$targetResourceFqcn};";

            $isToMany = in_array($type, [
                OrmClassMetadata::ONE_TO_MANY,
                OrmClassMetadata::MANY_TO_MANY,
            ], true);

            $isToOne = in_array($type, [
                OrmClassMetadata::MANY_TO_ONE,
                OrmClassMetadata::ONE_TO_ONE,
            ], true);

            if ($isToOne) {
                $toOne[$field] = $targetShort.'Resource';
            } elseif ($isToMany) {
                $toMany[$field] = $targetShort.'Resource';
            }
        }

        // Scalars assignments (getter-only)
        $scalarAssignments = [];
        //         foreach ($fieldNames as $field) {
        //             $getter = 'get' . ucfirst($field);

        //             // petit cas fréquent : booléen "isXxx"
        //             $isGetter = 'is' . ucfirst($field);

        //             $scalarAssignments[] = <<<PHP
        //             \$dto->{$field} = \$entity->{$getter}();
        // PHP;
        //         }
        $scalarAssignmentsCode = $this->helpers->generateEntityToDto($metadata, $shortEntityClass, mode: 'collection');

        // ToOne assignments
        $toOneAssignments = [];
        foreach ($toOne as $field => $resourceShortClass) {
            $getter = 'get'.ucfirst($field);

            $toOneAssignments[] = <<<PHP
        // {$field} (ToOne => IRI)
        \$dto->{$field} = \$entity->{$getter}()
            ? (\$this->iriFromResource)({$resourceShortClass}::class,\$entity->{$getter}()->getId())
            : null;
PHP;
        }
        $toOneAssignmentsCode = empty($toOneAssignments) ? "        // No ToOne relations\n" : implode("\n\n", $toOneAssignments);

        // ToMany assignments
        $toManyAssignments = [];
        foreach ($toMany as $field => $resourceShortClass) {
            $getter = 'get'.ucfirst($field);

            $toManyAssignments[] = <<<PHP
        // {$field} (ToMany => array of IRIs)
        \$dto->{$field} = \$this->toIriList(\$entity->{$getter}(), {$resourceShortClass}::class);
PHP;
        }
        $toManyAssignmentsCode = empty($toManyAssignments) ? "        // No ToMany relations\n" : implode("\n\n", $toManyAssignments);

        $resourceUsesCode = implode("\n", $resourceUses);
        if ('' !== $resourceUsesCode) {
            $resourceUsesCode .= "\n";
        }

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
use ApiPlatform\\Metadata\\Operation;
use ApiPlatform\\State\\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\ApiResource\Mapper\\{$shortEntityClass}\\{$shortEntityClass}Mapper;
use Symfony\\Component\\DependencyInjection\\Attribute\\Autowire;


final readonly class {$shortEntityClass}CollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface \$collectionProvider,
        private {$shortEntityClass}Mapper \${$shortEntityClassCamelCase}Mapper
    ) {}

    public function provide(Operation \$operation, array \$uriVariables = [], array \$context = []): object|array|null
    {
        if (!(\$operation instanceof CollectionOperationInterface)) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        \$result = \$this->collectionProvider->provide(\$operation, \$uriVariables, \$context);
        if (!is_iterable(\$result)) {
            return \$result;
        }

        \$items = [];
        foreach (\$result as \$entity) {

            if (!\$entity instanceof {$shortEntityClass}) {
                continue;
            }
            \$items[] = \$this->{$shortEntityClassCamelCase}Mapper->entityToCollectionDto(\$entity);
        }
        return \$items;
    }
}
PHP;
    }

    public function itemProvider(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $shortEntityClassCamelCase = $this->helpers->snakeToCamel($shortEntityClass);
        $providerClass = $shortEntityClass.'ItemProvider';

        $itemDtoFqcn = self::BASE_DTO_NAMESPACE."{$shortEntityClass}\\{$shortEntityClass}ItemDto";

        // Scalars (Doctrine fields)
        $fieldNames = $metadata->getFieldNames();

        // Associations
        $toOne = []; // [field => resourceFqcn]
        $toMany = []; // [field => resourceFqcn]
        $resourceUses = [];

        foreach ($metadata->getAssociationMappings() as $mappingRaw) {
            $m = $this->helpers->normalizeAssociationMapping($mappingRaw);

            $field = $m['fieldName'] ?? null;
            $type = $m['type'] ?? null;
            $targetFqcn = $m['targetEntity'] ?? null;

            if (! $field || ! $type || ! $targetFqcn) {
                continue;
            }

            $targetShort = $this->helpers->getShortClassName($targetFqcn);
            $targetResourceFqcn = self::BASE_RESOURCE_NAMESPACE."{$targetShort}\\{$targetShort}Resource";
            $resourceUses[$targetResourceFqcn] = "use {$targetResourceFqcn};";

            $isToMany = in_array($type, [
                OrmClassMetadata::ONE_TO_MANY,
                OrmClassMetadata::MANY_TO_MANY,
            ], true);

            $isToOne = in_array($type, [
                OrmClassMetadata::MANY_TO_ONE,
                OrmClassMetadata::ONE_TO_ONE,
            ], true);

            if ($isToOne) {
                $toOne[$field] = $targetShort.'Resource';
            } elseif ($isToMany) {
                $toMany[$field] = $targetShort.'Resource';
            }
        }

        // Scalars assignments (getter-only)
        $scalarAssignments = [];
        foreach ($fieldNames as $field) {
            $getter = 'get'.ucfirst($field);

            // petit cas fréquent : booléen "isXxx"
            $isGetter = 'is'.ucfirst($field);

            $scalarAssignments[] = <<<PHP
            \$dto->{$field} = \$entity->{$getter}();
PHP;
        }
        $scalarAssignmentsCode = implode("\n\n", $scalarAssignments);

        // ToOne assignments
        $toOneAssignments = [];
        foreach ($toOne as $field => $resourceShortClass) {
            $getter = 'get'.ucfirst($field);

            $toOneAssignments[] = <<<PHP
        // {$field} (ToOne => IRI)
        \$dto->{$field} = \$entity->{$getter}()
            ? (\$this->iriFromResource)({$resourceShortClass}::class,\$entity->{$getter}()->getId())
            : null;
PHP;
        }
        $toOneAssignmentsCode = empty($toOneAssignments) ? "        // No ToOne relations\n" : implode("\n\n", $toOneAssignments);

        // ToMany assignments
        $toManyAssignments = [];
        foreach ($toMany as $field => $resourceShortClass) {
            $getter = 'get'.ucfirst($field);

            $toManyAssignments[] = <<<PHP
        // {$field} (ToMany => array of IRIs)
        \$dto->{$field} = \$this->toIriList(\$entity->{$getter}(), {$resourceShortClass}::class);
PHP;
        }
        $toManyAssignmentsCode = empty($toManyAssignments) ? "        // No ToMany relations\n" : implode("\n\n", $toManyAssignments);

        $resourceUsesCode = implode("\n", $resourceUses);
        if ('' !== $resourceUsesCode) {
            $resourceUsesCode .= "\n";
        }

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
use ApiPlatform\\Metadata\\Operation;
use ApiPlatform\\State\\ProviderInterface;
use App\ApiResource\Mapper\\{$shortEntityClass}\\{$shortEntityClass}Mapper;
use Symfony\\Component\\DependencyInjection\\Attribute\\Autowire;

final readonly class {$shortEntityClass}ItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface \$itemProvider,
        private {$shortEntityClass}Mapper \${$shortEntityClassCamelCase}Mapper
    ) {}
    public function provide(Operation \$operation, array \$uriVariables = [], array \$context = []): object|array|null
    {
        \$entity = \$this->itemProvider->provide(\$operation, \$uriVariables, \$context);

        if (!\$entity instanceof {$shortEntityClass}) {
            return \$entity;
        }

        return \$this->{$shortEntityClassCamelCase}Mapper->entityToItemDto(\$entity);
    }
}
PHP;
    }
}
