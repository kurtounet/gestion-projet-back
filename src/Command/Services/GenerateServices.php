<?php

namespace App\Command\Services;

final readonly class GenerateServices
{
    public function generateIriFromResource(string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use ApiPlatform\Metadata\IriConverterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IriFromResource
{
    public function __construct(
        private IriConverterInterface \$iriConverter,
    ) {}

    public function __invoke(string \$resourceClass, int|string|null \$id): ?string
    {
        if (\$id === null || \$id === '') {
            return null;
        }

        try {
            \$resource = new \$resourceClass();
            if (property_exists(\$resource, 'id')) {
                \$resource->id = (int)\$id;
            }

            return \$this->iriConverter->getIriFromResource(\$resource);
        } catch (\Throwable \$e) {
            // Optionnel mais utile pour un message clair côté API
            throw new NotFoundHttpException(sprintf(
                'IRI not resolvable for resource %s with id %s.',
                \$resourceClass,
                (string) \$id
            ), \$e);
        }
    }
}
PHP;
    }
}
