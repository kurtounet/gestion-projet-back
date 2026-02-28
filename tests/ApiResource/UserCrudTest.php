<?php

namespace App\Tests\ApiResource;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class UserCrudTest extends ApiTestCase
{
    public function testCrudUser(): void
    {
        $client = self::createClient();
        $email = 'john.doe.'.uniqid().'@example.com';
        // 1. Create
        $response = $client->request('POST', '/api/users', [
            'json' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => $email,
                'password' => 'password123',
                'roles' => ['ROLE_USER'],
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $data = $response->toArray();
        file_put_contents('user_post_response.json', json_encode($data, JSON_PRETTY_PRINT));
        $this->assertJsonContains(['email' => $email]);

        $iri = $data['@id'];

        // 3. Delete
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // Verify deletion
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }
}
