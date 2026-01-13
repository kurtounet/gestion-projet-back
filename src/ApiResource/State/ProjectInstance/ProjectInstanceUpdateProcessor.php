<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Status;
use App\Entity\Priority;
use App\Entity\ProjectTemplate;
use App\Entity\Comment;
use App\Entity\SprintInstance;
use App\Entity\ConfigProjectFramework;



final readonly class ProjectInstanceUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private IriConverterInterface $iriConverter,
         private IriFromResource $iriFromResource,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!($operation instanceof Patch) || !($data instanceof ProjectInstanceUpdateDto)) {
            return $data;
        }

        $id = $uriVariables['id'] ?? null;
        if (!is_string($id) && !is_int($id)) {
            throw new \InvalidArgumentException('Missing "id" uriVariable for PATCH.');
        }

        $entity = $this->em->getRepository(ProjectInstance::class)->find($id);
        if (!$entity instanceof ProjectInstance) {
            throw new \RuntimeException(sprintf('Entity %s#%s not found.', ProjectInstance::class, (string) $id));
        }

            $entity->setName($data->name);

            $entity->setPathFileDatabase($data->pathFileDatabase);

            $entity->setPathProject($data->pathProject);

            $entity->setDescription($data->description);

            $entity->setIcon($data->icon);

            $entity->setColor($data->color);

            $entity->setIsFavory($data->isFavory);

            $entity->setPosition($data->position);

            $entity->setStartDate($data->startDate);

            $entity->setEndDate($data->endDate);

            $entity->setCreatedByUser($data->createdByUser);

            $entity->setUpdatedByUser($data->updatedByUser);

            $entity->setCreatedAt($data->createdAt);

            $entity->setUpdatedAt($data->updatedAt);

            $entity->setStatus($data->status);

            $entity->setPriority($data->priority);

            $entity->setProjectTemplate($data->projectTemplate);

            $entity->setComment($data->comment);

            $entity->setParent($data->parent);

            $entity->setConfigFramework($data->configFramework);

        // sprintinstance (ToMany => array of IRIs)
        $entity->setSprintInstance($this->resolveIri($dto->sprintinstance ?? null, SprintInstance::class, 'sprintinstance', required: true));
        // projectinstance (ToMany => array of IRIs)
        $entity->setProjectInstance($this->resolveIri($dto->projectinstance ?? null, ProjectInstance::class, 'projectinstance', required: true));


        // $this->em->persist($entity);
        // $this->em->flush();
        // Persister l'entité
        return $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
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