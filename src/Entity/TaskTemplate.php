<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TaskTemplateRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateUpdateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateResponseDto;

use App\ApiResource\State\TaskTemplate\TaskTemplateProvider;
use App\ApiResource\State\TaskTemplate\TaskTemplateProcessor;

#[GetCollection(
    provider: TaskTemplateProvider::class,
    output: TaskTemplateResponseDto::class
)]
#[Get(
    provider: TaskTemplateProvider::class,
    output: TaskTemplateResponseDto::class
)]
#[Post(
    processor: TaskTemplateProcessor::class,
    input: TaskTemplateCreateDto::class
)]
#[Patch(
    processor: TaskTemplateProcessor::class,
    input: TaskTemplateUpdateDto::class
)]
#[Delete(
    processor: TaskTemplateProcessor::class,
    ouput: false,
    status: 204
)]

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TaskTemplateRepository::class)]
class TaskTemplate
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
    private ?int $parentTask = null;


    #[ORM\ManyToOne(targetEntity: SprintTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SprintTemplate $sprintTemplate = null;

    #[ORM\ManyToOne(targetEntity: TypeTask::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeTask $typeTask = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSprintTemplate(): ?SprintTemplate
    {
        return $this->sprintTemplate;
    }

    public function setSprintTemplate(?SprintTemplate $sprintTemplate): static
    {
        $this->sprintTemplate = $sprintTemplate;
        return $this;
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

    public function getParentTask(): ?int
    {
        return $this->parentTask;
    }

    public function setParentTask(int $parentTask): static
    {
        $this->parentTask = $parentTask;
        return $this;
    }

    public function getTypeTask(): ?TypeTask
    {
        return $this->typeTask;
    }

    public function setTypeTask(?TypeTask $typeTask): static
    {
        $this->typeTask = $typeTask;
        return $this;
    }
}
