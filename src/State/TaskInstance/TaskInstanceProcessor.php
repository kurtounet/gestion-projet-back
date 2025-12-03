<?php

declare(strict_types=1);

namespace App\State\TaskInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\TaskInstance;
use App\Dto\TaskInstance\TaskInstanceCreateDto;
use App\Dto\TaskInstance\TaskInstanceUpdateDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
/**
 * Processor pour TaskInstance.
 *
 * À brancher sur la ressource :
 * #[ApiResource(processor: TaskInstanceProcessor::class)]
 */
final class TaskInstanceProcessor implements ProcessorInterface
{

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface $persistProcessor,

        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private readonly ProcessorInterface $removeProcessor,
    ) {}


    /**
     * @param TaskInstance|mixed $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // Cas DELETE : on délègue au remove_processor
        if ($operation instanceof Delete) {
            $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            return null;
        }

        // Création: Dans operation POST -> DTO Create dans l'entité
        if ($operation instanceof Post && $data instanceof TaskInstanceCreateDto) {
            // Ici, tu vas chercher les relations à partir des *Id :
            /*
            $status = $this->em->getRepository(Status::class)->find($data->statusId);
            $comment = $this->em->getRepository(Comment::class)->find($data->commentId);
            $priority = $this->em->getRepository(Priority::class)->find($data->priorityId);
            $projectTemplate = $this->em->getRepository(ProjectTemplate::class)->find($data->projectTemplateId);

            $entity = new TaskInstance();
            $entity->setName($data->name);
            $entity->setDescription($data->description);
            $entity->setStartDate($data->startDate);
            $entity->setEndDate($data->endDate);

            $entity->setStatus($status);
            $entity->setPriority($priority);
            $entity->setProjectTemplate($projectTemplate);
            $entity->setComment($comment);

            $this->em->persist($entity);
            $this->em->flush();

            return $entity;
            */
        }

        // Mise à jour PATCH/PUT si tu as un DTO Update
        // if ($operation instanceof Patch || $operation instanceof Put && $data instanceof TaskInstanceUpdateDto) {
        //     $entity = $this->em->getRepository(TaskInstance::class)->find($data->id);
        //     $entity->setName($data->name);
        //     $entity->setDescription($data->description);
        //     $entity->setStartDate($data->startDate);
        //     $entity->setEndDate($data->endDate);
        //     $this->em->persist($entity);
        //     $this->em->flush();
        //     return $entity;
        // }

        // Cas où $data est déjà une entité, on peut faire :
        // if ($data instanceof TaskInstance) {
        //     $this->em->persist($data);
        //     $this->em->flush();

        //     return $data;
        // }

        return $data;
    }
}
