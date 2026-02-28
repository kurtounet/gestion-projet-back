<?php

namespace App\Command\Services;

use App\Command\CmdHelpers;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;

final class GenerateDto
{
    public const BASE_RESOURCE_NAMESPACE = 'App\\ApiResource\\Resource\\';
    public const BASE_DTO_NAMESPACE = 'App\\ApiResource\\Dto\\';
    public const BASE_STATE_NAMESPACE = 'App\\ApiResource\\State\\';
    public const BASE_SERVICE_NAMESPACE = 'App\\ApiResource\\Service';

    // -----------------------------
    // Génération des fichiers DTO / Resource
    // -----------------------------
    public function __construct(
        private readonly CmdHelpers $helpers,
    ) {
    }

    public function resource(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $shortEntityClassPlural = $this->helpers->pluralizeEn($shortEntityClass);
        $uriTemplate = $this->helpers->pascalCaseToLowerSnakeCase($shortEntityClassPlural);
        $baseDtoNamespace = self::BASE_DTO_NAMESPACE;
        $propertiesCode = $this->helpers->generateDtoPropertiesFromMetadata($metadata, $shortEntityClass, mode: 'resource');
        [$namespaces, $propertiesRelationship] = $this->helpers->generateDtoPropertiesRelationshipFromMetadata($metadata, $shortEntityClass, mode: 'resource');

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};

{$namespaces}
use ApiPlatform\\Metadata\\Get;
use ApiPlatform\\Metadata\\Post;
use ApiPlatform\\Metadata\\Patch;
use ApiPlatform\\Metadata\\Delete;
use ApiPlatform\\Metadata\\ApiResource;
use ApiPlatform\\Metadata\\GetCollection;
use ApiPlatform\\Doctrine\\Orm\\State\\Options;

use {$baseDtoNamespace}{$shortEntityClass}\\{$shortEntityClass}CreateDto;
use {$baseDtoNamespace}{$shortEntityClass}\\{$shortEntityClass}UpdateDto; 

use App\\ApiResource\\State\\{$shortEntityClass}\\{$shortEntityClass}CollectionProvider;
use App\\ApiResource\\State\\{$shortEntityClass}\\{$shortEntityClass}ItemProvider;
use App\\ApiResource\\State\\{$shortEntityClass}\\{$shortEntityClass}CreateProcessor;
use App\\ApiResource\\State\\{$shortEntityClass}\\{$shortEntityClass}UpdateProcessor;
use App\\ApiResource\\State\\{$shortEntityClass}\\{$shortEntityClass}DeleteProcessor;

 
use Symfony\\Component\\Serializer\\Attribute\\Groups;
use Symfony\\Component\\Validator\\Constraints as Assert;

#[ApiResource(
    shortName: '{$shortEntityClass}',
    stateOptions: new Options(entityClass: {$shortEntityClass}::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: {$shortEntityClass}CollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: {$shortEntityClass}ItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: {$shortEntityClass}CreateProcessor::class,
            input: {$shortEntityClass}CreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: {$shortEntityClass}UpdateProcessor::class,
            input: {$shortEntityClass}UpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: {$shortEntityClass}DeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
 
final class {$shortEntityClass}Resource
{
    #[ApiProperty(identifier: true)]
    {$propertiesCode}

    {$propertiesRelationship}

}

PHP;
    }

    public function create(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $scalarProperties = $this->helpers->generateDtoPropertiesFromMetadata($metadata, $shortEntityClass, mode: 'create');
        $relationsInput = $this->helpers->generateDtoPropertiesInputRelationshipsFromMetadata($metadata, $shortEntityClass, mode: 'create');
        $relationsBlock = '' !== $relationsInput ? ("\n\n".$relationsInput) : '';

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
use Symfony\\Component\\ObjectMapper\\Attribute\\Map;
use Symfony\\Component\\Serializer\\Attribute\\Groups;
use Symfony\\Component\\Validator\\Constraints as Assert;

/**
 * DTO de création pour {$shortEntityClass}.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
 
final class {$shortEntityClass}CreateDto
{
{$scalarProperties}

{$relationsBlock}
}

PHP;
    }

    public function update(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $propertiesCode = $this->helpers->generateDtoPropertiesFromMetadata($metadata, $shortEntityClass, mode: 'update');
        $relationsInput = $this->helpers->generateDtoPropertiesInputRelationshipsFromMetadata($metadata, $shortEntityClass, mode: 'update');

        $relationsBlock = '' !== $relationsInput ? ("\n\n".$relationsInput) : '';

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
use Symfony\\Component\\ObjectMapper\\Attribute\\Map;
use Symfony\\Component\\Serializer\\Attribute\\Groups;
use Symfony\\Component\\Validator\\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour {$shortEntityClass}.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
 
final class {$shortEntityClass}UpdateDto
{
{$propertiesCode}{$relationsBlock}
}

PHP;
    }

    public function collection(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $propertiesCode = $this->helpers->generateDtoPropertiesFromMetadata($metadata, $shortEntityClass, mode: 'collection');

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
use Symfony\\Component\\ObjectMapper\\Attribute\\Map;
use Symfony\\Component\\Serializer\\Attribute\\Groups;

 
final class {$shortEntityClass}CollectionItemDto
{
{$propertiesCode}
}

PHP;
    }

    public function item(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $propertiesCode = $this->helpers->generateDtoPropertiesFromMetadata($metadata, $shortEntityClass, mode: 'item');
        [$namespaces, $propertiesRelationship] = $this->helpers->generateDtoPropertiesRelationshipFromMetadata($metadata, $shortEntityClass, mode: 'item');

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
{$namespaces}
use Symfony\\Component\\ObjectMapper\\Attribute\\Map;
use Symfony\\Component\\Serializer\\Attribute\\Groups;

 
final class {$shortEntityClass}ItemDto
{
{$propertiesCode}

{$propertiesRelationship}
}

PHP;
    }

    public function relation(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $propertiesCode = $this->helpers->generateDtoPropertiesFromMetadata($metadata, $shortEntityClass, mode: 'relation');

        return <<<PHP
<?php

namespace {$namespace};

use {$entityFqcn};
use Symfony\\Component\\ObjectMapper\\Attribute\\Map;
use Symfony\\Component\\Serializer\\Attribute\\Groups;

#[Map(source: {$shortEntityClass}::class)]
final class {$shortEntityClass}RelationDto
{
{$propertiesCode}
}

PHP;
    }
}
