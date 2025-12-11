<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Repository\ProjectInstanceRepository;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

use App\Traits\UserStampTrait;
use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceResponseDto;

use App\ApiResource\State\ProjectInstance\ProjectInstanceProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceProcessor;

use Symfony\Component\Serializer\Attribute\Groups;

#[GetCollection(
    provider: ProjectInstanceProvider::class,
    output: ProjectInstanceResponseDto::class
)]

#[Get(
    provider: ProjectInstanceProvider::class,
    output: ProjectInstanceResponseDto::class
)]
#[Post(
    processor: ProjectInstanceProcessor::class,
    input: ProjectInstanceCreateDto::class
)]
#[Patch(
    processor: ProjectInstanceProcessor::class,
    input: ProjectInstanceUpdateDto::class
)]
#[Delete(
    processor: ProjectInstanceProcessor::class,
    output: false,
)]


#[ApiFilter(BooleanFilter::class, properties: [
    'isFavory' => 'true',
])]

#[ApiResource]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectInstanceRepository::class)]
class ProjectInstance
{
    use UserStampTrait;
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    protected ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?string $pathFileDatabase = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?string $pathProject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?string $icon = null;

    #[ORM\Column(length: 7, nullable: true)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?string $color = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?bool $isFavory = null;

    #[ORM\Column]
    // #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?int $position = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?Priority $priority = null;

    #[ORM\ManyToOne(targetEntity: ProjectTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?ProjectTemplate $projectTemplate = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    #[Groups(['PI:list:read', 'PI:item:read'])]
    private ?Comment $comment = null;

    /**
     * @var Collection<int, SprintInstance>
     */
    #[ORM\OneToMany(targetEntity: SprintInstance::class, mappedBy: 'projectInstance')] //, orphanRemoval: true
    #[Groups(['PI:item:read'])]
    private Collection $sprintInstances;
    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    #[Groups(['PI:item:read'])]
    private Collection $projectInstances;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'projectInstances')]
    private ?self $parent = null;

    #[ORM\OneToOne(inversedBy: 'projectInstance', cascade: ['persist', 'remove'])]
    #[Groups(['PI:item:read'])]
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

    public function isFavory(): ?bool
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
