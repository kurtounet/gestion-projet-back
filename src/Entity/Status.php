<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StatusRepository;
use Symfony\Component\Serializer\Attribute\Groups;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Dto\Status\StatusUpdateDto;
use App\ApiResource\Dto\Status\StatusResponseDto;

use App\ApiResource\State\Status\StatusProvider;
use App\ApiResource\State\Status\StatusProcessor;


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
#[Delete(
    processor: StatusProcessor::class,
    output: false,
    status: 204
)]

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['projectInstance:item', 'status:list:read', 'status:item:read'])]
    private ?string $label = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['projectInstance:item', 'status:list:read', 'status:item:read'])]
    private ?string $color = '#84e712ff';

    #[ORM\ManyToOne(targetEntity: Context::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Context $context = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
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

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}
