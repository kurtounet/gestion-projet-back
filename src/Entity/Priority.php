<?php

namespace App\Entity;


use App\Repository\PriorityRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Priority\PriorityResponseDto;
use App\Dto\Priority\PriorityUpdateDto;
use App\Dto\Priority\PriorityCreateDto;
use App\State\Priority\PriorityProvider;
use App\State\Priority\PriorityProcessor;
use App\Traits\TimestampTrait;

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
#[Delete()]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PriorityRepository::class)]
class Priority
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $priorityId = null;

    #[ORM\Column(length: 50)]
    private ?string $priorityLabel = null;

    #[ORM\Column]
    private ?int $priorityNumber = null;







    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPriorityId(): ?int
    {
        return $this->priorityId;
    }



    public function setPriorityId(int $priorityId): static
    {
        $this->priorityId = $priorityId;
        return $this;
    }


    public function getPriorityLabel(): ?string
    {
        return $this->priorityLabel;
    }



    public function setPriorityLabel(string $priorityLabel): static
    {
        $this->priorityLabel = $priorityLabel;
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
}
