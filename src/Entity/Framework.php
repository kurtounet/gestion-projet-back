<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\FrameworkRepository;
use App\Traits\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[GetCollection(

    // normalizationContext: ['groups' => ['list:read']],
    // provider: FrameworkProvider::class,
    // output: FrameworkResponseDto::class
)]
#[Get(
    // normalizationContext: ['groups' => ['Framework:item', 'item:read']],
    // provider: FrameworkProvider::class,
    // output: FrameworkResponseDto::class
)]
#[Post(
    // processor: FrameworkProcessor::class,
    // input: FrameworkCreateDto::class
)]
#[Patch(
    // processor: FrameworkProcessor::class,
    // input: FrameworkUpdateDto::class
)]
#[Delete(
    // processor: FrameworkProcessor::class,
    // output: false,
)]
#[ApiResource()]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FrameworkRepository::class)]
class Framework
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::JSON_OBJECT, nullable: true)]
    private mixed $configuration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Technology $techno = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfiguration(): mixed
    {
        return $this->configuration;
    }

    public function setConfiguration(mixed $configuration): static
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getTechno(): ?Technology
    {
        return $this->techno;
    }

    public function setTechno(?Technology $techno): static
    {
        $this->techno = $techno;

        return $this;
    }
}
