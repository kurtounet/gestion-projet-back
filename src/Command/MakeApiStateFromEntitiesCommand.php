<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:make:api-state-from-entities',
    description: 'Génère les Provider et Processor API Platform pour chaque entité Doctrine.'
)]
class MakeApiStateFromEntitiesCommand extends Command
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

        $io->title('Génération des Provider & Processor API Platform à partir des entités Doctrine');
        $allMeta = [];
        foreach ($meta as $classMetadata) {
            if (! $classMetadata instanceof ClassMetadata) {
                continue;
            }
            $allMeta[$classMetadata->getTableName()] = $classMetadata;
            $this->generateApiStateForEntity($classMetadata, $io, $classMetadata->fieldMappings, $classMetadata->associationMappings);
        }
        file_put_contents($this->kernel->getProjectDir().'/classMetadata.json', json_encode($allMeta));

        $io->success('Génération des Provider & Processor terminée.');

        return Command::SUCCESS;
    }

    /**
     * @param object-array<string, Doctrine\ORM\Mapping\ClassMetadata> $meta
     * @param array<string, \Doctrine\ORM\Mapping\FieldMapping>        $fields
     */
    private function generateApiStateForEntity(ClassMetadata $meta, SymfonyStyle $io, array $fields, array $associations): void
    {
        $entityClass = $meta->getName();
        $ref = new \ReflectionClass($entityClass);
        $entityShort = $ref->getShortName();

        $io->section(sprintf(
            'Entité : %s -> Provider/Processor : %sProvider / %sProcessor',
            $entityClass,
            $entityShort,
            $entityShort
        ));

        $namespace = 'App\\State\\'.$entityShort;
        $directory = $entityShort;
        $providerName = $entityShort.'Provider';
        $processorName = $entityShort.'Processor';

        $providerCode = $this->buildProviderCode($namespace, $entityShort, $entityClass, $fields, $associations);
        $processorCode = $this->buildProcessorCode($namespace, $entityShort, $entityClass, $fields, $associations);

        $this->writeStateFile($io, $directory, $providerName, $providerCode);
        $this->writeStateFile($io, $directory, $processorName, $processorCode);
    }

    /**
     * @param array<string, \Doctrine\ORM\Mapping\FieldMapping> $fields
     */
    private function buildProviderCode(string $namespace, string $entityShort, string $entityClass, array $fields, array $associations): string
    {
        $entityShort = (new \ReflectionClass($entityClass))->getShortName();
        $properties = '';
        $propertiesRelations = '';
        $comma = ',';
        foreach ($fields as $field) {
            $pascalCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $field->columnName)));
            $properties = $properties.PHP_EOL.'$entity->get'.$pascalCase.'()'.$comma;
        }

        foreach ($associations as $field) {
            $pascalCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $field->fieldName)));
            $propertiesRelations = $propertiesRelations.PHP_EOL.'$entity->get'.$pascalCase.'()->getId()'.$comma;
        }

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use ApiPlatform\\Metadata\\Operation;
use ApiPlatform\\State\\ProviderInterface;
use Doctrine\\Persistence\\ManagerRegistry;
use ApiPlatform\\Metadata\\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use {$entityClass};
use App\Dto\\{$entityShort}\\{$entityShort}ResponseDto;


final class {$entityShort}Provider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface \$collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface \$itemProvider,
    ) {}

     /**
     * @return {$entityShort}|iterable<{$entityShort}>|null
     */
    public function provide(Operation \$operation, array \$uriVariables = [], array \$context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if (\$operation instanceof CollectionOperationInterface) {

            \$result = \$this->collectionProvider->provide(\$operation, \$uriVariables, \$context);

            \$dtos = [];
            foreach (\$result as \$entity) {
                if (!\$entity instanceof {$entityShort}) {
                    continue;
                }
                \$dtos[] = \$this->mapEntityToDto(\$entity);
            }
            return \$dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        \$item = \$this->itemProvider->provide(\$operation, \$uriVariables, \$context);

        if (\$item instanceof {$entityShort}) {
            return \$this->mapEntityToDto(\$item);
        }

        return \$item;
    }

    private function mapEntityToDto({$entityShort} \$entity) //: {$entityShort}ResponseDto
    {

        return new {$entityShort}ResponseDto(

            {$properties}
            {$propertiesRelations}

        );

    }
}

PHP;
    }

    private function buildProcessorCode(string $namespace, string $entityShort, string $entityClass, array $fields, array $associations): string
    {
        $entityShort = (new \ReflectionClass($entityClass))->getShortName();

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\\State\\ProcessorInterface;
use {$entityClass};
use App\Dto\\{$entityShort}\\{$entityShort}CreateDto;
use App\Dto\\{$entityShort}\\{$entityShort}UpdateDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
/**
 * Processor pour {$entityShort}.
 *
 * À brancher sur la ressource :
 * #[ApiResource(processor: {$entityShort}Processor::class)]
 */
final class {$entityShort}Processor implements ProcessorInterface
{

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface \$persistProcessor,

        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private readonly ProcessorInterface \$removeProcessor,
    ) {}


    /**
     * @param {$entityShort}|mixed \$data
     */
    public function process(mixed \$data, Operation \$operation, array \$uriVariables = [], array \$context = []): mixed
    {
        // Cas DELETE : on délègue au remove_processor
        if (\$operation instanceof Delete) {
            \$this->removeProcessor->process(\$data, \$operation, \$uriVariables, \$context);
            return null;
        }

        // Création: Dans operation POST -> DTO Create dans l'entité
        if (\$operation instanceof Post && \$data instanceof {$entityShort}CreateDto) {
            // Ici, tu vas chercher les relations à partir des *Id :
            /*
            \$status = \$this->em->getRepository(Status::class)->find(\$data->statusId);
            \$comment = \$this->em->getRepository(Comment::class)->find(\$data->commentId);
            \$priority = \$this->em->getRepository(Priority::class)->find(\$data->priorityId);
            \$projectTemplate = \$this->em->getRepository(ProjectTemplate::class)->find(\$data->projectTemplateId);

            \$entity = new {$entityShort}();
            \$entity->setName(\$data->name);
            \$entity->setDescription(\$data->description);
            \$entity->setStartDate(\$data->startDate);
            \$entity->setEndDate(\$data->endDate);

            \$entity->setStatus(\$status);
            \$entity->setPriority(\$priority);
            \$entity->setProjectTemplate(\$projectTemplate);
            \$entity->setComment(\$comment);

            \$this->em->persist(\$entity);
            \$this->em->flush();

            return \$entity;
            */
        }

        // Mise à jour PATCH/PUT si tu as un DTO Update
        // if (\$operation instanceof Patch || \$operation instanceof Put && \$data instanceof {$entityShort}UpdateDto) {
        //     \$entity = \$this->em->getRepository({$entityShort}::class)->find(\$data->id);
        //     \$entity->setName(\$data->name);
        //     \$entity->setDescription(\$data->description);
        //     \$entity->setStartDate(\$data->startDate);
        //     \$entity->setEndDate(\$data->endDate);
        //     \$this->em->persist(\$entity);
        //     \$this->em->flush();
        //     return \$entity;
        // }

        // Cas où \$data est déjà une entité, on peut faire :
        // if (\$data instanceof {$entityShort}) {
        //     \$this->em->persist(\$data);
        //     \$this->em->flush();

        //     return \$data;
        // }

        return \$data;
    }
}

PHP;
    }

    private function writeStateFile(SymfonyStyle $io, string $directory, string $className, string $code): void
    {
        $baseDir = $this->kernel->getProjectDir().'/src/State/'.$directory;

        if (! is_dir($baseDir) && ! mkdir($baseDir, 0o775, true) && ! is_dir($baseDir)) {
            $io->error(sprintf('Impossible de créer le répertoire "%s".', $baseDir));

            return;
        }

        $filePath = $baseDir.'/'.$className.'.php';

        if (file_exists($filePath)) {
            $overwrite = $io->confirm(sprintf('Le fichier "%s" existe déjà. L’écraser ?', $filePath), false);
            if (! $overwrite) {
                $io->warning(sprintf('Fichier "%s" non écrasé.', $filePath));

                return;
            }
        }

        file_put_contents($filePath, $code);
        $io->success(sprintf('Fichier généré : %s', $filePath));
    }
}
