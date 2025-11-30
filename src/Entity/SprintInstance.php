<?php

namespace App\Entity;


use App\Repository\SprintInstanceRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\SprintInstance\SprintInstanceResponseDto;
use App\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\Dto\SprintInstance\SprintInstanceCreateDto;
use App\State\SprintInstance\SprintInstanceProvider;
use App\State\SprintInstance\SprintInstanceProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: SprintInstanceProvider::class,
    output: SprintInstanceResponseDto::class
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
#[Delete()]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SprintInstanceRepository::class)]
class SprintInstance
{
    use TimestampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $projectInstanceId = null;

    #[ORM\Column]
    private ?int $priorityId = null;

    #[ORM\Column]
    private ?int $sprintTemplateId = null;

    #[ORM\Column]
    private ?int $sprintDependencyId = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column]
    private ?int $statusId = null;

    #[ORM\Column]
    private ?int $order = null;

    #[ORM\Column]
    private ?int $commentId = null;







    public function getId(): ?int
    {
        return $this->id;
    }



    public function getProjectInstanceId(): ?int
    {
        return $this->projectInstanceId;
    }



    public function setProjectInstanceId(int $projectInstanceId): static
    {
        $this->projectInstanceId = $projectInstanceId;
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


    public function getSprintTemplateId(): ?int
    {
        return $this->sprintTemplateId;
    }



    public function setSprintTemplateId(int $sprintTemplateId): static
    {
        $this->sprintTemplateId = $sprintTemplateId;
        return $this;
    }


    public function getSprintDependencyId(): ?int
    {
        return $this->sprintDependencyId;
    }



    public function setSprintDependencyId(int $sprintDependencyId): static
    {
        $this->sprintDependencyId = $sprintDependencyId;
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


    public function getStatusId(): ?int
    {
        return $this->statusId;
    }



    public function setStatusId(int $statusId): static
    {
        $this->statusId = $statusId;
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
