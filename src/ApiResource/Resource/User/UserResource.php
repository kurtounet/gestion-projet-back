<?php

namespace App\ApiResource\Resource\User;

use App\Entity\User;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\User\UserCreateDto;
use App\ApiResource\Dto\User\UserUpdateDto;
use App\ApiResource\Dto\User\UserItemDto;
use App\ApiResource\Dto\User\UserCollectionItemDto;

use App\ApiResource\State\User\UserCollectionProvider;
use App\ApiResource\State\User\UserItemProvider;
use App\ApiResource\State\User\UserCreateProcessor;
use App\ApiResource\State\User\UserUpdateProcessor;
use App\ApiResource\State\User\UserDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    stateOptions: new Options(entityClass: User::class),
    operations: [
        new GetCollection(
            uriTemplate: 'user',
            normalizationContext: ['groups' => ['User:collection:read']],
            provider: UserCollectionProvider::class,
            output: UserCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'user/{id}',
            normalizationContext: ['groups' => ['User:item:read']],
            provider: UserItemProvider::class,
            output: UserItemDto::class
        ),
        new Post(
            uriTemplate: 'user/{id}',
            denormalizationContext: ['groups' => ['User:create']],
            processor: UserCreateProcessor::class,
            input: UserCreateDto::class,
            output: UserItemDto::class
        ),
        new Patch(
            uriTemplate: 'user/{id}',
            denormalizationContext: ['groups' => ['User:update']],
            processor: UserUpdateProcessor::class,
            input: UserUpdateDto::class,
            output: UserItemDto::class
        ),
        new Delete(
            uriTemplate: 'user/{id}',
            processor: UserDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: User::class)]
final class UserResource
{
    public int $id;
/*
    #[Groups(['User:collection:read', 'User:item:read'])]
    public int $id;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public string $firstName;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public string $lastName;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public string $email;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public array $roles;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public string $password;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['User:collection:read', 'User:item:read'])]
    public ?\DateTimeInterface $updatedAt;


*/
}
