<?php

namespace App\Command\Services;

use App\Command\CmdHelpers;
use Symfony\Component\Validator\Constraints\Json;

final readonly class GenerateBrunoCollection
{
    public function __construct(
        private CmdHelpers $helpers,
    ) {
    }

    public function generateBrunoCollection(array $metaExport): string
    {
        $method = ['Collection' => 'GET', 'Create' => 'POST', 'Item' => 'GET', 'Delete' => 'DELETE',  'Update' => 'PATCH'];

        $auth =
            [
                'type' => 'folder',
                'name' => 'Authentication',
                'items' => [
                    [
                        'type' => 'http',
                        'name' => 'Authentication',
                        'seq' => 1,
                        'request' => [
                            'url' => 'https://localhost:8001/api/login_check',
                            'method' => 'GET',
                            'headers' => [
                                [
                                    'name' => 'Content-Type',
                                    'value' => 'application/json',
                                    'enabled' => true,
                                ],
                            ],
                            'body' => [
                                'mode' => 'json',
                                'json' => "{\n  \"email\": \"admin@gmail.com\",\n  \"password\": \"password123\"\n}",
                                'formUrlEncoded' => [],
                                'multipartForm' => [],
                            ],

                            // IMPORTANT : {} en JSON => (object)[] en PHP
                            'script' => (object) ['res' => " // Exemple : { \"token\": \"xxxxx\" }\nconst body = res.body;\n\nif (!body?.token) {\n  throw new Error(\"Token introuvable dans la réponse du login\");\n}\n\nbru.setEnvVar(\"token\", body.token);\n\n// Optionnel debug\nconsole.log(\"Token enregistré:\", body.token);\n"],
                            'vars' => (object) [],

                            'assertions' => [],
                            'tests' => '',
                            'auth' => [
                                'mode' => 'bearer',
                                'bearer' => ['token' => 'monToken'],
                            ],
                            'query' => [],
                        ],
                    ],
                ],
            ];
        $items = [];
        $items[] = $auth;
        foreach ($metaExport as $entityClass => $metadata) {
            $shortEntityClass = (new \ReflectionClass($entityClass))->getShortName();
            $shortEntityClassPlural = $this->helpers->pluralizeEn($shortEntityClass);
            $uriTemplate = $this->helpers->pascalCaseToLowerSnakeCase($shortEntityClassPlural);
            $crud = [];
            // Opérations CRUD
            foreach ($method as $methodKey => $methodValue) {
                $url = 'https://localhost:8001/api/'.$uriTemplate;
                $seq = 0;
                $headers = [];
                $query = [];
                if ('Collection' === $methodKey) {
                    $query = [[
                        'name' => 'page',
                        'value' => '',
                        'enabled' => false,
                    ]];
                    $seq = 1;
                } elseif ('Item' === $methodKey) {
                    $seq = 3;
                } elseif ('Create' === $methodKey) {
                    $seq = 2;
                    $headers = [
                        [
                            'name' => 'Content-Type',
                            'value' => 'application/ld+json',
                            'enabled' => true,
                        ],
                    ];
                } elseif ('Update' === $methodKey) {
                    $seq = 5;
                    $headers = [
                        [
                            'name' => 'Content-Type',
                            'value' => 'application/merge-patch+json',
                            'enabled' => true,
                        ],
                    ];
                } elseif ('Delete' === $methodKey) {
                    $seq = 4;
                }
                if ('Item' === $methodKey || 'Update' === $methodKey || 'Delete' === $methodKey) {
                    $url .= '/{id}';
                }
                $operation = [
                    'type' => 'http',
                    'name' => $methodKey.'-'.$uriTemplate,
                    'seq' => $seq,
                    'request' => [
                        'url' => $url,
                        'method' => $methodValue,
                        'headers' => $headers,
                        'body' => [
                            'mode' => 'none',
                            'formUrlEncoded' => [],
                            'multipartForm' => [],
                        ],
                        'script' => (object) [],
                        'vars' => (object) [],
                        'assertions' => [],
                        'tests' => '',
                        'auth' => [
                            'mode' => 'none',
                        ],
                        'query' => [...$query],
                    ],
                ];
                $crud[] = $operation;
            }
            $items[] = [
                'type' => 'folder',
                'name' => $shortEntityClassPlural,
                'items' => $crud,
            ];
        }

        $environments = [
            'environments' => [
                [
                    'variables' => [
                        'name' => 'token',
                        'value' => '',
                        'enabled' => true,
                        'secret' => false,
                        'type' => 'text',
                    ],
                    'name' => 'environement',
                ],
            ],
        ];
        $environments = [
            'environments' => [],
        ];
        $brunoConfig = [
            'brunoConfig' => [
                'version' => '1',
                'name' => 'gestion-projet',
                'type' => 'collection',
                'ignore' => [
                    'node_modules',
                    '.git',
                ],
            ],
        ];
        $collection = [
            'name' => 'gestion-projet',
            'version' => '1',
            'items' => [...$items],
            ...$environments,
            ...$brunoConfig,
        ];

        return json_encode($collection, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
