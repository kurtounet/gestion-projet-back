<?php

namespace App\Tests\ApiResource;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class ContextCrudTest extends ApiTestCase
{
    public function testCrudContext(): void
    {
        $client = self::createClient();

        $label = 'Test Context '.uniqid();

        // 1. Create
        $response = $client->request('POST', '/api/contexts', [
            'json' => [
                'contextLabel' => $label,
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $data = $response->toArray();
        $this->assertJsonContains(['label' => $label]);
        $iri = $data['@id'];

        // 2. Read
        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();

        // 3. Delete
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
    }
}
