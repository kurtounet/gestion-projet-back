<?php

namespace App\Entity;


use App\Repository\ContextStatusRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\ContextStatus\ContextStatusResponseDto;
use App\Dto\ContextStatus\ContextStatusUpdateDto;
use App\Dto\ContextStatus\ContextStatusCreateDto;
use App\State\ContextStatus\ContextStatusProvider;
use App\State\ContextStatus\ContextStatusProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: ContextStatusProvider::class,
    output: ContextStatusResponseDto::class
)]
#[Get(
    provider: ContextStatusProvider::class,
    output: ContextStatusResponseDto::class
)]
#[Post(
    processor: ContextStatusProcessor::class,
    input: ContextStatusCreateDto::class
)]
#[Patch(
    processor: ContextStatusProcessor::class,
    input: ContextStatusUpdateDto::class
)]
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContextStatusRepository::class)]
class ContextStatus
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $contextId = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $statusId = null;








    public function getId(): ?int
    {
        return $this->id;
    }



    public function getContextId(): ?int
    {
        return $this->contextId;
    }



    public function setContextId(int $contextId): static
    {
        $this->contextId = $contextId;
        return $this;
    }


    public function getStatusId(): ?string
    {
        return $this->statusId;
    }
}
