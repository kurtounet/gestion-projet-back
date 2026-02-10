<?php

namespace App\ApiResource\Mapper\Comment;

use ApiPlatform\Metadata\IriConverterInterface;
use App\ApiResource\Dto\Comment\CommentCollectionItemDto;
use App\ApiResource\Dto\Comment\CommentCreateDto;
use App\ApiResource\Dto\Comment\CommentItemDto;
use App\ApiResource\Dto\Comment\CommentUpdateDto;
use App\ApiResource\Service\IriFromResource;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentMapper
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private IriFromResource $iriFromResource,
        private IriConverterInterface $iriConverter,
    ) {
    }

    public function entityToItemDto(Comment $entity): CommentItemDto
    {
        $dto = new CommentItemDto();
        $dto->id = $entity->getId();
        $dto->subject = $entity->getSubject();
        $dto->content = $entity->getContent();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

        $dto->taskinstance = $entity->getTaskinstance()
            ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
            : null;

        $dto->user = $entity->getUser()
            ? ($this->iriFromResource)(User::class,$entity->getUser()->getId())
            : null;


        */
        return $dto;
    }

    public function entityToCollectionDto(Comment $entity): CommentCollectionItemDto
    {
        $dto = new CommentCollectionItemDto();
        $dto->id = $entity->getId();
        $dto->subject = $entity->getSubject();
        $dto->content = $entity->getContent();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        /*

         $dto->taskinstance = $entity->getTaskinstance()
             ? ($this->iriFromResource)(TaskInstance::class,$entity->getTaskinstance()->getId())
             : null;

         $dto->user = $entity->getUser()
             ? ($this->iriFromResource)(User::class,$entity->getUser()->getId())
             : null;


        */
        return $dto;
    }

    public function createDtoToEntity(CommentCreateDto $dto): Comment
    {
        $entity = new Comment();
        $entity->setSubject($dto->subject);
        $entity->setContent($dto->content);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);
        /*
                    $entity->setTask($dto->task);

             $entity->setUser($dto->user);


         $entity->setTaskInstance($this->resolveIri($dto->taskinstance ?? null, TaskInstance::class, 'taskinstance', required: true));

         $entity->setUser($this->resolveIri($dto->user ?? null, User::class, 'user', required: true));
        */

        return $entity;
    }

    public function updateDtoToEntity(Comment $entity, CommentUpdateDto $dto): Comment
    {
        $entity = new Comment();
        $entity->setSubject($dto->subject);
        $entity->setContent($dto->content);
        $entity->setCreatedAt($dto->createdAt);
        $entity->setUpdatedAt($dto->updatedAt);

        /*
                    $entity->setTask($dto->task);

             $entity->setUser($dto->user);


        */
        return $entity;
    }

    /*
    public function mapEntityToCreateDto(Comment $entity): CommentCreateDto
    {
               $dto = new CommentCreateDto();

       return $dto;
    }
    */
    private function commonFieldsEntityToDto(Comment $entity, object $dto): void
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
