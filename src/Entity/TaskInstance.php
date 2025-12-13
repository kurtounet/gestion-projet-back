<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\TaskInstanceRepository;
use Symfony\Component\Serializer\Attribute\Groups;

use App\Traits\TimestampTrait;
use App\Traits\UserStampTrait;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceResponseDto;

use App\ApiResource\State\TaskInstance\TaskInstanceProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceProcessor;

#[GetCollection(
    // security: "is_granted('PROJECT_INSTANCE_LIST')",
    provider: TaskInstanceProvider::class,
    output: TaskInstanceResponseDto::class
)]
#[Get(
    // security: "is_granted('PROJECT_INSTANCE_VIEW', object)",
    provider: TaskInstanceProvider::class,
    output: TaskInstanceResponseDto::class
)]
#[Post(
    // securityPostDenormalize: "is_granted('PROJECT_INSTANCE_CREATE', object)",
    processor: TaskInstanceProcessor::class,
    input: TaskInstanceCreateDto::class
)]
#[Patch(
    // security: "is_granted('PROJECT_INSTANCE_EDIT', object)",
    processor: TaskInstanceProcessor::class,
    input: TaskInstanceUpdateDto::class
)]
#[Delete(
    // security: "is_granted('PROJECT_INSTANCE_DELETE', object)",
    processor: TaskInstanceProcessor::class,
    output: false,
    status: 204
)]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
    'color' => 'partial',
    'priority' => 'exact',
    'status' => 'exact',

    // Relation directe
    'sprintInstance' => 'exact',

    // Champs internes à la relation
    'sprintInstance.id' => 'exact',
    'sprintInstance.color' => 'partial'
])]

#[ApiResource(
    security: "is_granted('ROLE_USER')"
)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TaskInstanceRepository::class)]
class TaskInstance
{
    use TimestampTrait;
    use UserStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?\DateTimeImmutable $dueDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?int $position = null;

    #[ORM\Column(length: 100)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?string $icon = null;

    #[ORM\Column(length: 7)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?string $color = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: TaskTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TaskTemplate $taskTemplate = null;

    #[ORM\ManyToOne(targetEntity: SprintInstance::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?SprintInstance $sprintInstance = null;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?Priority $priority = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: TypeTask::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?TypeTask $typeTask = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?self $parentTask = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
    private ?self $dependency = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    #[Groups(['sprintInstance:item', 'taskInstance:list:read', 'taskInstance:item:read'])]
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
     * Get the value of icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the value of icon
     *
     * @return  self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

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
