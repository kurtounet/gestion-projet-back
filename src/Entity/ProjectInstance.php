<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProjectInstanceRepository;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampTrait;


use App\Dto\ProjectInstance\ProjectInstanceResponseDto;
use App\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\State\ProjectInstance\ProjectInstanceProvider;
use App\State\ProjectInstance\ProjectInstanceProcessor;
use Symfony\Component\Serializer\Attribute\Groups;

#[GetCollection(

    // normalizationContext: ['groups' => ['list:read']],
    // provider: ProjectInstanceProvider::class,
    // output: ProjectInstanceResponseDto::class
)]
#[Get(
    // normalizationContext: ['groups' => ['projectInstance:item', 'item:read']],
    // provider: ProjectInstanceProvider::class,
    // output: ProjectInstanceResponseDto::class
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
    // processor: ProjectInstanceProcessor::class,
    // output: false,
)]

// #[ApiFilter(SearchFilter::class, properties: [
//     'isFavory' => 'true',
// ])]
#[ApiFilter(BooleanFilter::class, properties: [
    'isFavory' => 'true',
])]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
    'projectInstance' => ProjectInstance::class,
    'framework' => Framework::class,
])]
#[ApiResource()]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectInstanceRepository::class)]
class ProjectInstance
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list:read', 'item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['list:read', 'item:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list:read', 'item:read'])]
    private ?string $pathFileDatabase = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['list:read', 'item:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['list:read', 'item:read'])]
    private ?string $icon = null;

    #[ORM\Column(length: 7, nullable: true)]
    #[Groups(['list:read', 'item:read'])]
    private ?string $color = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups(['list:read', 'item:read'])]
    private ?bool $isFavory = null;

    #[ORM\Column]
    #[Groups(['list:read', 'item:read'])]
    private ?int $position = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list:read', 'item:read'])]
    private ?string $pathProject = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['list:read', 'item:read'])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['list:read', 'item:read'])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['list:read', 'item:read'])]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['list:read', 'item:read'])]
    private ?Priority $priority = null;

    #[ORM\ManyToOne(targetEntity: ProjectTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['list:read', 'item:read'])]
    private ?ProjectTemplate $projectTemplate = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    #[Groups(['list:read', 'item:read'])]
    private ?Comment $comment = null;

    /**
     * @var Collection<int, SprintInstance>
     */
    #[ORM\OneToMany(targetEntity: SprintInstance::class, mappedBy: 'projectInstance')]
    #[Groups(['projectInstance:item'])]
    private Collection $sprintInstances;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'projectInstances')]
    private ?self $parent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $projectInstances;

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

    public function getpathProject(): ?string
    {
        return $this->pathProject;
    }

    public function setpathProject(?string $path): static
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

    public function addProjectInstance(self $projectInstance): static
    {
        if (!$this->projectInstances->contains($projectInstance)) {
            $this->projectInstances->add($projectInstance);
            $projectInstance->setParent($this);
        }

        return $this;
    }

    public function removeProjectInstance(self $projectInstance): static
    {
        if ($this->projectInstances->removeElement($projectInstance)) {
            // set the owning side to null (unless already changed)
            if ($projectInstance->getParent() === $this) {
                $projectInstance->setParent(null);
            }
        }

        return $this;
    }
}
