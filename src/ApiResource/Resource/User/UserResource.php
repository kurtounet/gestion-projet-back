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
use App\ApiResource\Dto\User\UserResponseDto;
use App\ApiResource\Dto\User\UserCollectionResponse;

use App\ApiResource\State\User\UserProvider;
use App\ApiResource\State\User\UserProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    stateOptions: new Options(entityClass: User::class),
    operations: [
        new GetCollection(
            // security: "is_granted('USER_LIST', object)",
            // normalizationContext: ['groups' => ['User:collection:read']],
            // provider: UserProvider::class,
            // output: UserCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('USER_VIEW', object)",
            // normalizationContext: ['groups' => ['User:item:read']],
            // provider: UserProvider::class,
            // output: UserResponseDto::class
        ),
        new Post(
            // security: "is_granted('USER_CREATE', object)",
            // denormalizationContext: ['groups' => ['User:create']],
            // processor: UserProcessor::class,
            // input: UserCreateDto::class
        ),
        new Patch(
            // security: "is_granted('USER_EDIT', object)",
            // denormalizationContext: ['groups' => ['User:update']],
            // processor: UserProcessor::class,
            // input:UsereUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('USER_DELETE', object)",
            // processor: UserProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour User.
 * Utilisé pour exposer User.
 */
#[Map(source: User::class)]
final class UserResource
{
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
}
