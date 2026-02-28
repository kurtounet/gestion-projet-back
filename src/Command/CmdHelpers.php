<?php

namespace App\Command;

use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;

// -----------------------------
// DTO properties depuis Doctrine
// -----------------------------
final class CmdHelpers
{
    public const NAMESPACES = [
        'Dto' => 'App\\ApiResource\\Dto\\',
        'State' => 'App\\ApiResource\\State\\',
        'Mapper' => 'App\\ApiResource\\Mapper\\',
        'Entity' => 'App\\Entity\\',
        'Service' => 'App\\ApiResource\\Service',
        'Resource' => 'App\\ApiResource\\Resource\\',
    ];

    public function getNamespace(string $type)
    {
        return self::NAMESPACES[$type] ?? null;
    }

    /**
     * snake_case_example -> snakeCaseExample.
     */
    public static function snakeToCamel(string $str): string
    {
        return lcfirst(static::snakeToPascal($str));
    }

    /**
     * snake_case_example -> SnakeCaseExample.
     */
    public static function snakeToPascal(string $str): string
    {
        return str_replace('_', '', ucwords($str, '_'));
    }

    /**
     * camelCaseExample -> camel_case_example.
     */
    public static function camelToSnake(string $str): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
    }

    /**
     * camelCaseExample -> camel-case-example.
     */
    public static function camelToKebab(string $str): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $str));
    }

    /**
     * kebab-case-example -> camelCaseExample.
     */
    public static function kebabToCamel(string $str): string
    {
        return lcfirst(static::kebabToPascal($str));
    }

    /**
     * kebab-case-example -> KebabCaseExample.
     */
    public static function kebabToPascal(string $str): string
    {
        return str_replace('-', '', ucwords($str, '-'));
    }

    /**
     * PascalCaseExample -> snake_case_example.
     */
    public static function pascalToSnake(string $str): string
    {
        return static::camelToSnake($str);
    }

    /**
     * PascalCaseExample -> kebab-case-example.
     */
    public static function pascalToKebab(string $str): string
    {
        return static::camelToKebab($str);
    }

    /**
     * snake_case_example -> kebab-case-example.
     */
    public static function snakeToKebab(string $str): string
    {
        return str_replace('_', '-', $str);
    }

    /**
     * PascalCaseExample -> pascalCaseExample.
     */
    public static function pascalToCamel(string $str): string
    {
        return lcfirst($str);
    }

    /**
     * camelCaseExample -> CamelCaseExample.
     */
    public static function camelToPascal(string $str): string
    {
        return ucfirst($str);
    }

    /**
     * Met la première lettre en majuscule.
     */
    public static function capitalize(string $str): string
    {
        return ucfirst($str);
    }

    /**
     * Transforme une chaîne en slug URL-friendly.
     */
    public static function slugify(string $str): string
    {
        // Remplace les caractères non alphanumériques par des tirets
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        // Translittération (ex: é -> e)
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        // Retire tout ce qui n'est pas un mot ou un tiret
        $str = preg_replace('~[^-\w]+~', '', $str);

        // Trim et minuscules
        return strtolower(trim($str, '-'));
    }

    /**
     * Pluralize an English noun.
     *
     * Notes:
     * - Not perfect for every English word (English is full of exceptions),
     *   but covers most practical cases.
     */
    public function pluralizeEn(string $word, int $count = 2): string
    {
        if (1 === $count || '' === $word) {
            return $word;
        }

        $lower = strtolower($word);

        // 1) Uncountable nouns (same in singular/plural)
        $uncountables = [
            'sheep',
            'fish',
            'deer',
            'series',
            'species',
            'aircraft',
            'information',
            'equipment',
            'rice',
            'money',
            'baggage',
            'furniture',
            'advice',
            'news',
            'bread',
            'milk',
        ];
        if (in_array($lower, $uncountables, true)) {
            return $word;
        }

        // 2) Irregular plurals
        $irregular = [
            'man' => 'men',
            'woman' => 'women',
            'child' => 'children',
            'person' => 'people',
            'tooth' => 'teeth',
            'foot' => 'feet',
            'mouse' => 'mice',
            'goose' => 'geese',
            'ox' => 'oxen',
            'louse' => 'lice',
            'cactus' => 'cacti',
            'focus' => 'foci',
            'fungus' => 'fungi',
            'nucleus' => 'nuclei',
            'syllabus' => 'syllabi',
            'analysis' => 'analyses',
            'diagnosis' => 'diagnoses',
            'thesis' => 'theses',
            'crisis' => 'crises',
            'phenomenon' => 'phenomena',
            'criterion' => 'criteria',
        ];
        if (isset($irregular[$lower])) {
            return $this->preserveCaseEn($word, $irregular[$lower]);
        }

        // If it's already plural-ish (basic heuristic)
        if (preg_match('/(s|x|z|ch|sh)$/i', $word)) {
            // But: "bus" -> "buses" (handled below anyway). We'll keep processing.
        }

        // 3) Rules
        // Ends with s, x, z, ch, sh => add "es"
        if (preg_match('/(s|x|z|ch|sh)$/i', $word)) {
            return $word.'es';
        }

        // Ends with consonant + y => replace y with ies
        if (preg_match('/[^aeiou]y$/i', $word)) {
            return preg_replace('/y$/i', 'ies', $word);
        }

        // Ends with vowel + y => add s (toy -> toys)
        if (preg_match('/[aeiou]y$/i', $word)) {
            return $word.'s';
        }

        // Ends with f or fe => ves (wolf->wolves, knife->knives)
        // Exceptions: roof->roofs, chef->chefs, belief->beliefs...
        $fExceptions = ['roof', 'chef', 'chief', 'belief', 'cliff', 'handkerchief'];
        if (preg_match('/(f|fe)$/i', $word) && ! in_array($lower, $fExceptions, true)) {
            if (preg_match('/fe$/i', $word)) {
                return preg_replace('/fe$/i', 'ves', $word);
            }

            return preg_replace('/f$/i', 'ves', $word);
        }

        // Ends with consonant + o => often "es" (hero->heroes)
        // Exceptions: photo->photos, piano->pianos...
        $oExceptions = ['photo', 'piano', 'halo', 'memo', 'kilo', 'video'];
        if (preg_match('/[^aeiou]o$/i', $word) && ! in_array($lower, $oExceptions, true)) {
            return $word.'es';
        }

        // Default: add "s"
        return $word.'s';
    }

    /**
     * Preserve case style for irregulars:
     * MAN -> MEN, Man -> Men
     */
    public function preserveCaseEn(string $original, string $replacement): string
    {
        if (strtoupper($original) === $original) {
            return strtoupper($replacement);
        }

        if (ctype_upper(substr($original, 0, 1))) {
            return ucfirst($replacement);
        }

        return $replacement;
    }

    public function pascalCaseToUpperSnakeCase(string $value): string
    {
        return strtoupper((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }

    public function pascalCaseToLowerSnakeCase(string $value): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }

    public function getShortClassName(string $fqcn): string
    {
        $pos = strrpos($fqcn, '\\');

        return false === $pos ? $fqcn : substr($fqcn, $pos + 1);
    }

    public function mapDoctrineTypeToPhpType(?string $doctrineType): ?string
    {
        return match ($doctrineType) {
            'integer', 'smallint', 'bigint' => 'int',
            'boolean' => 'bool',
            'float', 'decimal' => 'float',
            'string', 'text' => 'string',
            'datetime', 'datetimetz', 'datetime_immutable',
            'date', 'date_immutable' => '\\DateTimeInterface',
            'json', 'json_array', 'array', 'simple_array' => 'array',
            default => null,
        };
    }

    /**
     * Doctrine ORM 2 => associations sous forme de tableau
     * Doctrine ORM 3 => associations sous forme d'objets (ManyToOneAssociationMapping, etc.).
     *
     * Cette méthode normalise en array pour un usage homogène.
     */
    public function normalizeAssociationMapping(mixed $mapping): array
    {
        if (is_array($mapping)) {
            return $mapping;
        }

        if (! is_object($mapping)) {
            return [];
        }

        // Doctrine ORM 3: certains objets ont une méthode toArray()
        if (method_exists($mapping, 'toArray')) {
            $arr = $mapping->toArray();

            return is_array($arr) ? $arr : [];
        }

        // Fallback: tente get_object_vars (propriétés publiques)
        $vars = get_object_vars($mapping);
        if (! empty($vars)) {
            return $vars;
        }

        /**
         * Fallback "hard" : cast (array) (récupère aussi des props protégées/privées avec des clés bizarres),
         * puis on nettoie les clés.
         */
        $casted = (array) $mapping;
        $clean = [];
        foreach ($casted as $k => $v) {
            // Nettoie les clés type "\0Class\0property"
            if (is_string($k) && str_contains($k, "\0")) {
                $k = substr($k, strrpos($k, "\0") + 1);
            }
            $clean[$k] = $v;
        }

        return $clean;
    }

    /*************************************************************************
     * DTO
     ************************************************************************/
    public function generateDtoPropertiesFromMetadata(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode = 'resource',
    ): string {
        $lines = [];
        $identifierFields = $metadata->getIdentifierFieldNames();

        foreach ($metadata->getFieldNames() as $fieldName) {
            // Ignorer l'ID en create/update
            if (in_array($fieldName, $identifierFields, true) && ! in_array($mode, ['item', 'collection', 'resource', 'relation'], true)) {
                continue;
            }

            // RelationDto ne garde que l'identifiant
            if (! in_array($fieldName, $identifierFields, true) && 'relation' === $mode) {
                continue;
            }

            $mapping = $metadata->getFieldMapping($fieldName);
            $doctrineType = $mapping['type'] ?? null;
            $nullable = $mapping['nullable'] ?? false;

            $phpBaseType = $this->mapDoctrineTypeToPhpType($doctrineType) ?? 'mixed';

            $groupsSuffix = match ($mode) {
                'create' => 'create',
                'update' => 'update',
                'resource' => 'read',
                'item' => 'item:read',
                'collection' => 'collection:read',
                'relation' => 'relation:read',
                default => 'read',
            };

            $propertyType = $phpBaseType;
            $default = '';

            if ('update' === $mode) {
                $propertyType = '?'.$phpBaseType;
                $default = ' = null';
            } elseif ($nullable) {
                $propertyType = '?'.$phpBaseType;
                $default = ' = null';
            }

            $lines[] = $this->generatePropertyBlock(
                $fieldName,
                $propertyType,
                $shortEntityClass,
                $groupsSuffix,
                $mode,
                $nullable,
                $default
            );
        }

        return rtrim(implode("\n\n", $lines));
    }

    /**
     * Génère les relations pour les DTO de lecture (Resource/Item/Collection).
     * - ToOne : ?TargetRelationDto (id-only) pour éviter les graphes profonds
     * - ToMany : array<...> (simple).
     */
    public function generateDtoPropertiesRelationshipFromMetadata(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode = 'resource',
    ): array {
        $useStatements = [];
        $properties = [];

        $groupsSuffix = match ($mode) {
            'resource' => 'read',
            'item' => 'item:read',
            'collection' => 'collection:read',
            default => 'read',
        };

        foreach ($metadata->getAssociationMappings() as $mappingRaw) {
            $mapping = $this->normalizeAssociationMapping($mappingRaw);

            $targetFqcn = $mapping['targetEntity'];
            $field = $mapping['fieldName'];
            $assocType = $mapping['type'];

            if (! $targetFqcn || ! $field || ! $assocType) {
                continue;
            }

            $targetShort = $this->getShortClassName($targetFqcn);

            $isToMany = in_array($assocType, [
                OrmClassMetadata::ONE_TO_MANY,
                OrmClassMetadata::MANY_TO_MANY,
            ], true);

            $isToOne = in_array($assocType, [
                OrmClassMetadata::MANY_TO_ONE,
                OrmClassMetadata::ONE_TO_ONE,
            ], true);

            if ($isToOne) {
                $type = '?string'; // . $targetShort;
                $default = ' = null';
            } elseif ($isToMany) {
                // lecture simple : tableau
                $type = 'iterable';
                $default = ' = []';
            } else {
                $type = 'mixed';
                $default = '';
            }

            // Groups
            $groups = ('resource' === $mode)
                ? sprintf("['collection:%s', 'item:%s']", $groupsSuffix, $groupsSuffix)
                : sprintf("['%s']", $groupsSuffix);

            $properties[] = <<<PHP
    #[Groups({$groups})]
    public {$type} \${$field}{$default};
PHP;
        }

        // $namespaces = implode("\n", $useStatements) . (empty($useStatements) ? '' : "\n");
        $props = implode("\n\n", $properties).(empty($properties) ? '' : "\n");

        return ['' /* $namespaces */, $props];
    }

    /**
     * Relations en input (Create/Update) : ToOne = IRI string.
     * Exemple: "status": "/api/statuses/1".
     */
    public function generateDtoPropertiesInputRelationshipsFromMetadata(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode = 'create',
    ): string {
        $lines = [];

        $groupsSuffix = match ($mode) {
            'create' => 'create',
            'update' => 'update',
            default => 'create',
        };

        foreach ($metadata->getAssociationMappings() as $mappingRaw) {
            $mapping = $this->normalizeAssociationMapping($mappingRaw);
            $field = $mapping['fieldName'];
            $assocType = $mapping['type'];

            $isToOne = in_array($assocType, [
                OrmClassMetadata::MANY_TO_ONE,
                OrmClassMetadata::ONE_TO_ONE,
            ], true);

            $isToMany = in_array($assocType, [
                OrmClassMetadata::ONE_TO_MANY,
                OrmClassMetadata::MANY_TO_MANY,
            ], true);

            if ($isToOne) {
                // IRI string (nullable)
                $lines[] = $this->generatePropertyBlock(
                    $field,
                    '?string',
                    $shortEntityClass,
                    $groupsSuffix,
                    $mode,
                    true,
                    ' = null'
                );
            } elseif ($isToMany) {
                // Array of IRIs (nullable or empty array)
                $lines[] = $this->generatePropertyBlock(
                    $field,
                    'iterable',
                    $shortEntityClass,
                    $groupsSuffix,
                    $mode,
                    true,
                    ' = []'
                );
            }
        }

        return rtrim(implode("\n", $lines));
    }

    public function generatePropertyBlock(
        string $fieldName,
        string $propertyType,
        string $shortEntityClass,
        string $groupsSuffix,
        string $mode,
        bool $nullable,
        string $default = '',
    ): string {
        if ('resource' === $mode) {
            $groups = sprintf("['collection:%s', 'item:%s']", $groupsSuffix, $groupsSuffix);
        } else {
            $groups = sprintf("['%s']", $groupsSuffix);
        }

        $annotations = [];
        if ('create' === $mode && ! $nullable) {
            $annotations[] = '    #[Assert\NotBlank]';
        }

        $annotations[] = sprintf('    #[Groups(%s)]', $groups);

        $annotationsCode = implode("\n", $annotations);

        return <<<PHP
{$annotationsCode}
    public {$propertyType} \${$fieldName}{$default};
PHP;
    }

    /**
     * Scalar data to entity.
     */
    public function scalarDataToEntity(
        array $fieldNames,
        string $mode,
        string $typeD,
    ): string {
        $scalarDtoToEntityAssignments = [];
        foreach ($fieldNames as $field) {
            if (('create' === $mode || 'update' === $mode) && 'id' === $field) {
                continue;
            }
            $setter = 'set'.ucfirst($field);
            // petit cas fréquent : booléen "isXxx"
            $isGetter = 'is'.ucfirst($field);
            $scalarDtoToEntityAssignments[] = <<<PHP
            if (null !== \${$typeD}->{$field}) {
                \$entity->{$setter}(\${$typeD}->{$field});
            }
PHP;
        }

        return rtrim(implode("\n", $scalarDtoToEntityAssignments));
    }

    /**
     * Scalar entity to Dto.
     */
    public function scalarEntityToDto(
        array $fieldNames,
        string $mode,
    ): string {
        $scalarEntityToDtoAssignments = [];
        foreach ($fieldNames as $field) {
            $getter = 'get'.static::snakeToPascal($field);
            // petit cas fréquent : booleen "isXxx"
            $isGetter = 'is'.static::snakeToPascal($field);

            $scalarEntityToDtoAssignments[] = <<<PHP
             \$dto->{$field} = \$entity->{$getter}();
    PHP;
        }

        return rtrim(implode("\n", $scalarEntityToDtoAssignments));
    }

    /**
     * ToOne data to entity.
     */
    public function toOneDataToEntity(
        array $fieldNames,
        string $typeD,
    ): string {
        $scalarDtoToEntityAssignments = [];
        foreach ($fieldNames as $field => $data) {
            $setter = 'set'.static::snakeToPascal($field);
            $targetEntityFqcn = $data['entityFqcn'];
            $nullable = $data['nullable'] ? 'false' : 'true';
            $scalarDtoToEntityAssignments[] = <<<PHP
            if (null !== \${$typeD}->{$field}) {
                \$entity->{$setter}(\$this->resolveIri(\${$typeD}->{$field} ?? null, \\{$targetEntityFqcn}::class, '{$field}', required: {$nullable}));
            }
PHP;
        }

        return rtrim(implode("\n", $scalarDtoToEntityAssignments));
    }

    /**
     * ToOne entity to Dto.
     */
    public function toOneEntityToDto(
        array $toOne,
    ): string {
        $toOneAssignments = [];
        foreach ($toOne as $field => $data) {
            $resourceShortClass = $data['targetFqcn'];
            $nullable = $data['nullable'] ? true : false;
            $getter = 'get'.static::snakeToPascal($field);

            $toOneAssignments[] = <<<PHP

        \$dto->{$field} = \$entity->{$getter}()
            ? (\$this->iriFromResource)({$resourceShortClass}::class,\$entity->{$getter}()->getId())
            : null;
PHP;
        }

        return rtrim(implode("\n", $toOneAssignments));
    }

    /**
     * ToMany data to entity.
     */
    public function toManyDataToEntity(
        array $toMany,
    ): string {
        $toManyAssignments = [];

        foreach ($toMany as $field => $data) {
            $resourceShortClass = $data['targetFqcn'];
            $targetEntityFqcn = $data['entityFqcn'];
            $nullable = $data['nullable'] ? 'false' : 'true';
            $setter = 'set'.static::snakeToPascal($field);
            $toManyAssignments[] = <<<PHP
        if (null !== \$dto->{$field}) {
            \$entity->{$setter}(\$this->resolveIri(\$dto->{$field} ?? null, \\{$targetEntityFqcn}::class, '{$field}', required: {$nullable}));
        }
PHP;
        }

        return rtrim(implode("\n", $toManyAssignments));
    }

    /**
     * ToMany  entity to dto.
     */
    public function toManyEntityToDto(
        array $toMany,
    ): string {
        $toManyAssignments = [];
        foreach ($toMany as $field => $data) {
            $resourceShortClass = $data['targetFqcn'];
            $getter = 'get'.static::snakeToPascal($field);

            $toManyAssignments[] = <<<PHP

        \$dto->{$field} = \$this->toIriList(\$entity->{$getter}(), {$resourceShortClass}::class);
    PHP;
        }

        return rtrim(implode("\n", $toManyAssignments));
    }

    public function generateDataToEntity(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode,
        string $typeD,
    ): string {
        $lines = [];
        $identifierFields = $metadata->getIdentifierFieldNames();

        foreach ($metadata->getFieldNames() as $fieldName) {
            $lines = [];
            $identifierFields = $metadata->getIdentifierFieldNames();
            foreach ($metadata->getFieldNames() as $fieldName) {
                if (in_array($fieldName, $identifierFields, true) && 'create' === $mode || 'update' === $mode) {
                    continue;
                }
                $lines[] = '        $entity->set'.ucfirst($fieldName).'($'.$typeD.'->'.$fieldName.');';
            }

            return rtrim(implode("\n", $lines));
        }

        return rtrim(implode("\n", $lines));
    }

    /**
     * Génère le code d'assignement de résolution des ToOne.
     */
    public function generateDataToEntityToOne(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode,
        string $typeD,
    ): string {
        $lines = [];
        $identifierFields = $metadata->getIdentifierFieldNames();

        foreach ($metadata->getFieldNames() as $fieldName) {
            $lines = [];
            $identifierFields = $metadata->getIdentifierFieldNames();
            foreach ($metadata->getFieldNames() as $fieldName) {
                if (in_array($fieldName, $identifierFields, true) && 'create' === $mode || 'update' === $mode) {
                    continue;
                }
                $lines[] = '        $entity->set'.ucfirst($fieldName).'($dto->'.$fieldName.');';
            }

            return rtrim(implode("\n", $lines));
        }

        return rtrim(implode("\n", $lines));
    }

    /**
     * Génère le code d'assignement de résolution des ToMany.
     */
    public function generateDataToEntityToMany(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode,
        string $typeD,
    ): string {
        $lines = [];
        $identifierFields = $metadata->getIdentifierFieldNames();

        foreach ($metadata->getFieldNames() as $fieldName) {
            $lines = [];
            $identifierFields = $metadata->getIdentifierFieldNames();
            foreach ($metadata->getFieldNames() as $fieldName) {
                if (in_array($fieldName, $identifierFields, true) && 'create' === $mode) {
                    continue;
                }
                $lines[] = '        $entity->set'.ucfirst($fieldName).'($dto->'.$fieldName.');';
            }

            return rtrim(implode("\n", $lines));
        }

        return rtrim(implode("\n", $lines));
    }

    /**
     * Génère le code d'assignement des propriétés scalaires de l'entité vers le DTO.
     */
    public function generateEntityToDto(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode,
    ): string {
        $lines = [];
        $identifierFields = $metadata->getIdentifierFieldNames();
        foreach ($metadata->getFieldNames() as $fieldName) {
            $lines[] = '        $dto->'.$fieldName.' = $entity->get'.ucfirst($fieldName).'();';
        }

        return rtrim(implode("\n", $lines));
    }

    /**
     * Génère le code de résolution des ToOne (IRI -> Entity) dans les Processors.
     */
    public function generateEntityToDtoToOne(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode,
    ): string {
        $lines = [];
        $lines[] = '        // ToOne relations (IRI -> Entity)';
        $lines[] = '        foreach (get_object_vars($data) as $field => $value) {';
        $lines[] = "            if (!is_string(\$value) || !str_starts_with(\$value, '/api/')) {";
        $lines[] = '                continue;';
        $lines[] = '            }';
        $lines[] = '';
        $lines[] = '            switch ($field) {';

        $hasAny = false;

        foreach ($metadata->getAssociationMappings() as $mappingRaw) {
            $mapping = $this->normalizeAssociationMapping($mappingRaw);
            $field = $mapping['fieldName'];
            $assocType = $mapping['type'];

            $isToOne = in_array($assocType, [
                OrmClassMetadata::MANY_TO_ONE,
                OrmClassMetadata::ONE_TO_ONE,
            ], true);

            if (! $isToOne) {
                continue;
            }

            $hasAny = true;
            $targetFqcn = ltrim($mapping['targetEntity'], '\\');

            $lines[] = "                case '{$field}':";
            $lines[] = "                    \$resolved = \$this->resolveIri(\$value, \\{$targetFqcn}::class);";
            $lines[] = '                    try {';
            $lines[] = '                        $accessor->setValue($entity, $field, $resolved);';
            $lines[] = '                    } catch (\\Throwable) {';
            $lines[] = '                        // ignore si pas de setter / pas accessible';
            $lines[] = '                    }';
            $lines[] = '                    break;';
        }

        $lines[] = '                default:';
        $lines[] = '                    break;';
        $lines[] = '            }';
        $lines[] = '        }';

        if (! $hasAny) {
            return "        // No ToOne relations detected by Doctrine metadata.\n";
        }

        return implode("\n", $lines);
    }

    /**
     * Génère le code d'assignement des propriétés scalaires de l'entité vers le DTO.
     */
    public function generateEntityToDtoToMany(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $mode,
    ): string {
        //         $toManyAssignments = [];
        //         foreach ($toMany as $field => $resourceShortClass) {
        //             $getter = 'get' . ucfirst($field);

        //             $toManyAssignments[] = <<<PHP
        //         // {$field} (ToMany => array of IRIs)
        //         \$dto->{$field} = \$this->toIriList(\$entity->{$getter}(), {$resourceShortClass}::class);
        // PHP;
        //         }
        //         $toManyAssignmentsCode = empty($toManyAssignments) ? "        // No ToMany relations\n" : implode("\n\n", $toManyAssignments);

        $lines = [];
        $identifierFields = $metadata->getIdentifierFieldNames();
        foreach ($metadata->getFieldNames() as $fieldName) {
            $lines[] = '        $dto->'.$fieldName.' = $entity->get'.ucfirst($fieldName).'();';
        }

        return rtrim(implode("\n", $lines));
    }

    /**
     * Génère le code d'assignement des propriétés (scalars + relations) pour les Processors & Providers.
     */
    public function generatePropertyAssignmentsCode(
        OrmClassMetadata $metadata,
        string $shortEntityClass,
        string $baseDtoNamespace,
        string $baseResourceNamespace,
        string $typeP,
        string $typeR,
        string $data,
        string $mode,
    ): ?array {
        // Scalars (Doctrine fields)
        $fieldNames = $metadata->getFieldNames();

        // Associations
        $toOne = []; // [field => resourceFqcn]
        $toMany = []; // [field => resourceFqcn]
        $resourceUses = [];

        foreach ($metadata->getAssociationMappings() as $mappingRaw) {
            $m = $this->normalizeAssociationMapping($mappingRaw);

            $field = $m['fieldName'] ?? null;
            $type = $m['type'] ?? null;
            $targetFqcn = $m['targetEntity'] ?? null;
            $nullable = $m['joinColumns'][0]['nullable'] ?? true;

            if (! $field || ! $type || ! $targetFqcn) {
                continue;
            }

            $targetShort = $this->getShortClassName($targetFqcn);
            $targetResourceFqcn = "App\\ApiResource\\Resource\\{$targetShort}\\{$targetShort}Resource";
            if ($shortEntityClass !== $targetShort) {
                $resourceUses[$targetResourceFqcn] = "use {$targetResourceFqcn};";
            }
            $isToMany = in_array($type, [
                OrmClassMetadata::ONE_TO_MANY,
                OrmClassMetadata::MANY_TO_MANY,
            ], true);

            $isToOne = in_array($type, [
                OrmClassMetadata::MANY_TO_ONE,
                OrmClassMetadata::ONE_TO_ONE,
            ], true);

            if ($isToOne) {
                $toOne[$field] = [
                    'targetFqcn' => $targetShort.'Resource',
                    'entityFqcn' => $targetFqcn,
                    'nullable' => $nullable,
                ];
            } elseif ($isToMany) {
                $toMany[$field] = [
                    'targetFqcn' => $targetShort.'Resource',
                    'entityFqcn' => $targetFqcn,
                    'nullable' => $nullable,
                ];
            }
        }

        $resourceUsesCode = implode("\n", $resourceUses);
        if ('' !== $resourceUsesCode) {
            $resourceUsesCode .= "\n";
        }

        if (in_array($mode, ['resource', 'item', 'collection'], true)) {
            $entityToDtoScalar = $this->scalarEntityToDto($fieldNames, $mode);
            $entityToDtoToOne = $this->toOneEntityToDto($toOne);
            $entityToDtoToMany = $this->toManyEntityToDto($toMany);

            return [
                $resourceUsesCode,
                $entityToDtoScalar,
                $entityToDtoToOne,
                $entityToDtoToMany,
            ];
        }

        if ('create' === $mode) {
            $dataToEntityScalar = $this->scalarDataToEntity($fieldNames, $mode, 'dto');
            $dataToEntityToOne = $this->toOneDataToEntity($toOne, 'dto');
            $dataToEntityToMany = ''; // ToMany non supporté par setter direct en auto-scaffold

            $entityToDtoScalar = $this->scalarEntityToDto($fieldNames, $mode);
            $entityToDtoToOne = $this->toOneEntityToDto($toOne);
            $entityToDtoToMany = $this->toManyEntityToDto($toMany);

            return [
                $resourceUsesCode,
                $dataToEntityScalar,
                $dataToEntityToOne,
                $dataToEntityToMany,
                $entityToDtoScalar,
                $entityToDtoToOne,
                $entityToDtoToMany,
            ];
        }

        if ('update' === $mode) {
            $dataToEntityScalar = $this->scalarDataToEntity($fieldNames, $mode, 'dto');
            $dataToEntityToOne = $this->toOneDataToEntity($toOne, 'dto');
            $dataToEntityToMany = ''; // ToMany non supporté par setter direct en auto-scaffold

            $entityToDtoScalar = $this->scalarEntityToDto($fieldNames, $mode);
            $entityToDtoToOne = $this->toOneEntityToDto($toOne);
            $entityToDtoToMany = $this->toManyEntityToDto($toMany);

            return [
                $resourceUsesCode,
                $dataToEntityScalar,
                $dataToEntityToOne,
                $dataToEntityToMany,
            ];
        }

        return null;
    }
}
