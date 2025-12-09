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
use Symfony\Component\Serializer\Attribute\Groups;

#[GetCollection(
    // normalizationContext: ['groups' => ['status:list:read']],
    // provider: StatusProvider::class,
    // output: StatusResponseDto::class
)]
#[Get(
    // normalizationContext: ['groups' => ['projectInstance:item', 'status:item:read']],
    // provider: StatusProvider::class,
    // output: StatusResponseDto::class
)]
#[Post(
    // processor: StatusProcessor::class,
    // input: StatusCreateDto::class
)]
#[Patch(
    // processor: StatusProcessor::class,
    // input: StatusUpdateDto::class
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

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}
