<?php

namespace App\Command;

use App\Command\Services\GenerateBrunoCollection;
use App\Command\Services\GenerateDto;
use App\Command\Services\GenerateMapper;
use App\Command\Services\GenerateProcessor;
use App\Command\Services\GenerateProvider;
use App\Command\Services\GenerateServices;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:make:api-scaffold',
    description: 'Génère automatiquement les Resource, DTO (Create/Update/Item/Collection/Relation), Provider et Processor pour toutes les entités Doctrine.',
)]
final class MakeApiScaffoldCommand extends Command
{
    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly EntityManagerInterface $entityManager,
        private readonly Filesystem $filesystem,
        private readonly GenerateProcessor $generateProcessor,
        private readonly GenerateProvider $generateProvider,
        private readonly GenerateDto $generateDto,
        private readonly GenerateMapper $generateMapper,
        private readonly CmdHelpers $helpers,
        private readonly GenerateServices $generateServices,
        private readonly GenerateBrunoCollection $bruno,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $BASE_RESOURCE_NAMESPACE = $this->helpers->getNamespace('Resource');
        $BASE_DTO_NAMESPACE = $this->helpers->getNamespace('Dto');
        $BASE_STATE_NAMESPACE = $this->helpers->getNamespace('State');
        $BASE_SERVICE_NAMESPACE = $this->helpers->getNamespace('Service');
        $BASE_MAPPER_NAMESPACE = $this->helpers->getNamespace('Mapper');

        $io = new SymfonyStyle($input, $output);
        $projectDir = $this->kernel->getProjectDir();

        $dtoBaseDir = $projectDir.'/src/ApiResource/Dto';
        $stateBaseDir = $projectDir.'/src/ApiResource/State';
        $serviceBaseDir = $projectDir.'/src/ApiResource/Service';
        $mapperBaseDir = $projectDir.'/src/ApiResource/Mapper';
        $metaDataBaseDir = 'metaData';
        $resourceBaseDir = $projectDir.'/src/ApiResource/Resource';
        $apiResourceBaseDir = $projectDir.'/src/ApiResource';

        foreach ([$apiResourceBaseDir, $resourceBaseDir, $dtoBaseDir, $stateBaseDir, $serviceBaseDir, $metaDataBaseDir] as $dir) {
            if (! $this->filesystem->exists($dir)) {
                $this->filesystem->mkdir($dir);
            }
        }
        /** @var OrmClassMetadata[] $allMetadata */
        $allMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (empty($allMetadata)) {
            $io->warning('Aucune entité Doctrine trouvée.');

            return Command::SUCCESS;
        }
        // Génération du service IriFromResource

        if (! $this->filesystem->exists($serviceBaseDir.'/IriFromResource.php')) {
            $this->filesystem->dumpFile(
                $serviceBaseDir.'/IriFromResource.php',
                $this->generateServices->generateIriFromResource($BASE_SERVICE_NAMESPACE)
            );
            $io->success(sprintf('Service généré : %s', $serviceBaseDir.'/IriFromResource.php'));
        } else {
            $io->note(sprintf('Service déjà présent, ignoré : %s', $serviceBaseDir.'/IriFromResource.php'));
        }
        $this->filesystem->mkdir($dir);
        $io->text(sprintf('Création du répertoire : <info>%s</info>', $dir));

        $metaExport = [];

        foreach ($allMetadata as $metadata) {
            $entityFqcn = $metadata->getName();                 // ex: App\Entity\ProjectInstance
            $shortEntityClass = $this->helpers->getShortClassName($entityFqcn); // ex: ProjectInstance

            $resourceNamespace = $BASE_RESOURCE_NAMESPACE.$shortEntityClass;
            $dtoNamespace = $BASE_DTO_NAMESPACE.$shortEntityClass;
            $stateNamespace = $BASE_STATE_NAMESPACE.$shortEntityClass;
            $mapperNamespace = $BASE_MAPPER_NAMESPACE.$shortEntityClass;

            $entityResourceDir = $resourceBaseDir.'/'.$shortEntityClass;
            $entityDtoDir = $dtoBaseDir.'/'.$shortEntityClass;
            $entityStateDir = $stateBaseDir.'/'.$shortEntityClass;
            $entityMapperDir = $mapperBaseDir.'/'.$shortEntityClass;

            file_put_contents(
                $this->kernel->getProjectDir().'/metaData/'.$shortEntityClass.'.json',
                json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );

            foreach ([$entityResourceDir, $entityDtoDir, $entityStateDir, $entityMapperDir] as $dir) {
                if (! $this->filesystem->exists($dir)) {
                    $this->filesystem->mkdir($dir);
                    $io->text(sprintf('Création du répertoire : <info>%s</info>', $dir));
                }
            }

            // 1) Resource
            $resourcePath = $entityResourceDir.'/'.$shortEntityClass.'Resource.php';
            if (! $this->filesystem->exists($resourcePath)) {
                $this->filesystem->dumpFile(
                    $resourcePath,
                    $this->generateDto->Resource($resourceNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('Resource généré : %s', $resourcePath));
            } else {
                $io->note(sprintf('Resource déjà présent, ignoré : %s', $resourcePath));
            }

            // 2) CreateDto
            $createDtoPath = $entityDtoDir.'/'.$shortEntityClass.'CreateDto.php';
            if (! $this->filesystem->exists($createDtoPath)) {
                $this->filesystem->dumpFile(
                    $createDtoPath,
                    $this->generateDto->create($dtoNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('CreateDto généré : %s', $createDtoPath));
            } else {
                $io->note(sprintf('CreateDto déjà présent, ignoré : %s', $createDtoPath));
            }

            // 3) UpdateDto
            $updateDtoPath = $entityDtoDir.'/'.$shortEntityClass.'UpdateDto.php';
            if (! $this->filesystem->exists($updateDtoPath)) {
                $this->filesystem->dumpFile(
                    $updateDtoPath,
                    $this->generateDto->update($dtoNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('UpdateDto généré : %s', $updateDtoPath));
            } else {
                $io->note(sprintf('UpdateDto déjà présent, ignoré : %s', $updateDtoPath));
            }

            /* 4) ItemDto
            $itemDtoPath = $entityDtoDir.'/'.$shortEntityClass.'ItemDto.php';
            if (! $this->filesystem->exists($itemDtoPath)) {
                $this->filesystem->dumpFile(
                    $itemDtoPath,
                    $this->generateDto->item($dtoNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('ItemDto généré : %s', $itemDtoPath));
            } else {
                $io->note(sprintf('ItemDto déjà présent, ignoré : %s', $itemDtoPath));
            }

            // 5) CollectionItemDto
            $collectionDtoPath = $entityDtoDir.'/'.$shortEntityClass.'CollectionItemDto.php';
            if (! $this->filesystem->exists($collectionDtoPath)) {
                $this->filesystem->dumpFile(
                    $collectionDtoPath,
                    $this->generateDto->collection($dtoNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('CollectionItemDto généré : %s', $collectionDtoPath));
            } else {
                $io->note(sprintf('CollectionItemDto déjà présent, ignoré : %s', $collectionDtoPath));
            }

            // 6) RelationDto
            $relationDtoPath = $entityDtoDir.'/'.$shortEntityClass.'RelationDto.php';
            if (! $this->filesystem->exists($relationDtoPath)) {
                $this->filesystem->dumpFile(
                    $relationDtoPath,
                    $this->generateDto->relation($dtoNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('RelationDto généré : %s', $relationDtoPath));
            } else {
                $io->note(sprintf('RelationDto déjà présent, ignoré : %s', $relationDtoPath));
            }
            */
            // 7) Collection Provider
            $collectionProviderPath = $entityStateDir.'/'.$shortEntityClass.'CollectionProvider.php';
            if (! $this->filesystem->exists($collectionProviderPath)) {
                $this->filesystem->dumpFile(
                    $collectionProviderPath,
                    $this->generateProvider->collectionProvider($stateNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('CollectionProvider généré : %s', $collectionProviderPath));
            } else {
                $io->note(sprintf('CollectionProvider déjà présent, ignoré : %s', $collectionProviderPath));
            }

            // 8) Item Provider
            $itemProviderPath = $entityStateDir.'/'.$shortEntityClass.'ItemProvider.php';
            if (! $this->filesystem->exists($itemProviderPath)) {
                $this->filesystem->dumpFile(
                    $itemProviderPath,
                    $this->generateProvider->itemProvider($stateNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('ItemProvider généré : %s', $itemProviderPath));
            } else {
                $io->note(sprintf('ItemProvider déjà présent, ignoré : %s', $itemProviderPath));
            }

            // 9) Create Processor
            $createProcessorPath = $entityStateDir.'/'.$shortEntityClass.'CreateProcessor.php';
            if (! $this->filesystem->exists($createProcessorPath)) {
                $this->filesystem->dumpFile(
                    $createProcessorPath,
                    $this->generateProcessor->createProcessor($stateNamespace, $shortEntityClass, $entityFqcn, $metadata),
                );
                $io->success(sprintf('CreateProcessor généré : %s', $createProcessorPath));
            } else {
                $io->note(sprintf('CreateProcessor déjà présent, ignoré : %s', $createProcessorPath));
            }

            // 10) Update Processor
            $updateProcessorPath = $entityStateDir.'/'.$shortEntityClass.'UpdateProcessor.php';
            if (! $this->filesystem->exists($updateProcessorPath)) {
                $this->filesystem->dumpFile(
                    $updateProcessorPath,
                    $this->generateProcessor->updateProcessor($stateNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('UpdateProcessor généré : %s', $updateProcessorPath));
            } else {
                $io->note(sprintf('UpdateProcessor déjà présent, ignoré : %s', $updateProcessorPath));
            }

            // 11) Delete Processor
            $deleteProcessorPath = $entityStateDir.'/'.$shortEntityClass.'DeleteProcessor.php';
            if (! $this->filesystem->exists($deleteProcessorPath)) {
                $this->filesystem->dumpFile(
                    $deleteProcessorPath,
                    $this->generateProcessor->deleteProcessor($stateNamespace, $shortEntityClass, $entityFqcn)
                );
                $io->success(sprintf('DeleteProcessor généré : %s', $deleteProcessorPath));
            } else {
                $io->note(sprintf('DeleteProcessor déjà présent, ignoré : %s', $deleteProcessorPath));
            }
            // 12) Mapper
            $mapperPath = $entityMapperDir.'/'.$shortEntityClass.'Mapper.php';
            if (! $this->filesystem->exists($mapperPath)) {
                $this->filesystem->dumpFile(
                    $mapperPath,
                    $this->generateMapper->createMapper($mapperNamespace, $shortEntityClass, $entityFqcn, $metadata)
                );
                $io->success(sprintf('Mapper généré : %s', $mapperPath));
            } else {
                $io->note(sprintf('Mapper déjà présent, ignoré : %s', $mapperPath));
            }

            // Export metadata JSON (serializable)
            $metaExport[$entityFqcn] = [
                'table' => $metadata->getTableName(),
                'identifier' => $metadata->getIdentifierFieldNames(),
                'fields' => array_values($metadata->getFieldNames()),
                'associations' => array_values(array_map(
                    function ($m) {
                        $m = $this->helpers->normalizeAssociationMapping($m);

                        return [
                            'fieldName' => $m['fieldName'] ?? null,
                            'type' => $m['type'] ?? null,
                            'targetEntity' => $m['targetEntity'] ?? null,
                            'mappedBy' => $m['mappedBy'] ?? null,
                            'inversedBy' => $m['inversedBy'] ?? null,
                            'joinColumns' => $m['joinColumns'] ?? null,
                        ];
                    },
                    $metadata->getAssociationMappings()
                )),
            ];

            $io->newLine();
        }
        // Génération du Bruno Collection JSON
        $brunoCollectionJson = $this->bruno->generateBrunoCollection($metaExport);
        file_put_contents(
            $this->kernel->getProjectDir().'/bruno/bruno-collection-scaffold.json',
            $brunoCollectionJson
        );
        file_put_contents(
            $this->kernel->getProjectDir().'/metaData/classMetadata.json',
            json_encode($metaExport, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
        file_put_contents(
            $this->kernel->getProjectDir().'/metaData/allMetadata.json',
            json_encode($allMetadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        $io->success('Scaffold API (Resource + DTO + Provider + Processor) généré pour toutes les entités Doctrine.');

        return Command::SUCCESS;
    }
}
