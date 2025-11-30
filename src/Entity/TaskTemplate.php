<?php

namespace App\Entity;


use App\Repository\TaskTemplateRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\TaskTemplate\TaskTemplateResponseDto;
use App\Dto\TaskTemplate\TaskTemplateUpdateDto;
use App\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\State\TaskTemplate\TaskTemplateProvider;
use App\State\TaskTemplate\TaskTemplateProcessor;
use App\Traits\TimestampTrait;

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
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TaskTemplateRepository::class)]
class TaskTemplate
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $sprintTemplateId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $parentTask = null;

    #[ORM\Column]
    private ?int $typeTaskId = null;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getSprintTemplateId(): ?int
    {
        return $this->sprintTemplateId;
    }



    public function setSprintTemplateId(int $sprintTemplateId): static
    {
        $this->sprintTemplateId = $sprintTemplateId;
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


    public function getTypeTaskId(): ?int
    {
        return $this->typeTaskId;
    }



    public function setTypeTaskId(int $typeTaskId): static
    {
        $this->typeTaskId = $typeTaskId;
        return $this;
    }
}
