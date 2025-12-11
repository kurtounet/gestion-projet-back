<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampTrait;
use App\Repository\ProjectTemplateRepository;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateUpdateDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateResponseDto;

use App\ApiResource\State\ProjectTemplate\ProjectTemplateProvider;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateProcessor;

#[GetCollection(
    provider: ProjectTemplateProvider::class,
    output: ProjectTemplateResponseDto::class
)]
#[Get(
    provider: ProjectTemplateProvider::class,
    output: ProjectTemplateResponseDto::class
)]
#[Post(
    processor: ProjectTemplateProcessor::class,
    input: ProjectTemplateCreateDto::class
)]
#[Patch(
    processor: ProjectTemplateProcessor::class,
    input: ProjectTemplateUpdateDto::class
)]
#[Delete(
    processor: ProjectTemplateProcessor::class,
    ouput: false
)]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectTemplateRepository::class)]
class ProjectTemplate
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
}
