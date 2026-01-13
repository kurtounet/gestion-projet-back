<?php

namespace App\ApiResource\State\Framework;

use App\Entity\Framework;
use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\ApiResource\Service\IriFromResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\ApiResource\Dto\Framework\FrameworkItemDto;
use App\Entity\ConfigProjectFramework;
use App\Entity\Technology;


final readonly class FrameworkCreateProcessor implements ProcessorInterface
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
        if (!($operation instanceof Post) || !($data instanceof FrameworkCreateDto)) {
            return $data;
        }

        // Créer et mapper l'entité depuis le DTO
        $entity = $this->mapDtoToEntity($data);

        // Persister l'entité
        $this->persistProcessor->process($entity, $operation, $uriVariables, $context);

        // Retourner le DTO pour l'output
        return $this->entityToDto($entity);

    }

    private function mapDtoToEntity(FrameworkCreateDto $dto): Framework
    {
        $entity = new Framework();

            $entity->setName($dto->name);

            $entity->setVersion($dto->version);

            $entity->setConfiguration($dto->configuration);

            $entity->setIcon($dto->icon);

            $entity->setColor($dto->color);
// TODO: Relations ToOne
            $entity->setTechnology($dto->technology);
// TODO: Relations ToMany
        // technology (ToMany => array of IRIs)
        $entity->setTechnology($this->resolveIri($dto->technology ?? null, Technology::class, 'technology', required: false));

        return $entity;
    }

    private function entityToDto(Framework $entity): FrameworkItemDto
    {
        $dto = new FrameworkItemDto();


             $dto->id = $entity->getId();
             $dto->name = $entity->getName();
             $dto->version = $entity->getVersion();
             $dto->configuration = $entity->getConfiguration();
             $dto->icon = $entity->getIcon();
             $dto->color = $entity->getColor();
// TODO: Relations ToOne
        // technology (ToOne => IRI)
        $dto->technology = $entity->getTechnology()
            ? ($this->iriFromResource)(Technology::class,$entity->getTechnology()->getId())
            : null;
// TODO: Relations ToMany
        // ConfigProjectFramework (ToMany => array of IRIs)
        $dto->configprojectframework = $this->toIriList($entity->getConfigProjectFramework(), ConfigProjectFramework::class);

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
