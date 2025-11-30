<?php

namespace App\Entity;


use App\Repository\StatusRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Status\StatusResponseDto;
use App\Dto\Status\StatusUpdateDto;
use App\Dto\Status\StatusCreateDto;
use App\State\Status\StatusProvider;
use App\State\Status\StatusProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: StatusProvider::class,
    output: StatusResponseDto::class
)]
#[Get(
    provider: StatusProvider::class,
    output: StatusResponseDto::class
)]
#[Post(
    processor: StatusProcessor::class,
    input: StatusCreateDto::class
)]
#[Patch(
    processor: StatusProcessor::class,
    input: StatusUpdateDto::class
)]
#[Delete()]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $statusId = null;

    #[ORM\Column(length: 50)]
    private ?string $statusName = null;

    #[ORM\Column]
    private ?int $statusContext = null;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getStatusId(): ?int
    {
        return $this->statusId;
    }



    public function setStatusId(int $statusId): static
    {
        $this->statusId = $statusId;
        return $this;
    }


    public function getStatusName(): ?string
    {
        return $this->statusName;
    }



    public function setStatusName(string $statusName): static
    {
        $this->statusName = $statusName;
        return $this;
    }


    public function getStatusContext(): ?int
    {
        return $this->statusContext;
    }



    public function setStatusContext(int $statusContext): static
    {
        $this->statusContext = $statusContext;
        return $this;
    }
}
