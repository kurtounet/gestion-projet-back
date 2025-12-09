<?php

namespace App\Controller;


use App\Repository\TaskInstanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TaskInstanceOrderController extends AbstractController
{
    #[Route(
        path: '/custom/task_instances/order',
        name: 'custom_task_instances_update_order',
        methods: ['PATCH']
    )]
    public function __invoke(
        Request $request,
        TaskInstanceRepository $taskRepository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['items']) || !\is_array($data['items'])) {
            return $this->json(
                ['message' => 'Invalid payload, expected "tasks" array'],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        foreach ($data['items'] as $item) {
            if (!isset($item['id'], $item['position'])) {
                continue;
            }

            /** @var TaskInstance|null $task */
            $task = $taskRepository->find((int) $item['id']);

            if (null === $task) {
                continue;
            }

            $task->setPosition((int) $item['position']);
        }

        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
