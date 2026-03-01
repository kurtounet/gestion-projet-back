<?php

namespace App\Entity;

use App\Repository\SprintInstanceRepository;
use App\Traits\TimestampTrait;
use App\Traits\UserStampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SprintInstanceRepository::class)]
class SprintInstance
{
    use TimestampTrait;
    use UserStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 7)]
    private ?string $color = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Priority $priority = null;

    #[ORM\ManyToOne(targetEntity: SprintTemplate::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?SprintTemplate $sprintTemplate = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    private ?Comment $comment = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $sprintDependency = null;

    #[ORM\ManyToOne(inversedBy: 'sprintInstances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectInstance $projectInstance = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
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

    public function getSprintDependency(): ?self
    {
        return $this->sprintDependency;
    }

    public function setSprintDependency(?self $sprintDependency): static
    {
        $this->sprintDependency = $sprintDependency;

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

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $order): static
    {
        $this->position = $order;

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

    public function getProjectInstance(): ?ProjectInstance
    {
        return $this->projectInstance;
    }

    public function setProjectInstance(?ProjectInstance $projectInstance): static
    {
        $this->projectInstance = $projectInstance;

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
