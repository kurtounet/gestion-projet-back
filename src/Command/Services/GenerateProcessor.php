<?php

namespace App\Command\Services;

use App\Command\CmdHelpers;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;

final class GenerateProcessor
{
    public function __construct(
        private CmdHelpers $helpers,
    ) {
    }

    public function createProcessor(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $shortEntityClassCamelCase = $this->helpers->snakeToCamel($shortEntityClass);

        return <<<PHP
<?php
namespace App\ApiResource\State\\{$shortEntityClass};

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Mapper\\{$shortEntityClass}\\{$shortEntityClass}Mapper;
use App\ApiResource\Dto\\{$shortEntityClass}\\{$shortEntityClass}CreateDto;


final readonly class {$shortEntityClass}CreateProcessor implements ProcessorInterface
{
    public function __construct(
        private {$shortEntityClass}Mapper \${$shortEntityClassCamelCase}Mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface \$persistProcessor,
    ) {}

    public function process(mixed \$data, Operation \$operation, array \$uriVariables = [], array \$context = []): mixed
    {
        if (!(\$operation instanceof Post) || !(\$data instanceof {$shortEntityClass}CreateDto)) {
            return \$data;
        }

        \$entity = \$this->{$shortEntityClassCamelCase}Mapper->createDtoToEntity(\$data);
        \$entity = \$this->persistProcessor->process(\$entity, \$operation, \$uriVariables, \$context);
        return \$this->{$shortEntityClassCamelCase}Mapper->entityToItemDto(\$entity);
    }
}

PHP;
    }

    public function updateProcessor(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
        OrmClassMetadata $metadata,
    ): string {
        $shortEntityClassCamelCase = $this->helpers->snakeToCamel($shortEntityClass);

        return <<<PHP
<?php

namespace App\ApiResource\State\\{$shortEntityClass};

use App\Entity\\{$shortEntityClass};
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Mapper\\{$shortEntityClass}\\{$shortEntityClass}Mapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\\{$shortEntityClass}\\{$shortEntityClass}UpdateDto;


final readonly class {$shortEntityClass}UpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface \$em,
        private {$shortEntityClass}Mapper \${$shortEntityClassCamelCase}Mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface \$persistProcessor,
    ) {}

    public function process(mixed \$data, Operation \$operation, array \$uriVariables = [], array \$context = []): mixed
    {
        if (!(\$operation instanceof Patch) || !(\$data instanceof {$shortEntityClass}UpdateDto)) {
            return \$data;
        }

        \$id = \$uriVariables['id'] ?? null;
        if (!is_string(\$id) && !is_int(\$id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        \$entity = \$this->em->getRepository(\\{$entityFqcn}::class)->find(\$id);

        if (!\$entity instanceof {$shortEntityClass}) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', {$shortEntityClass}::class, (string) \$id));
        }

        \$updatedEntity = \$this->{$shortEntityClassCamelCase}Mapper->updateDtoToEntity(\$entity, \$data);
        \$entity = \$this->persistProcessor->process(\$updatedEntity, \$operation, \$uriVariables, \$context);
        return \$this->{$shortEntityClassCamelCase}Mapper->entityToItemDto(\$entity);
    }
}
PHP;
    }

    public function deleteProcessor(
        string $namespace,
        string $shortEntityClass,
        string $entityFqcn,
    ): string {
        return <<<PHP
<?php

namespace {$namespace};

use ApiPlatform\\Metadata\\Delete;
use ApiPlatform\\Metadata\\Operation;
use ApiPlatform\\State\\ProcessorInterface;
use Symfony\\Component\\DependencyInjection\\Attribute\\Autowire;

/**
* Delete processor pour {$shortEntityClass}.
*
* @implements ProcessorInterface<{$entityFqcn}, void>
*/
final readonly class {$shortEntityClass}DeleteProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface \$removeProcessor,
    ) {}

    public function process(mixed \$data, Operation \$operation, array \$uriVariables = [], array \$context = []): mixed
    {
        if (\$operation instanceof Delete) {
            \$this->removeProcessor->process(\$data, \$operation, \$uriVariables, \$context);
            return null;
        }

        return \$data;
    }
}
PHP;
    }

    public function toIriList(): string
    {
        return <<<PHP
        private function toIriList(iterable \$items, string \$resourceClass): array
        {
            \$iris = [];
            foreach (\$items as \$item) {
                if (!is_object(\$item)) {
                    continue;
                }

                \$iri = (\$this->iriFromResource)(\$resourceClass, \$item->getId());
                if (null !== \$iri) {
                    \$iris[] = \$iri;
                }
            }
            return \$iris;
        }
PHP;
    }

    public function resolveIri(): string
    {
        return <<<PHP
        private function resolveIri(?string \$iri, string \$expectedClass, string \$field, bool \$required = false): ?object
        {
        if (\$iri === null || \$iri === '') {
            if (\$required) {
                throw new BadRequestHttpException(sprintf(
                    'Field "%s" is required and must be a non-empty IRI string.',
                    \$field
                ));
            }

            // OPTIONNEL => on retourne null (et on ne throw pas)
            return null;
        }

        try {
            \$resource = \$this->iriConverter->getResourceFromIri(\$iri);
        } catch (\Throwable \$e) {
            throw new BadRequestHttpException(sprintf('Invalid IRI for field "%s".', \$field), \$e);
        }

        // 1) Si l’IRI te donne déjà l’Entity attendue, parfait
        if (\$resource instanceof \$expectedClass) {
            return \$resource;
        }

        // 2) Sinon, on tente de récupérer l’ID depuis l’objet ressource
        \$id = null;
        if (is_object(\$resource) && property_exists(\$resource, 'id')) {
            \$id = \$resource->id;
        }

        // 3) Fallback: extraire l’ID de la fin de l’IRI (/api/statuses/121)
        if (\$id === null && preg_match('~/(\\d+)$~', \$iri, \$m)) {
            \$id = (int) \$m[1];
        }

        if (\$id === null) {
            throw new BadRequestHttpException(sprintf(
                'Invalid IRI type for field "%s". Expected "%s".',
                \$field,
                \$expectedClass
            ));
        }

        \$entity = \$this->em->getRepository(\$expectedClass)->find(\$id);

        if (!\$entity) {
            throw new BadRequestHttpException(sprintf(
                'Resource not found for field "%s" (id: %s).',
                \$field,
                (string) \$id
            ));
        }

        return \$entity;
    }
PHP;
    }

    public function extractIdFromIri(): string
    {
        return <<<PHP
        /**
         * Extrait l'ID depuis un IRI sans faire de requête SQL
         */
        private function extractIdFromIri(string \$iri): int
        {
            \$parts = explode('/', trim(\$iri, '/'));
            \$id = end(\$parts);
            if (!is_numeric(\$id)) {
                throw new \InvalidArgumentException(
                    sprintf('ID invalide extrait de l\'IRI "%s"', \$iri)
                );
            }
            return (int) \$id;
        }
PHP;
    }
}
