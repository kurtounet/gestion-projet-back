<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\FieldMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

#[AsCommand(
    name: 'app:make:dto-from-entities',
    description: 'Génère des DTO (Create/Update/Response) à partir des entités Doctrine avec contraintes de validation.'
)]
class MakeDtoFromEntitiesCommand extends Command
{
    public function __construct(
        private readonly ManagerRegistry $registry,
        private readonly KernelInterface $kernel,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->registry->getManager();
        $meta = $em->getMetadataFactory()->getAllMetadata();

        if (empty($meta)) {
            $io->warning('Aucune entité Doctrine trouvée.');

            return Command::INVALID;
        }

        $io->title('Génération des DTO à partir des entités Doctrine');

        foreach ($meta as $classMetadata) {
            if (! $classMetadata instanceof ClassMetadata) {
                continue;
            }

            $this->generateDtosForEntity($classMetadata, $io);
        }

        $io->success('Génération des DTO terminée.');

        return Command::SUCCESS;
    }

    private function generateDtosForEntity(ClassMetadata $meta, SymfonyStyle $io): void
    {
        $entityClass = $meta->getName();
        $entityRef = new \ReflectionClass($entityClass);
        $entityShort = $entityRef->getShortName();

        $io->section(sprintf(
            'Entité : %s -> DTO : Create%sDto / Update%sDto / %sResponseDto',
            $entityClass,
            $entityShort,
            $entityShort,
            $entityShort
        ));

        $fields = [];

        foreach ($meta->getFieldNames() as $fieldName) {
            $mapping = $meta->getFieldMapping($fieldName); // FieldMapping|array

            [$doctrineType, $nullable] = $this->extractDoctrineTypeAndNullable($mapping);
            $isId = $meta->isIdentifier($fieldName);

            $constraints = [];

            // 1. Contraintes déjà présentes sur l’entité (attributs PHP)
            if ($entityRef->hasProperty($fieldName)) {
                $property = $entityRef->getProperty($fieldName);
                $constraints = array_merge(
                    $constraints,
                    $this->extractValidationAttributesFromProperty($property)
                );
            }

            // 2. Contraintes déduites du mapping Doctrine
            $constraints = array_merge(
                $constraints,
                $this->inferConstraintsFromDoctrineMapping($mapping)
            );

            // Suppression des doublons éventuels
            $constraints = array_values(array_unique($constraints));

            $fields[] = [
                'name' => $fieldName,
                'doctrineType' => $doctrineType,
                'nullable' => $nullable,
                'constraints' => $constraints,
                'isId' => $isId,
            ];
        }

        if (empty($fields)) {
            $io->warning(sprintf('Entité %s sans champs scalaires gérés, DTO ignorés.', $entityClass));

            return;
        }

        $dtoNamespace = 'App\\Dto\\'.$entityShort;
        $directory = $entityShort;
        $createClassName = $entityShort.'CreateDto';
        $updateClassName = $entityShort.'UpdateDto';
        $responseClassName = $entityShort.'ResponseDto';

        $createCode = $this->buildCreateDtoCode($dtoNamespace, $createClassName, $fields);
        $updateCode = $this->buildUpdateDtoCode($dtoNamespace, $updateClassName, $fields);
        $responseCode = $this->buildResponseDtoCode($dtoNamespace, $responseClassName, $fields);

        $this->writeDtoFile($io, $directory, $createClassName, $createCode);
        $this->writeDtoFile($io, $directory, $updateClassName, $updateCode);
        $this->writeDtoFile($io, $directory, $responseClassName, $responseCode);
    }

    /**
     * @param FieldMapping|array<string,mixed> $mapping
     *
     * @return array{0:string,1:bool} [doctrineType, nullable]
     */
    private function extractDoctrineTypeAndNullable(FieldMapping|array $mapping): array
    {
        if ($mapping instanceof FieldMapping) {
            $type = $mapping->type ?? 'string';
            $nullable = $mapping->nullable ?? false;
        } else {
            $type = $mapping['type'] ?? 'string';
            $nullable = $mapping['nullable'] ?? false;
        }

        return [$type, $nullable];
    }

    /**
     * Map le type Doctrine vers un type PHP, en tenant compte de la nullabilité.
     */
    private function mapDoctrineTypeToPhp(string $doctrineType, bool $nullable): string
    {
        $baseType = match ($doctrineType) {
            'string', 'text' => 'string',
            'integer', 'smallint', 'bigint' => 'int',
            'float', 'decimal' => 'float',
            'boolean' => 'bool',
            'datetime', 'datetime_immutable',
            'datetimetz', 'date' => \DateTimeInterface::class,
            'json', 'simple_array' => 'array',
            default => 'mixed',
        };

        if ($nullable && 'mixed' !== $baseType && ! str_starts_with($baseType, '?')) {
            return '?'.$baseType;
        }

        return $baseType;
    }

    /**
     * Retourne les contraintes Assert présentes sur la propriété de l’entité.
     *
     * @return string[] lignes du type "#[Assert\NotBlank]" ou "#[Assert\Length(min: 3, max: 255)]"
     */
    private function extractValidationAttributesFromProperty(\ReflectionProperty $property): array
    {
        $lines = [];

        foreach ($property->getAttributes() as $attribute) {
            $attrClass = $attribute->getName();

            // On ne garde que les attributs qui sont des contraintes de validation
            if (! is_subclass_of($attrClass, Constraint::class)) {
                continue;
            }

            $shortName = (new \ReflectionClass($attrClass))->getShortName();
            $arguments = $attribute->getArguments();

            if (empty($arguments)) {
                $lines[] = sprintf('#[Assert\%s]', $shortName);

                continue;
            }

            $argsCodeParts = [];
            foreach ($arguments as $name => $value) {
                $exported = var_export($value, true);
                if (is_string($name)) {
                    $argsCodeParts[] = sprintf('%s: %s', $name, $exported);
                } else {
                    $argsCodeParts[] = $exported;
                }
            }

            $argsCode = implode(', ', $argsCodeParts);
            $lines[] = sprintf('#[Assert\%s(%s)]', $shortName, $argsCode);
        }

        return $lines;
    }

    /**
     * Déduit quelques contraintes basiques à partir du mapping Doctrine.
     *
     * @param FieldMapping|array<string,mixed> $mapping
     *
     * @return string[]
     */
    private function inferConstraintsFromDoctrineMapping(FieldMapping|array $mapping): array
    {
        if ($mapping instanceof FieldMapping) {
            $type = $mapping->type ?? 'string';
            $nullable = $mapping->nullable ?? false;
            $length = $mapping->length ?? null;
            $options = $mapping->options ?? [];
        } else {
            $type = $mapping['type'] ?? 'string';
            $nullable = $mapping['nullable'] ?? false;
            $length = $mapping['length'] ?? null;
            $options = $mapping['options'] ?? [];
        }

        $constraints = [];

        // NotNull / NotBlank
        if (! $nullable) {
            if (in_array($type, ['string', 'text'], true)) {
                $constraints[] = '#[Assert\NotBlank]';
            } else {
                $constraints[] = '#[Assert\NotNull]';
            }
        }

        // Length(max)
        if (null !== $length && in_array($type, ['string', 'text'], true)) {
            $constraints[] = sprintf('#[Assert\Length(max: %d)]', $length);
        }

        // Exemple pour les nombres : unsigned => PositiveOrZero
        if (in_array($type, ['integer', 'smallint', 'bigint', 'float', 'decimal'], true)) {
            $unsigned = false;

            if (is_array($options) && isset($options['unsigned']) && true === $options['unsigned']) {
                $unsigned = true;
            }

            if ($unsigned) {
                $constraints[] = '#[Assert\PositiveOrZero]';
            }
        }

        return $constraints;
    }

    /**
     * Pour le UpdateDto on retire les contraintes NotBlank/NotNull (champ optionnel).
     *
     * @param string[] $constraints
     *
     * @return string[]
     */
    private function filterConstraintsForUpdate(array $constraints): array
    {
        return array_values(array_filter(
            $constraints,
            static fn (string $line): bool => ! str_contains($line, 'NotBlank') && ! str_contains($line, 'NotNull')
        ));
    }

    /**
     * @param array<int, array{name:string,doctrineType:string,nullable:bool,constraints:string[],isId:bool}> $fields
     */
    private function buildCreateDtoCode(string $namespace, string $className, array $fields): string
    {
        $paramsBlocks = [];

        foreach ($fields as $field) {
            $name = $field['name'];
            $isId = $field['isId'];
            $constraints = $field['constraints'];
            $nullable = $field['nullable'];
            $doctrineType = $field['doctrineType'];

            // 1) On ne met pas les identifiants dans un Create DTO
            if ($isId) {
                continue;
            }

            // 2) Convention actuelle : on ne met PAS createdAt / updatedAt dans le CreateDto
            if (\in_array($name, ['createdAt', 'updatedAt'], true)) {
                continue;
            }
            // 2) Convention : createdAt / updatedAt sont gérés côté serveur → optionnels, sans NotNull/NotBlank
            $isTimestampField = \in_array($name, ['createdAt', 'updatedAt'], true);

            // if ($isTimestampField) {
            //     // On force nullable pour le type PHP
            //     $phpType = $this->mapDoctrineTypeToPhp($doctrineType, true); // ?DateTimeInterface
            //     $default = ' = null';

            //     // On supprime les contraintes NotBlank / NotNull
            //     $constraints = array_values(array_filter(
            //         $constraints,
            //         static fn(string $line): bool =>
            //         !str_contains($line, 'NotBlank') && !str_contains($line, 'NotNull')
            //     ));
            // } else {
            // }

            // Cas normal
            $phpType = $this->mapDoctrineTypeToPhp($doctrineType, $nullable);
            $default = $nullable ? ' = null' : '';

            $lines = [];

            foreach ($constraints as $constraintLine) {
                $lines[] = '        '.$constraintLine;
            }

            $lines[] = sprintf(
                '        public %s $%s%s,',
                $phpType,
                $name,
                $default
            );

            $paramsBlocks[] = implode("\n", $lines);
        }

        $paramsBlock = implode("\n\n", $paramsBlocks);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class {$className}
{
    public function __construct(
{$paramsBlock}
    ) {
    }
}

PHP;
    }

    //     private function buildCreateDtoCode(string $namespace, string $className, array $fields): string
    //     {
    //         $paramsBlocks = [];

    //         foreach ($fields as $field) {
    //             $phpType  = $this->mapDoctrineTypeToPhp($field['doctrineType'], $field['nullable']);
    //             $default  = $field['nullable'] ? ' = null' : '';
    //             $lines    = [];

    //             foreach ($field['constraints'] as $constraintLine) {
    //                 $lines[] = '        ' . $constraintLine;
    //             }

    //             $lines[] = sprintf(
    //                 '        public %s $%s%s,',
    //                 $phpType,
    //                 $field['name'],
    //                 $default
    //             );

    //             $paramsBlocks[] = implode("\n", $lines);
    //         }

    //         $paramsBlock = implode("\n\n", $paramsBlocks);

    //         return <<<PHP
    // <?php

    // declare(strict_types=1);

    // namespace {$namespace};

    // use DateTimeInterface;
    // use Symfony\Component\Validator\Constraints as Assert;

    // final class {$className}
    // {
    //     public function __construct(
    // {$paramsBlock}
    //     ) {
    //     }
    // }

    // PHP;
    //     }

    /**
     * @param array<int, array{name:string,doctrineType:string,nullable:bool,constraints:string[],isId:bool}> $fields
     */
    private function buildUpdateDtoCode(string $namespace, string $className, array $fields): string
    {
        $paramsBlocks = [];

        foreach ($fields as $field) {
            // Tous les champs sont optionnels dans un Update DTO
            $phpType = $this->mapDoctrineTypeToPhp($field['doctrineType'], true);
            $default = ' = null';
            $lines = [];

            $constraints = $this->filterConstraintsForUpdate($field['constraints']);

            foreach ($constraints as $constraintLine) {
                $lines[] = '        '.$constraintLine;
            }

            $lines[] = sprintf(
                '        public %s $%s%s,',
                $phpType,
                $field['name'],
                $default
            );

            $paramsBlocks[] = implode("\n", $lines);
        }

        $paramsBlock = implode("\n\n", $paramsBlocks);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class {$className}
{
    public function __construct(
{$paramsBlock}
    ) {
    }
}

PHP;
    }

    /**
     * @param array<int, array{name:string,doctrineType:string,nullable:bool,constraints:string[],isId:bool}> $fields
     */
    private function buildResponseDtoCode(string $namespace, string $className, array $fields): string
    {
        $paramsBlocks = [];

        foreach ($fields as $field) {
            $phpType = $this->mapDoctrineTypeToPhp($field['doctrineType'], $field['nullable']);
            $default = $field['nullable'] ? ' = null' : '';
            $lines = [];

            // Pas de contraintes sur un Response DTO
            $lines[] = sprintf(
                '        public %s $%s%s,',
                $phpType,
                $field['name'],
                $default
            );

            $paramsBlocks[] = implode("\n", $lines);
        }

        $paramsBlock = implode("\n\n", $paramsBlocks);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use DateTimeInterface;
final class {$className}
{
    public function __construct(
{$paramsBlock}
    ) {
    }
}

PHP;
    }

    private function writeDtoFile(SymfonyStyle $io, string $directory, string $className, string $code): void
    {
        $dtoDir = $this->kernel->getProjectDir().'/src/Dto/'.$directory;

        if (! is_dir($dtoDir) && ! mkdir($dtoDir, 0o775, true) && ! is_dir($dtoDir)) {
            $io->error(sprintf('Impossible de créer le répertoire "%s".', $dtoDir));

            return;
        }

        $filePath = $dtoDir.'/'.$className.'.php';

        if (file_exists($filePath)) {
            $overwrite = $io->confirm(sprintf('Le DTO "%s" existe déjà. L’écraser ?', $filePath), false);
            if (! $overwrite) {
                $io->warning(sprintf('DTO "%s" non écrasé.', $filePath));

                return;
            }
        }

        file_put_contents($filePath, $code);
        $io->success(sprintf('DTO généré : %s', $filePath));
    }
}
