<?php

namespace App\Entity;


use App\Repository\SprintTaskRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\SprintTask\SprintTaskResponseDto;
use App\Dto\SprintTask\SprintTaskUpdateDto;
use App\Dto\SprintTask\SprintTaskCreateDto;
use App\State\SprintTask\SprintTaskProvider;
use App\State\SprintTask\SprintTaskProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: SprintTaskProvider::class,
    output: SprintTaskResponseDto::class
)]
#[Get(
    provider: SprintTaskProvider::class,
    output: SprintTaskResponseDto::class
)]
#[Post(
    processor: SprintTaskProcessor::class,
    input: SprintTaskCreateDto::class
)]
#[Patch(
    processor: SprintTaskProcessor::class,
    input: SprintTaskUpdateDto::class
)]
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SprintTaskRepository::class)]
class SprintTask
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $sprintTemplateId = null;

    #[ORM\Column]
    private ?int $taskTemplateId = null;

    #[ORM\Column]
    private ?int $taskOrder = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;






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


    public function getTaskTemplateId(): ?int
    {
        return $this->taskTemplateId;
    }



    public function setTaskTemplateId(int $taskTemplateId): static
    {
        $this->taskTemplateId = $taskTemplateId;
        return $this;
    }


    public function getTaskOrder(): ?int
    {
        return $this->taskOrder;
    }



    public function setTaskOrder(int $taskOrder): static
    {
        $this->taskOrder = $taskOrder;
        return $this;
    }
}
