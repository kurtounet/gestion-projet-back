<?php

namespace App\ApiResource\State\ConfigProjectFramework;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Delete processor pour ConfigProjectFramework.
 *
 * @implements ProcessorInterface<App\Entity\ConfigProjectFramework, void>
 */
final readonly class ConfigProjectFrameworkDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($operation instanceof Delete) {
            $this->removeProcessor->process($data, $operation, $uriVariables, $context);

            return null;

            return $data;
        }
    }
}
