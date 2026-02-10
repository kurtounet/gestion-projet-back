<?php

namespace App\DataFixtures;

use App\Entity\CodeBase;
use App\Entity\Comment;
use App\Entity\Context;
use App\Entity\ContextStatus;
use App\Entity\Feature;
use App\Entity\File;
use App\Entity\Framework;
use App\Entity\Notification;
use App\Entity\Priority;
use App\Entity\ProjectInstance;
use App\Entity\ProjectTemplate;
use App\Entity\ProjectTemplateSprintTemplate;
use App\Entity\SprintInstance;
use App\Entity\SprintTask;
use App\Entity\SprintTemplate;
use App\Entity\Status;
use App\Entity\TaskInstance;
use App\Entity\TaskTemplate;
use App\Entity\Technology;
use App\Entity\TypeTask;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Stockage des entités créées pour les relations
        $contexts = [];
        $statuses = [];
        $priorities = [];
        $users = [];
        $features = [];
        $technologies = [];
        $codeBases = [];
        $typeTasks = [];
        $projectTemplates = [];
        $sprintTemplates = [];
        $taskTemplates = [];
        $projectInstances = [];
        $sprintInstances = [];
        $taskInstances = [];
        $comments = [];

        $contextData = [
            'Développement',
            'Test',
            'Production',
            'Staging',
            'Intégration',
            'Recette',
            'Pré-production',
            'Démo',
            'Formation',
            'Maintenance',
            'Migration',
            'Backup',
            'Monitoring',
            'Sécurité',
            'Performance',
            'Qualité',
            'Documentation',
            'Support',
            'Recherche',
            'Innovation',
            'Prototype',
            'Beta',
            'Alpha',
            'Release',
            'Hotfix',
            'Feature',
            'Bugfix',
            'Refactoring',
            'Optimisation',
            'Audit',
        ];

        foreach ($contextData as $index => $label) {
            $context = new Context();
            $context->setContextLabel($label);
            $manager->persist($context);
            $contexts[$index] = $context;
        }
        $manager->flush();

        $statusData = [
            'À faire',
            'En cours',
            'Terminé',
            'En attente',
            'Bloqué',
            'En revue',
            'Validé',
            'Rejeté',
            'Annulé',
            'Reporté',
            'En test',
            'Testé',
            'Déployé',
            'En production',
            'Archivé',
            'Suspendu',
            'En pause',
            'Priorisé',
            'Planifié',
            'Non planifié',
            'En analyse',
            'Analysé',
            'En conception',
            'Conçu',
            'En développement',
            'Développé',
            'En intégration',
            'Intégré',
            'En validation',
            'Validé client',
        ];

        foreach ($statusData as $index => $label) {
            $status = new Status();
            $status->setLabel($label)
                ->setContext($contexts[$index % count($contexts)]);
            $manager->persist($status);
            $statuses[$index] = $status;
        }
        $manager->flush();

        $priorityData = [
            [
                'label' => 'Normale',
                'color' => '#2196F3',
                'priority_number' => 0,
            ],
            [
                'label' => 'Très haute',
                'color' => '#F44336',
                'priority_number' => 8,
            ],
            [
                'label' => 'Haute',
                'color' => '#FF5722',
                'priority_number' => 7,
            ],
            [
                'label' => 'Moyenne',
                'color' => '#FF9800',
                'priority_number' => 6,
            ],
            [
                'label' => 'Basse',
                'color' => '#FFC107',
                'priority_number' => 5,
            ],
            [
                'label' => 'Très basse',
                'color' => '#CDDC39',
                'priority_number' => 4,
            ],
            [
                'label' => 'Mineure',
                'color' => '#8BC34A',
                'priority_number' => 3,
            ],
            [
                'label' => 'Majeure',
                'color' => '#4CAF50',
                'priority_number' => 1,
            ],
            [
                'label' => 'Critique',
                'color' => '#D32F2F',
                'priority_number' => 9,
            ],
        ];
        foreach ($priorityData as $index => $priority) {
            $p = new Priority();
            $p->setLabel($priority['label'])
                ->setColor($priority['color'])
                ->setPriorityNumber($priority['priority_number']);
            $manager->persist($p);
            $priorities[$index] = $p;
        }
        $manager->flush();

        $userRoles = [['ROLE_ADMIN'], ['ROLE_USER'], ['ROLE_MANAGER'], ['ROLE_DEVELOPER'], ['ROLE_TESTER']];
        foreach ($userRoles as $i => $role) {
            $user = new User();
            $user->setEmail(str_replace('role_', '', strtolower($role[0])).'@gmail.com')
                ->setFirstName("User {$i}")
                ->setLastName("User {$i}")
                ->setRoles($role)
                ->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
            $manager->persist($user);
            $users[] = $user;
        }
        $manager->flush();

        $featureData = [
            'Authentification',
            'API REST',
            'Dashboard',
            'Reporting',
            'Notifications',
            'Gestion utilisateurs',
            'Gestion projets',
            'Gestion tâches',
            'Calendrier',
            'Messagerie',
            'Export PDF',
            'Import CSV',
            'Recherche avancée',
            'Filtres',
            'Tri',
            'Pagination',
            'Cache',
            'Logs',
            'Monitoring',
            'Analytics',
            'Backup',
            'Restore',
            'Migration',
            'Versioning',
            'Audit',
            'Sécurité',
            'Performance',
            'Optimisation',
            'Documentation',
            'Tests',
        ];

        foreach ($featureData as $label) {
            $feature = new Feature();
            $feature->setLabel($label);
            $manager->persist($feature);
            $features[] = $feature;
        }
        $manager->flush();

        $techData = [
            'PHP',
            'TypeScript',
            'JavaScript',
            'Python',
            'Java',
            'C#',
            '.NET',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'Redis',
            'Docker',
            'Git',
            'Jenkins',
            'GitLab CI',
            'GitHub Actions',
        ];
        foreach ($techData as $label) {
            $tech = new Technology();
            $tech->setLabel($label);
            $manager->persist($tech);
            $technologies[$label] = $tech;
        }

        $frameworksData = [
            [
                'label' => 'Symfony',
                'type' => 'backend',
                'version' => '7.4',
                'description' => '',
                'configuration' => [],
                'icon' => 'https://symfony.com/favicon.ico',
                'color' => '#000000',
                'url' => 'https://symfony.com/',
                'technology' => $technologies['PHP'],
            ],
            [
                'label' => 'Angular',
                'type' => 'frontend',
                'version' => '21.0',
                'description' => '',
                'configuration' => [],
                'icon' => 'https://angular.io/favicon.ico',
                'color' => '#C3002F',
                'url' => 'https://angular.io/',
                'technology' => $technologies['TypeScript'],
            ],
            [
                'label' => 'Vue.js',
                'type' => 'frontend',
                'version' => '3.0',
                'description' => '',
                'configuration' => [],
                'icon' => 'https://vuejs.org/favicon.ico',
                'color' => '#41B883',
                'url' => 'https://vuejs.org/',
                'technology' => $technologies['TypeScript'],
            ],
            [
                'label' => 'Nuxt',
                'type' => 'frontend',
                'version' => '4.0',
                'description' => '',
                'configuration' => [],
                'icon' => 'https://nuxtjs.org/favicon.ico',
                'color' => '#41B883',
                'url' => 'https://nuxtjs.org/',
                'technology' => $technologies['TypeScript'],
            ],
        ];

        $frameworks = [];
        foreach ($frameworksData as $index => $framework) {
            $f = new Framework();
            $f->setLabel($framework['label'])
                ->setType($framework['type'])
                ->setVersion($framework['version'])
                ->setDescription($framework['description'])
                ->setIcon($framework['icon'])
                ->setColor($framework['color'])
                ->setTechnology($framework['technology'])
                ->setConfiguration($framework["configuj'airation"]);
            $manager->persist($f);
            $frameworks[$index] = $f;
        }
        $manager->flush();

        for ($i = 1; $i <= 30; ++$i) {
            $codeBase = new CodeBase();
            $codeBase->setLabel("CodeBase {$i}");
            $codeBase->setCode("codebase-{$i}");
            $codeBase->setPathFile("/src/codebase-{$i}");
            $codeBase->setFeature($features[($i - 1) % count($features)]->getLabel());
            $manager->persist($codeBase);
            $codeBases[] = $codeBase;
        }
        $manager->flush();

        $typeTaskNames = [
            'Développement',
            'Test',
            'Bug',
            'Feature',
            'Refactoring',
            'Documentation',
            'Review',
            'Deploy',
            'Maintenance',
            'Support',
        ];
        for ($i = 1; $i <= 30; ++$i) {
            $typeTask = new TypeTask();
            $typeTask->setCode($codeBases[($i - 1) % count($codeBases)])
                ->setName($typeTaskNames[($i - 1) % count($typeTaskNames)]." {$i}")
                ->setPathFileScript("/scripts/task-{$i}.sh")
                ->setDescription("Description pour type de tâche {$i}")
                ->setAutomatique(0 === $i % 2);
            $manager->persist($typeTask);
            $typeTasks[] = $typeTask;
        }
        $manager->flush();

        for ($i = 1; $i <= 30; ++$i) {
            $projectTemplate = new ProjectTemplate();
            $projectTemplate->setName("Template Projet {$i}");
            $projectTemplate->setDescription("Description du template de projet {$i}");
            $projectTemplate->setDuration(30 + ($i * 10)); // Entre 40 et 330 jours
            $manager->persist($projectTemplate);
            $projectTemplates[] = $projectTemplate;
        }
        $manager->flush();

        for ($i = 1; $i <= 30; ++$i) {
            $sprintTemplate = new SprintTemplate();
            $sprintTemplate->setName("Sprint Template {$i}");
            $sprintTemplate->setDescription("Description du sprint template {$i}");
            $sprintTemplate->setDuration(7 + ($i % 4) * 7); // 7, 14, 21 ou 28 jours
            $manager->persist($sprintTemplate);
            $sprintTemplates[] = $sprintTemplate;
        }
        $manager->flush();

        for ($i = 1; $i <= 30; ++$i) {
            $taskTemplate = new TaskTemplate();
            $taskTemplate->setSprintTemplate($sprintTemplates[($i - 1) % count($sprintTemplates)]);
            $taskTemplate->setName("Task Template {$i}");
            $taskTemplate->setDescription("Description de la tâche template {$i}");
            $taskTemplate->setParentTask(0);
            $taskTemplate->setTypeTask($typeTasks[($i - 1) % count($typeTasks)]);
            $manager->persist($taskTemplate);
            $taskTemplates[] = $taskTemplate;
        }
        $manager->flush();

        for ($i = 1; $i <= 30; ++$i) {
            $ptst = new ProjectTemplateSprintTemplate();
            $ptst->setProjectTemplate($projectTemplates[($i - 1) % count($projectTemplates)]);
            $ptst->setSprintTemplate($sprintTemplates[($i - 1) % count($sprintTemplates)]);
            $ptst->setSprintOrder($i);
            $manager->persist($ptst);
        }
        $manager->flush();

        for ($i = 1; $i <= 30; ++$i) {
            $sprintTask = new SprintTask();
            $sprintTask->setSprintTemplate($sprintTemplates[($i - 1) % count($sprintTemplates)]);
            $sprintTask->setTaskTemplate($taskTemplates[($i - 1) % count($taskTemplates)]);
            $sprintTask->setTaskOrder($i);
            $manager->persist($sprintTask);
        }
        $manager->flush();

        for ($i = 1; $i <= 10; ++$i) {
            $projectInstance = new ProjectInstance();
            $projectInstance->setStatus($statuses[($i - 1) % count($statuses)])
                ->setName("Projet {$i}")
                ->setPathProject("/projet-{$i}")
                ->setPathFileDatabase("/projet-{$i}")
                ->setDescription("Description du projet instance {$i}")
                ->setIcon("icon-{$i}")
                ->setColor('#'.dechex(rand(0x000000, 0xFFFFFF)))
                ->setIsFavory(0 === $i % 2)
                ->setPosition($i)
                ->setStartDate(new \DateTimeImmutable("-{$i} days"))
                ->setEndDate(new \DateTimeImmutable('+'.(60 + $i).' days'))
                ->setPriority($priorities[($i - 1) % count($priorities)])
                ->setProjectTemplate($projectTemplates[($i - 1) % count($projectTemplates)])
                ->setStatus($statuses[($i - 1) % count($statuses)]);

            $manager->persist($projectInstance);
            $projectInstances[] = $projectInstance;
        }
        $manager->flush();

        foreach ($projectInstances as $projectInstance) {
            for ($s = 1; $s <= 10; ++$s) {
                $sprintInstance = new SprintInstance();
                $sprintInstance->setProjectInstance($projectInstance)
                    ->setPriority($priorities[($s - 1) % count($priorities)])
                    ->setSprintTemplate($sprintTemplates[($s - 1) % count($sprintTemplates)]);
                if ($s > 1) {
                    $sprintInstance->setSprintDependency($sprintInstances[($s - 2) % count($sprintInstances)]);
                }
                $sprintInstance->setName('Sprint '.$s.' du '.$projectInstance->getName())
                    ->setDescription('Sprint '.$s.' du '.$projectInstance->getName())
                    ->setStartDate(new \DateTimeImmutable('-'.($s * 2).' days'))
                    ->setEndDate(new \DateTimeImmutable('-'.($s * 2 - 14).' days'))
                    ->setStatus($statuses[($s - 1) % count($statuses)])
                    ->setIcon("icon-{$s}")
                    ->setColor('#'.dechex(rand(0x000000, 0xFFFFFF)))
                    ->setPosition($s);
                $manager->persist($sprintInstance);
                $sprintInstances[] = $sprintInstance;

                for ($t = 1; $t <= 10; ++$t) {
                    $taskInstance = new TaskInstance();
                    $taskInstance->setUser($users[array_rand($users)])
                        ->setTaskTemplate($taskTemplates[($t - 1) % count($taskTemplates)])
                        ->setSprintInstance($sprintInstance)
                        ->setPriority($priorities[($t - 1) % count($priorities)])
                        ->setStatus($statuses[($t - 1) % count($statuses)])
                        ->setTypeTask($typeTasks[($t - 1) % count($typeTasks)])
                        ->setName("Task {$t} du ".$sprintInstance->getName())
                        ->setDescription("Task {$t} du ".$sprintInstance->getName())
                        ->setStartDate(new \DateTimeImmutable('-'.($t + 5).' days'))
                        ->setDueDate(new \DateTimeImmutable('+'.(10 - $t % 10).' days'))
                        ->setIcon("icon-{$t}")
                        ->setColor('#'.dechex(rand(0x000000, 0xFFFFFF)))
                        ->setPosition($t);
                    $manager->persist($taskInstance);
                    $taskInstances[] = $taskInstance;
                }
            }
        }

        // 17. Créer les Comments (30 items)
        $commentSubjects = ['Avancement', 'Problème', 'Question', 'Suggestion', 'Validation', 'Information', 'Alerte', 'Résolution', 'Mise à jour', 'Feedback'];
        for ($i = 1; $i <= 30; ++$i) {
            $comment = new Comment();
            $comment->setTask($taskInstances[($i - 1) % count($taskInstances)]);
            $comment->setUser($users[($i - 1) % count($users)]);
            $comment->setSubject($commentSubjects[($i - 1) % count($commentSubjects)]." {$i}");
            $comment->setContent("Contenu du commentaire {$i} avec des détails supplémentaires.");
            $manager->persist($comment);
            $comments[] = $comment;
        }

        // Mise à jour des commentaires dans les entités (seulement pour les 30 premiers)
        // for ($i = 0; $i < min(30, count($comments)); $i++) {
        //     if ($i < count($projectInstances)) {
        //         $projectInstances[$i]->setComment($comments[$i]);
        //     }
        //     if ($i < count($sprintInstances)) {
        //         $sprintInstances[$i]->setComment($comments[$i]);
        //     }
        //     if ($i < count($taskInstances)) {
        //         $taskInstances[$i]->setComment($comments[$i]);
        //     }
        // }

        // 18. Créer les Notifications (30 items)
        $notificationTypes = ['info', 'warning', 'error', 'success', 'task', 'message', 'alert', 'reminder', 'update', 'system'];
        for ($i = 1; $i <= 30; ++$i) {
            $notification = new Notification();
            $notification->setUser($users[($i - 1) % count($users)]);
            $notification->setMessage("Notification {$i} : Message important pour l'utilisateur");
            $notification->setDate(new \DateTimeImmutable('-'.($i * 3).' hours'));
            $notification->setType($notificationTypes[($i - 1) % count($notificationTypes)]);
            $manager->persist($notification);
        }

        // 19. Créer les Files (30 items)
        $fileTypes = ['pdf', 'png', 'jpg', 'doc', 'xls', 'txt', 'zip', 'csv', 'json', 'xml'];
        for ($i = 1; $i <= 30; ++$i) {
            $file = new File();
            $file->setPath("/uploads/files/file-{$i}.".$fileTypes[($i - 1) % count($fileTypes)]);
            $file->setKeyWord("keyword{$i},tag{$i},category".($i % 5));
            $manager->persist($file);
        }

        // 20. Créer les ContextStatus (30 items)
        for ($i = 1; $i <= 30; ++$i) {
            $contextStatus = new ContextStatus();
            $contextStatus->setContext($contexts[($i - 1) % count($contexts)]);
            $contextStatus->setStatus($statuses[($i - 1) % count($statuses)]);
            $manager->persist($contextStatus);
        }

        $manager->flush();
    }
}
