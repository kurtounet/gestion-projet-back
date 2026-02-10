<?php

namespace App\Controller;

use App\Entity\projectInstance;
use App\Repository\ProjectInstanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectInstanceOrderController extends AbstractController
{
    #[Route(
        path: '/custom/project_instances/order',
        name: 'custom_project_instances_update_order',
        methods: ['PATCH']
    )]
    public function __invoke(
        Request $request,
        ProjectInstanceRepository $projectRepository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (! isset($data['items']) || ! \is_array($data['items'])) {
            return $this->json(
                ['message' => 'Invalid payload, expected "projects" array'],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        foreach ($data['items'] as $item) {
            if (! isset($item['id'], $item['position'])) {
                continue;
            }

            /** @var projectInstance|null $project */
            $project = $projectRepository->find((int) $item['id']);

            if (null === $project) {
                continue;
            }

            $project->setPosition((int) $item['position']);
        }

        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
