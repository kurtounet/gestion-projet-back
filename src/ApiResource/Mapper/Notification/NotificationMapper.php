<?php

namespace App\ApiResource\Mapper\Notification;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\Notification\NotificationCreateDto;
use App\ApiResource\Dto\Notification\NotificationUpdateDto;
use App\ApiResource\Resource\Notification\NotificationResource;
use App\ApiResource\Resource\User\UserResource;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NotificationMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(Notification $entity): NotificationResource
    {
        $dto = new NotificationResource();
        $dto->id = $entity->getId();
        $dto->message = $entity->getMessage();
        $dto->date = $entity->getDate();
        $dto->type = $entity->getType();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(UserResource::class, $entity->getUser()->getId())
            : null;


        return $dto;
    }

    public function entityToCollectionDto(Notification $entity): NotificationResource
    {
        $dto = new NotificationResource();
        $dto->id = $entity->getId();
        $dto->message = $entity->getMessage();
        $dto->date = $entity->getDate();
        $dto->type = $entity->getType();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(UserResource::class, $entity->getUser()->getId())
            : null;


        return $dto;
    }

    public function createDtoToEntity(NotificationCreateDto $dto): Notification
    {
        $entity = new Notification();
        if (null !== $dto->message) {
            $entity->setMessage($dto->message);
        }
        if (null !== $dto->date) {
            $entity->setDate($dto->date);
        }
        if (null !== $dto->type) {
            $entity->setType($dto->type);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->user) {
            $entity->setUser($this->resolveIri($dto->user ?? null, \App\Entity\User::class, 'user', required: true));
        }



        return $entity;



    }

    public function updateDtoToEntity(Notification $entity, NotificationUpdateDto $dto): Notification
    {
        if (null !== $dto->message) {
            $entity->setMessage($dto->message);
        }
        if (null !== $dto->date) {
            $entity->setDate($dto->date);
        }
        if (null !== $dto->type) {
            $entity->setType($dto->type);
        }
        if (null !== $dto->createdAt) {
            $entity->setCreatedAt($dto->createdAt);
        }
        if (null !== $dto->updatedAt) {
            $entity->setUpdatedAt($dto->updatedAt);
        }
        if (null !== $dto->user) {
            $entity->setUser($this->resolveIri($dto->user ?? null, \App\Entity\User::class, 'user', required: true));
        }


        return $entity;
    }

    /*
    public function mapEntityToCreateDto(Notification $entity): NotificationCreateDto
    {
               $dto = new NotificationCreateDto();

           return $dto;
    }
    */
    private function commonFieldsEntityToDto(Notification $entity, object $dto): void
    {
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
    }

    private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (! is_object($item)) {
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
        if (null === $iri || '' === $iri) {
            if ($required) {
                throw new BadRequestHttpException(sprintf('Field "%s" is required and must be a non-empty IRI string.', $field));
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
        if (null === $id && preg_match('~/(\d+)$~', $iri, $m)) {
            $id = (int) $m[1];
        }

        if (null === $id) {
            throw new BadRequestHttpException(sprintf('Invalid IRI type for field "%s". Expected "%s".', $field, $expectedClass));
        }

        $entity = $this->em->getRepository($expectedClass)->find($id);

        if (! $entity) {
            throw new BadRequestHttpException(sprintf('Resource not found for field "%s" (id: %s).', $field, (string) $id));
        }

        return $entity;
    }
}
