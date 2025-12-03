<?php

declare(strict_types=1);

namespace App\State\Feature;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Feature;
use App\Dto\Feature\FeatureCreateDto;
use App\Dto\Feature\FeatureUpdateDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
/**
 * Processor pour Feature.
 *
 * À brancher sur la ressource :
 * #[ApiResource(processor: FeatureProcessor::class)]
 */
final class FeatureProcessor implements ProcessorInterface
{

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface $persistProcessor,

        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private readonly ProcessorInterface $removeProcessor,
    ) {}


    /**
     * @param Feature|mixed $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // Cas DELETE : on délègue au remove_processor
        if ($operation instanceof Delete) {
            $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            return null;
        }

        // Création: Dans operation POST -> DTO Create dans l'entité
        if ($operation instanceof Post && $data instanceof FeatureCreateDto) {
            // Ici, tu vas chercher les relations à partir des *Id :
            /*
            $status = $this->em->getRepository(Status::class)->find($data->statusId);
            $comment = $this->em->getRepository(Comment::class)->find($data->commentId);
            $priority = $this->em->getRepository(Priority::class)->find($data->priorityId);
            $projectTemplate = $this->em->getRepository(ProjectTemplate::class)->find($data->projectTemplateId);

            $entity = new Feature();
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
        // if ($operation instanceof Patch || $operation instanceof Put && $data instanceof FeatureUpdateDto) {
        //     $entity = $this->em->getRepository(Feature::class)->find($data->id);
        //     $entity->setName($data->name);
        //     $entity->setDescription($data->description);
        //     $entity->setStartDate($data->startDate);
        //     $entity->setEndDate($data->endDate);
        //     $this->em->persist($entity);
        //     $this->em->flush();
        //     return $entity;
        // }

        // Cas où $data est déjà une entité, on peut faire :
        // if ($data instanceof Feature) {
        //     $this->em->persist($data);
        //     $this->em->flush();

        //     return $data;
        // }

        return $data;
    }
}
