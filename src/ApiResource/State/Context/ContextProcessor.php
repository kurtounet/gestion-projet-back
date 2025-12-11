<?php

namespace App\ApiResource\State\Context;

use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Entity\Context;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\Context\ContextCreateDto;
use App\ApiResource\Dto\Context\ContextUpdateDto;

/**
 * Processor custom pour Context.
 * Décore le Processor par défaut pour ajouter une logique d'écriture si besoin.
 *
 * @implements ProcessorInterface<ContextCreateDto|ContextUpdateDto, ContextResponseDto|App\Entity\Context|void>
 */


final readonly class ContextProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface $persistProcessor,

        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private readonly ProcessorInterface $removeProcessor,
    ){}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($operation instanceof Delete) {
            $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            return null;
        }

        if ($operation instanceof Post && $data instanceof ContextCreateDto) {

            $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        if ($operation instanceof Patch || $operation instanceof Put && $data instanceof ContextUpdateDto) {
            $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        return $data;
    }
}
