<?php

namespace App\ApiResource\State\SprintTask;

use App\Entity\SprintTask;
use App\ApiResource\Dto\SprintTask\SprintTaskCreateDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\ApiResource\Dto\SprintTask\SprintTaskItemDto;
use App\Entity\SprintTemplate;
use App\Entity\TaskTemplate;


final readonly class SprintTaskCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriConverterInterface $iriConverter,
        private IriFromResource $iriFromResource,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Post) || !($data instanceof SprintTaskCreateDto)) {
            return $data;
        }

        // Créer et mapper l'entité depuis le DTO
        $entity = $this->mapDtoToEntity($data);

        // Persister l'entité
        $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        // Retourner le DTO pour l'output
        return $this->entityToDto($entity);

    }

    private function mapDtoToEntity(SprintTaskCreateDto $dto): SprintTask
    {
        $entity = new SprintTask();

            $entity->setTaskOrder($dto->taskOrder);

            $entity->setCreatedAt($dto->createdAt);

            $entity->setUpdatedAt($dto->updatedAt);
// TODO: Relations ToOne
            $entity->setSprintTemplate($dto->sprintTemplate);

            $entity->setTaskTemplate($dto->taskTemplate);
// TODO: Relations ToMany
        // sprinttemplate (ToMany => array of IRIs)
        $entity->setSprintTemplate($this->resolveIri($dto->sprinttemplate ?? null, SprintTemplate::class, 'sprinttemplate', required: true));
        // tasktemplate (ToMany => array of IRIs)
        $entity->setTaskTemplate($this->resolveIri($dto->tasktemplate ?? null, TaskTemplate::class, 'tasktemplate', required: true));

        return $entity;
    }

    private function entityToDto(SprintTask $entity): SprintTaskItemDto
    {
        $dto = new SprintTaskItemDto();


             $dto->id = $entity->getId();
             $dto->taskOrder = $entity->getTaskOrder();
             $dto->createdAt = $entity->getCreatedAt();
             $dto->updatedAt = $entity->getUpdatedAt();
// TODO: Relations ToOne
        // sprinttemplate (ToOne => IRI)
        $dto->sprinttemplate = $entity->getSprinttemplate()
            ? ($this->iriFromResource)(SprintTemplate::class,$entity->getSprinttemplate()->getId())
            : null;
        // tasktemplate (ToOne => IRI)
        $dto->tasktemplate = $entity->getTasktemplate()
            ? ($this->iriFromResource)(TaskTemplate::class,$entity->getTasktemplate()->getId())
            : null;
// TODO: Relations ToMany


        return $dto;

    }
        private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (!is_object($item)) {
                continue;
            }

            $iri = ($this->iriFromResource)($resourceClass, $item->getId());
            if (null !== $iri) {
                $iris[] = $iri;
            }
        }

        return $iris;
    }
        private function resolveIri(?string $iri, string $expectedClass, string $field, bool $required = false): ?object
    {
        if ($iri === null || $iri === '') {
            if ($required) {
                throw new BadRequestHttpException(sprintf(
                    'Field "%s" is required and must be a non-empty IRI string.',
                    $field
                ));
            }

            // OPTIONNEL => on retourne null (et on ne throw pas)
            return null;
        }

        try {
            $resource = $this->iriConverter->getResourceFromIri($iri);
        } catch (\Throwable $e) {
            throw new BadRequestHttpException(sprintf('Invalid IRI for field "%s".', $field), $e);
        }

        // 1) Si l’IRI te donne déjà l’Entity attendue, parfait
        if ($resource instanceof $expectedClass) {
            return $resource;
        }

        // 2) Sinon, on tente de récupérer l’ID depuis l’objet ressource
        $id = null;
        if (is_object($resource) && property_exists($resource, 'id')) {
            $id = $resource->id;
        }

        // 3) Fallback: extraire l’ID de la fin de l’IRI (/api/statuses/121)
        if ($id === null && preg_match('~/(\d+)$~', $iri, $m)) {
            $id = (int) $m[1];
        }

        if ($id === null) {
            throw new BadRequestHttpException(sprintf(
                'Invalid IRI type for field "%s". Expected "%s".',
                $field,
                $expectedClass
            ));
        }

        $entity = $this->em->getRepository($expectedClass)->find($id);

        if (!$entity) {
            throw new BadRequestHttpException(sprintf(
                'Resource not found for field "%s" (id: %s).',
                $field,
                (string) $id
            ));
        }

        return $entity;
    }

}
