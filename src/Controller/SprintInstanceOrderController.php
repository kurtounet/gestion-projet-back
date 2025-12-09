<?php

namespace App\Controller;

use App\Entity\SprintInstance;
use App\Repository\SprintInstanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SprintInstanceOrderController extends AbstractController
{
    #[Route(
        path: '/custom/sprint_instances/order',
        name: 'custom_sprint_instances_update_order',
        methods: ['PATCH']
    )]
    public function __invoke(
        Request $request,
        SprintInstanceRepository $sprintRepository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['items']) || !\is_array($data['items'])) {
            return $this->json(
                ['message' => 'Invalid payload, expected "sprints" array'],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        foreach ($data['items'] as $item) {
            if (!isset($item['id'], $item['position'])) {
                continue;
            }

            /** @var SprintInstance|null $sprint */
            $sprint = $sprintRepository->find((int) $item['id']);

            if (null === $sprint) {
                continue;
            }

            $sprint->setPosition((int) $item['position']);
        }

        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
