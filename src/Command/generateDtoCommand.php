<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:make:dto',
    description: 'Génère une classe DTO avec les contraintes de validation Symfony'
)]
class generateDtoCommand extends Command
{
    public function __construct(
        private readonly KernelInterface $kernel,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Nom de la classe DTO (ex: CreateUserDto)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $dtoName = (string) $input->getArgument('name');
        $projectDir = $this->kernel->getProjectDir();
        $io->title(sprintf('Génération du DTO "%s"', $dtoName));

        $fields = [];

        $io->writeln('Définition des champs du DTO :');
        $io->writeln('Pour chaque champ : nom, type PHP, nullable ou non, attributs de validation.');
        $io->newLine();

        while (true) {
            $name = $io->ask('Nom du champ (laisser vide pour terminer)');
            if (! $name) {
                break;
            }

            $type = $io->ask('Type PHP (string, int, bool, float, DateTimeInterface, etc.)', 'string');

            $nullable = $io->confirm('Champ nullable ?', false);

            $io->writeln('Déclare les attributs de validation sous forme prête à coller, par ex :');
            $io->writeln('  #[Assert\NotBlank]');
            $io->writeln('  #[Assert\Length(min: 3, max: 50)]');
            $io->writeln('Laisse vide pour finir la liste des contraintes.');
            $io->newLine();

            $constraints = [];
            while (true) {
                $constraintLine = $io->ask('Attribut de validation (vide pour terminer pour ce champ)');
                if (! $constraintLine) {
                    break;
                }

                // Normalisation simple : si l’utilisateur n’a pas mis "#[...]", on l’entoure
                $constraintLine = trim($constraintLine);
                if (! str_starts_with($constraintLine, '#[')) {
                    $constraintLine = '#[Assert\\'.ltrim($constraintLine, '\\').']';
                }

                $constraints[] = $constraintLine;
            }

            $fields[] = [
                'name' => $name,
                'type' => $type,
                'nullable' => $nullable,
                'constraints' => $constraints,
            ];

            $io->success(sprintf('Champ "%s" ajouté.', $name));
            $io->newLine();
        }

        if (empty($fields)) {
            $io->warning('Aucun champ défini. Annulation.');

            return Command::INVALID;
        }

        $dtoCode = $this->generateDtoCode($dtoName, $fields);

        $dtoDir = $projectDir.'/src/Dto';
        if (! is_dir($dtoDir) && ! mkdir($dtoDir, 0o775, true) && ! is_dir($dtoDir)) {
            $io->error(sprintf('Impossible de créer le répertoire "%s".', $dtoDir));

            return Command::FAILURE;
        }

        $filePath = $dtoDir.'/'.$dtoName.'.php';
        if (file_exists($filePath)) {
            if (! $io->confirm(sprintf('Le fichier "%s" existe déjà, l’écraser ?', $filePath), false)) {
                $io->warning('Génération annulée.');

                return Command::INVALID;
            }
        }

        file_put_contents($filePath, $dtoCode);

        $io->success(sprintf('DTO généré : %s', $filePath));

        return Command::SUCCESS;
    }

    /**
     * @param array<int, array{name:string,type:string,nullable:bool,constraints:string[]}> $fields
     */
    private function generateDtoCode(string $dtoName, array $fields): string
    {
        $namespace = 'App\\Dto';

        $props = [];
        foreach ($fields as $field) {
            $type = $field['type'];
            $nullable = $field['nullable'];
            $phpType = $nullable ? '?'.$type : $type;
            $default = $nullable ? ' = null' : '';
            $lineParts = [];

            foreach ($field['constraints'] as $constraint) {
                $lineParts[] = '        '.$constraint;
            }

            $lineParts[] = sprintf('        public %s $%s%s,', $phpType, $field['name'], $default);

            $props[] = implode("\n", $lineParts);
        }

        $propsBlock = implode("\n\n", $props);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use Symfony\Component\Validator\Constraints as Assert;

final class {$dtoName}
{
    public function __construct(
{$propsBlock}
    ) {
    }
}

PHP;
    }
}
