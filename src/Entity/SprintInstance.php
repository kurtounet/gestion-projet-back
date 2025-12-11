<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\SprintInstanceRepository;
use Symfony\Component\Serializer\Attribute\Groups;

use App\Traits\UserStampTrait;
use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceResponseDto;

use App\ApiResource\State\SprintInstance\SprintInstanceProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceProcessor;

#[GetCollection(
    provider: SprintInstanceProvider::class,
    output: SprintInstanceResponseDto::class,
)]
#[Get(
    provider: SprintInstanceProvider::class,
    output: SprintInstanceResponseDto::class
)]
#[Post(
    processor: SprintInstanceProcessor::class,
    input: SprintInstanceCreateDto::class
)]
#[Patch(
    processor: SprintInstanceProcessor::class,
    input: SprintInstanceUpdateDto::class
)]
#[Delete(processor: SprintInstanceProcessor::class, output: false, status: 204)]
/* A restester
#[Patch(

    uriTemplate: 'sprint_instances/order',
    name: 'sprint_instances_update_order',
    input: UpdateSprintInstanceOrderDto::class,
    output: false,
    provider: null,   // très important : on ne veut PAS de provider ici
    denormalizationContext: ['groups' => ['sprint_order:write']],
    processor: UpdateSprintInstanceOrderProcessor::class,
    status: 204
)]
*/

#[ApiResource()]
#[ORM\HasLifecycleCallbacks]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
    'color' => 'partial',
    'priority' => 'exact',
    'status' => 'exact',

    // Relation directe
    'projectInstance' => 'exact',

    // Champs internes à la relation
    'projectInstance.id' => 'exact',
    'projectInstance.color' => 'partial'
])]
#[ORM\Entity(repositoryClass: SprintInstanceRepository::class)]
class SprintInstance
{
    use TimestampTrait;
    use UserStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups(['sprint:list:read', 'item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['projectInstance:item', 'sprint:list:read', 'item:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['sprint:list:read', 'item:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    #[Groups(['projectInstance:item', 'sprint:list:read', 'item:read'])]
    private ?string $icon = null;

    #[ORM\Column(length: 7)]
    #[Groups(['projectInstance:item', 'sprint:list:read', 'item:read'])]
    private ?string $color = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['projectInstance:item', 'sprint:list:read', 'item:read'])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['projectInstance:item', 'sprint:list:read', 'item:read'])]
    private ?\DateTimeImmutable $endDate = null;

    #[Groups(['projectInstance:item', 'sprint:list:read', 'item:read'])]
    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[Groups(['projectInstance:item', 'item:read'])]
    #[ORM\ManyToOne(targetEntity: Priority::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Priority $priority = null;

    #[Groups(['projectInstance:item', 'item:read'])]
    #[ORM\ManyToOne(targetEntity: SprintTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SprintTemplate $sprintTemplate = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['projectInstance:item', 'item:read'])]
    private ?Status $status = null;

    #[ORM\ManyToOne(targetEntity: Comment::class)]
    #[Groups(['projectInstance:item', 'item:read'])]
    private ?Comment $comment = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['projectInstance:item', 'item:read'])]
    private ?self $sprintDependency = null;

    #[ORM\ManyToOne(inversedBy: 'sprintInstances')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['projectInstance:item', 'item:read '])]
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
