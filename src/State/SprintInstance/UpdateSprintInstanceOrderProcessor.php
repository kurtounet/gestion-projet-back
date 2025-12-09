<?php

namespace App\State\SprintInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\SprintInstance\SprintInstanceOrderItemDto;
use App\Dto\SprintInstance\UpdateSprintInstanceOrderDto;
use App\Entity\SprintInstance;
use App\Repository\SprintInstanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final class UpdateSprintInstanceOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SprintInstanceRepository $sprintRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @param UpdateSprintInstanceOrderDto $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {

        dd($data);

        if (!$data instanceof UpdateSprintInstanceOrderDto) {

            $this->logger->error('Unexpected data type', [
                'type' => get_debug_type($data),
            ]);

            throw new \LogicException('Expected UpdateSprintInstanceOrderDto.');

            return null;
        }
        $this->logger->info('Update sprint order called', [
            'payload' => $data,
        ]);

        foreach ($data->sprints as $item) {
            if (!$item instanceof SprintInstanceOrderItemDto) {
                $this->logger->warning('Invalid item in sprints array', [
                    'item' => $item,
                ]);
                continue;
            }

            /** @var SprintInstance|null $sprint */
            $sprint = $this->sprintRepository->find($item->id);

            if (null === $sprint) {
                $this->logger->warning('Sprint not found for order update', [
                    'id' => $item->id,
                ]);
                continue;
            }

            $this->logger->info('Updating sprint position', [
                'id' => $item->id,
                'old_position' => $sprint->getPosition(),
                'new_position' => $item->position,
            ]);

            $sprint->setPosition($item->position);
        }


        $this->entityManager->flush();

        // pas de ressource à retourner (output: null)
        return null;
    }
}
