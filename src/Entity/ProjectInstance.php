<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Repository\ProjectInstanceRepository;


use App\Traits\UserStampTrait;
use App\Traits\TimestampTrait;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectInstanceRepository::class)]
class ProjectInstance
{
    use UserStampTrait;
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pathFileDatabase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pathProject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $isFavory = null;

    #[ORM\Column]    //
    private ?int $position = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Priority $priority = null;

    #[ORM\ManyToOne(targetEntity: ProjectTemplate::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ProjectTemplate $projectTemplate = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    private ?Comment $comment = null;

    /**
     * @var Collection<int, SprintInstance>
     */
    #[ORM\OneToMany(targetEntity: SprintInstance::class, mappedBy: 'projectInstance')] //, orphanRemoval: true
    private Collection $sprintInstances;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $projectInstances;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'projectInstances')]
    private ?self $parent = null;

    #[ORM\OneToOne(inversedBy: 'projectInstance', cascade: ['persist', 'remove'])]
    private ?ConfigProjectFramework $configFramework = null;

    public function __construct()
    {
        $this->sprintInstances = new ArrayCollection();
        $this->projectInstances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    public function getProjectTemplate(): ?ProjectTemplate
    {
        return $this->projectTemplate;
    }

    public function setProjectTemplate(?ProjectTemplate $projectTemplate): static
    {
        $this->projectTemplate = $projectTemplate;
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

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getPathProject(): ?string
    {
        return $this->pathProject;
    }

    public function setPathProject(?string $path): static
    {
        $this->pathProject = $path;

        return $this;
    }

    /**
     * @return Collection<int, SprintInstance>
     */
    public function getSprintInstances(): Collection
    {
        return $this->sprintInstances;
    }

    public function addSprintInstance(SprintInstance $sprintInstance): static
    {
        if (!$this->sprintInstances->contains($sprintInstance)) {
            $this->sprintInstances->add($sprintInstance);
            $sprintInstance->setProjectInstance($this);
        }

        return $this;
    }

    public function removeSprintInstance(SprintInstance $sprintInstance): static
    {
        if ($this->sprintInstances->removeElement($sprintInstance)) {
            // set the owning side to null (unless already changed)
            if ($sprintInstance->getProjectInstance() === $this) {
                $sprintInstance->setProjectInstance(null);
            }
        }

        return $this;
    }

    public function getIsFavory(): ?bool
    {
        return $this->isFavory;
    }

    public function setIsFavory(bool $isFavory): static
    {
        $this->isFavory = $isFavory;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getProjectInstances(): Collection
    {
        return $this->projectInstances;
    }

    public function addProjectInstances(self $projectInstances2): static
    {
        if (!$this->projectInstances->contains($projectInstances2)) {
            $this->projectInstances->add($projectInstances2);
            $projectInstances2->setParent($this);
        }

        return $this;
    }

    public function removeProjectInstances(self $projectInstances2): static
    {
        if ($this->projectInstances->removeElement($projectInstances2)) {
            // set the owning side to null (unless already changed)
            if ($projectInstances2->getParent() === $this) {
                $projectInstances2->setParent(null);
            }
        }

        return $this;
    }

    public function getConfigFramework(): ?ConfigProjectFramework
    {
        return $this->configFramework;
    }

    public function setConfigFramework(?ConfigProjectFramework $configFramework): static
    {
        $this->configFramework = $configFramework;

        return $this;
    }

    public function getPathFileDatabase()
    {
        return $this->pathFileDatabase;
    }

    public function setPathFileDatabase($pathFileDatabase)
    {
        $this->pathFileDatabase = $pathFileDatabase;

        return $this;
    }
}
