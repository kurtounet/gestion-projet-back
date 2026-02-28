<?php

namespace App\Tests\ApiResource;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\ORM\EntityManagerInterface;

final class PriorityCrudTest extends ApiTestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCrudPriority(): void
    {
        $client = self::createClient();
        $label = 'Test Priority '.uniqid();
        $priorityNumber = rand(100, 1000);

        // 1. Create
        $response = $client->request('POST', '/api/priorities', [
            'json' => [
                'label' => $label,
                'color' => '#ff0000',
                'priorityNumber' => $priorityNumber,
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $data = $response->toArray();
        file_put_contents('priority_post_response.json', json_encode($data, JSON_PRETTY_PRINT));
        $this->assertJsonContains([
            'label' => $label,
            'color' => '#ff0000',
            'priorityNumber' => $priorityNumber,
        ]);

        $data = $response->toArray();
        $iri = $data['@id'];
        $id = $data['id'];

        // 2. Read Item
        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['label' => $label]);

        // 3. Read Collection
        $client->request('GET', '/api/priorities');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['totalItems' => 1]);

        // 4. Update (Patch)
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'label' => 'Updated Priority',
            ],
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['label' => 'Updated Priority']);

        // 5. Delete
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // Verify deletion
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }
}
