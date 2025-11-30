<?php

namespace App\Entity;


use App\Repository\TaskInstanceRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\TaskInstance\TaskInstanceResponseDto;
use App\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\Dto\TaskInstance\TaskInstanceCreateDto;
use App\State\TaskInstance\TaskInstanceProvider;
use App\State\TaskInstance\TaskInstanceProcessor;
use App\Traits\TimestampTrait;


#[GetCollection(
    provider: TaskInstanceProvider::class,
    output: TaskInstanceResponseDto::class
)]
#[Get(
    provider: TaskInstanceProvider::class,
    output: TaskInstanceResponseDto::class
)]
#[Post(
    processor: TaskInstanceProcessor::class,
    input: TaskInstanceCreateDto::class
)]
#[Patch(
    processor: TaskInstanceProcessor::class,
    input: TaskInstanceUpdateDto::class
)]
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TaskInstanceRepository::class)]
class TaskInstance
{
    use TimestampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column]
    private ?int $taskTemplateId = null;

    #[ORM\Column]
    private ?int $sprintInstanceId = null;

    #[ORM\Column]
    private ?int $priorityId = null;

    #[ORM\Column]
    private ?int $statusId = null;

    #[ORM\Column]
    private ?int $typeTaskId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $dueDate = null;

    #[ORM\Column]
    private ?int $order = null;

    #[ORM\Column]
    private ?int $parentTask = null;

    #[ORM\Column]
    private ?int $dependencyId = null;


    #[ORM\Column]
    private ?int $commentId = null;






    public function getId(): ?int
    {
        return $this->id;
    }



    public function getUserId(): ?int
    {
        return $this->userId;
    }



    public function setUserId(int $userId): static
    {
        $this->userId = $userId;
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


    public function getSprintInstanceId(): ?int
    {
        return $this->sprintInstanceId;
    }



    public function setSprintInstanceId(int $sprintInstanceId): static
    {
        $this->sprintInstanceId = $sprintInstanceId;
        return $this;
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


    public function getStatusId(): ?int
    {
        return $this->statusId;
    }



    public function setStatusId(int $statusId): static
    {
        $this->statusId = $statusId;
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


    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }



    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;
        return $this;
    }


    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }



    public function setDueDate(\DateTimeImmutable $dueDate): static
    {
        $this->dueDate = $dueDate;
        return $this;
    }


    public function getOrder(): ?int
    {
        return $this->order;
    }



    public function setOrder(int $order): static
    {
        $this->order = $order;
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


    public function getDependencyId(): ?int
    {
        return $this->dependencyId;
    }



    public function setDependencyId(int $dependencyId): static
    {
        $this->dependencyId = $dependencyId;
        return $this;
    }





    public function getCommentId(): ?int
    {
        return $this->commentId;
    }



    public function setCommentId(int $commentId): static
    {
        $this->commentId = $commentId;
        return $this;
    }
}
