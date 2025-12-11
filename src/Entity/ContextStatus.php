<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\ContextStatusRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\ContextStatus\ContextStatusCreateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusUpdateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusResponseDto;

use App\ApiResource\State\ContextStatus\ContextStatusProcessor;
use App\ApiResource\State\ContextStatus\ContextStatusProvider;

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
#[Delete(
    processor: ContextStatusProcessor::class,
    ouput: false
)]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContextStatusRepository::class)]
class ContextStatus
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Context::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Context $context = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContext(): ?Context
    {
        return $this->context;
    }

    public function setContext(?Context $context): static
    {
        $this->context = $context;
        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;
        return $this;
    }
}
