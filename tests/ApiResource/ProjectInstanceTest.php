<?php

namespace App\Tests\ApiResource;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProjectInstanceTest extends ApiTestCase
{
    /**
     * Test complet du cycle de vie CRUD pour ProjectInstance.
     */
    public function testFullCrudProjectInstance(): void
    {
        $client = static::createClient();

        // Récupérer un status existant
        $response = $client->request('GET', '/api/statuses');
        $statusIri = $response->toArray()['member'][0]['@id'] ?? null;

        // Récupérer une priority existante
        $response = $client->request('GET', '/api/priorities');
        $priorityIri = $response->toArray()['member'][0]['@id'] ?? null;

        // 1. CREATE
        $startDate = (new \DateTime('+1 day'))->format(\DateTime::RFC3339);
        $endDate = (new \DateTime('+1 month'))->format(\DateTime::RFC3339);
        $createdAt = (new \DateTime())->format(\DateTime::RFC3339);

        $data = [
            'name' => 'Project CRUD Test',
            'pathFileDatabase' => '/tests/db',
            'pathProject' => '/tests/project',
            'description' => 'A project created by automated tests',
            'icon' => 'test-icon',
            'color' => '#FF0000',
            'isFavory' => true,
            'position' => 99,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'createdAt' => $createdAt,
            'status' => $statusIri,
            'priority' => $priorityIri,
        ];

        $response = $client->request('POST', '/api/project_instances', [
            'json' => $data,
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@type' => 'ProjectInstance',
            'name' => 'Project CRUD Test',
            'pathFileDatabase' => '/tests/db',
            'isFavory' => true,
            'status' => $statusIri,
            'priority' => $priorityIri,
        ]);

        $content = $response->toArray();
        $iri = $content['@id'];
        $id = $content['id'];

        // 2. READ (Item)
        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'name' => 'Project CRUD Test',
        ]);

        // 3. UPDATE (PATCH)
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Project CRUD Test Updated',
                'color' => '#0000FF',
                'isFavory' => false,
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => 'Project CRUD Test Updated',
            'color' => '#0000FF',
            'isFavory' => false,
        ]);

        // 4. READ (Collection)
        $client->request('GET', '/api/project_instances');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@type' => 'hydra:Collection',
        ]);

        // 5. DELETE
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // 6. VERIFY DELETED
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test de validation sur le nom obligatoire.
     */
    public function testCreateValidationErrors(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/project_instances', [
            'json' => [
                'name' => '', // Blank name
                'isFavory' => true,
                'position' => 1,
                'startDate' => (new \DateTime())->format(\DateTime::RFC3339),
                'endDate' => (new \DateTime())->format(\DateTime::RFC3339),
                'createdAt' => (new \DateTime())->format(\DateTime::RFC3339),
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
