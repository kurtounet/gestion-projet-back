<?php

namespace App\ApiResource\Resource\User;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\User\UserCreateDto;
use App\ApiResource\Dto\User\UserUpdateDto;
use App\ApiResource\State\User\UserCollectionProvider;
use App\ApiResource\State\User\UserCreateProcessor;
use App\ApiResource\State\User\UserDeleteProcessor;
use App\ApiResource\State\User\UserItemProvider;
use App\ApiResource\State\User\UserUpdateProcessor;
use App\Entity\User;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'User',
    stateOptions: new Options(entityClass: User::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: UserCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: UserItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: UserCreateProcessor::class,
            input: UserCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: UserUpdateProcessor::class,
            input: UserUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: UserDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class UserResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $firstName;

    #[Groups(['collection:read', 'item:read'])]
    public string $lastName;

    #[Groups(['collection:read', 'item:read'])]
    public string $email;

    #[Groups(['collection:read', 'item:read'])]
    public array $roles;

    #[Groups(['collection:read', 'item:read'])]
    public string $password;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;



}
