<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\SprintTemplateRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\SprintTemplate\SprintTemplateCreateDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateUpdateDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateResponseDto;

use App\ApiResource\State\SprintTemplate\SprintTemplateProvider;
use App\ApiResource\State\SprintTemplate\SprintTemplateProcessor;

#[GetCollection(
    provider: SprintTemplateProvider::class,
    output: SprintTemplateResponseDto::class
)]
#[Get(
    provider: SprintTemplateProvider::class,
    output: SprintTemplateResponseDto::class
)]
#[Post(
    processor: SprintTemplateProcessor::class,
    input: SprintTemplateCreateDto::class
)]
#[Patch(
    processor: SprintTemplateProcessor::class,
    input: SprintTemplateUpdateDto::class
)]
#[Delete(
    processor: SprintTemplateProcessor::class,
    output: false,
    status: 204
)]

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SprintTemplateRepository::class)]
class SprintTemplate
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
