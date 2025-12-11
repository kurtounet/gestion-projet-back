<?php

namespace App\ApiResource\State\TaskTemplate;

use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Entity\TaskTemplate;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateUpdateDto;

/**
 * Processor custom pour TaskTemplate.
 * Décore le Processor par défaut pour ajouter une logique d'écriture si besoin.
 *
 * @implements ProcessorInterface<TaskTemplateCreateDto|TaskTemplateUpdateDto, TaskTemplateResponseDto|App\Entity\TaskTemplate|void>
 */


final readonly class TaskTemplateProcessor implements ProcessorInterface
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

        if ($operation instanceof Post && $data instanceof TaskTemplateCreateDto) {

            $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        if ($operation instanceof Patch || $operation instanceof Put && $data instanceof TaskTemplateUpdateDto) {
            $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        return $data;
    }
}
