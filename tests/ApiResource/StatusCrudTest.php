<?php

namespace App\Tests\ApiResource;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class StatusCrudTest extends ApiTestCase
{
    public function testCrudStatus(): void
    {
        $client = self::createClient();

        // 0. Create Context (Dependency)
        $ctxRes = $client->request('POST', '/api/contexts', [
            'json' => ['contextLabel' => 'Ctx for Status '.uniqid()],
        ]);
        $ctxIri = $ctxRes->toArray()['@id'];

        $label = 'Test Status '.uniqid();
        // 1. Create Status
        $response = $client->request('POST', '/api/statuses', [
            'json' => [
                'label' => $label,
                'color' => '#00ff00',
                'context' => $ctxIri,
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $data = $response->toArray();
        file_put_contents('status_post_response.json', json_encode($data, JSON_PRETTY_PRINT));
        $this->assertJsonContains(['label' => $label]);

        $iri = $data['@id'];

        // 2. Read Item
        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();

        // 3. Delete Status
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // 4. Delete Context (Cleanup)
        $client->request('DELETE', $ctxIri);
        $this->assertResponseStatusCodeSame(204);
    }
}
