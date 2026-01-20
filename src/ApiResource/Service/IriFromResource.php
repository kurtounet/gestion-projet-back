<?php

namespace App\ApiResource\Service;

use ApiPlatform\Metadata\IriConverterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IriFromResource
{
    public function __construct(
        private IriConverterInterface $iriConverter,
    ) {}

    public function __invoke(string $resourceClass, int|string|null $id): ?string
    {
        if ($id === null || $id === '') {
            return null;
        }

        try {
            return $this->iriConverter->getIriFromResource(
                $resourceClass,
                context: ['uri_variables' => ['id' => $id]]
            );
        } catch (\Throwable $e) {
            // Optionnel mais utile pour un message clair côté API
            throw new NotFoundHttpException(sprintf(
                'IRI not resolvable for resource %s with id %s.',
                $resourceClass,
                (string) $id
            ), $e);
        }
    }
}