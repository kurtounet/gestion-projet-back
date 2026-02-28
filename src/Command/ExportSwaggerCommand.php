<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:export-swagger',
    description: 'Exporte la documentation OpenAPI interactivement.',
)]
class ExportSwaggerCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Exportateur OpenAPI');

        // 1. Choix du format
        $format = $io->choice(
            'Dans quel format souhaites-tu exporter la doc ?',
            ['json', 'yaml'],
            'json'
        );

        // 2. Nom du fichier
        $filename = $io->ask('Nom du fichier de sortie ?', "swagger.$format");

        // 3. Préparation des arguments pour la commande native
        $command = $this->getApplication()->find('api:openapi:export');

        $arguments = [
            '--output' => $filename,
        ];

        // Si l'utilisateur a choisi YAML, on ajoute le flag --yaml
        if ('yaml' === $format) {
            $arguments['--yaml'] = true;
        }

        $arrayInput = new ArrayInput($arguments);

        $io->note('Génération en cours...');

        try {
            $command->run($arrayInput, $output);
            $io->success("Terminé ! Fichier disponible ici : $filename");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Erreur : '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
