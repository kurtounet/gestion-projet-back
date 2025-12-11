<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampTrait;
use Symfony\Component\Serializer\Attribute\Groups;

use App\Repository\PriorityRepository;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Dto\Priority\PriorityUpdateDto;
use App\ApiResource\Dto\Priority\PriorityResponseDto;

use App\ApiResource\State\Priority\PriorityProvider;
use App\ApiResource\State\Priority\PriorityProcessor;

#[GetCollection(
    provider: PriorityProvider::class,
    output: PriorityResponseDto::class
)]
#[Get(
    provider: PriorityProvider::class,
    output: PriorityResponseDto::class
)]
#[Post(
    processor: PriorityProcessor::class,
    input: PriorityCreateDto::class
)]
#[Patch(
    processor: PriorityProcessor::class,
    input: PriorityUpdateDto::class
)]
#[Delete(
    processor: PriorityProcessor::class,
    output: false,
    status: 204
)]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PriorityRepository::class)]
class Priority
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['projectInstance:item', 'priority:list:read', 'priority:item:read'])]
    private ?string $label = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['projectInstance:item', 'priority:list:read', 'priority:item:read'])]
    private ?string $color = '#84e712ff';

    #[ORM\Column]
    private ?int $priorityNumber = null;

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

    public function getPriorityNumber(): ?int
    {
        return $this->priorityNumber;
    }

    public function setPriorityNumber(int $priorityNumber): static
    {
        $this->priorityNumber = $priorityNumber;
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
