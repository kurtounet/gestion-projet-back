<?php

namespace App\Entity;

use App\Repository\TaskInstanceRepository;
use App\Traits\TimestampTrait;
use App\Traits\UserStampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TaskInstanceRepository::class)]
class TaskInstance
{
    use TimestampTrait;
    use UserStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dueDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\Column(length: 100)]
    private ?string $icon = null;

    #[ORM\Column(length: 7)]
    private ?string $color = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: TaskTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TaskTemplate $taskTemplate = null;

    #[ORM\ManyToOne(targetEntity: SprintInstance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SprintInstance $sprintInstance = null;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Priority $priority = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: TypeTask::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeTask $typeTask = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $parentTask = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $dependency = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    private ?Comment $comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTaskTemplate(): ?TaskTemplate
    {
        return $this->taskTemplate;
    }

    public function setTaskTemplate(?TaskTemplate $taskTemplate): static
    {
        $this->taskTemplate = $taskTemplate;

        return $this;
    }

    public function getSprintInstance(): ?SprintInstance
    {
        return $this->sprintInstance;
    }

    public function setSprintInstance(?SprintInstance $sprintInstance): static
    {
        $this->sprintInstance = $sprintInstance;

        return $this;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $order): static
    {
        $this->position = $order;

        return $this;
    }

    public function getParentTask(): ?self
    {
        return $this->parentTask;
    }

    public function setParentTask(?self $parentTask): static
    {
        $this->parentTask = $parentTask;

        return $this;
    }

    public function getDependency(): ?self
    {
        return $this->dependency;
    }

    public function setDependency(?self $dependency): static
    {
        $this->dependency = $dependency;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of icon.
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the value of icon.
     *
     * @return self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the value of color.
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color.
     *
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}
