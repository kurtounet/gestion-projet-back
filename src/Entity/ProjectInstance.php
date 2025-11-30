<?php

namespace App\Entity;


use App\Repository\ProjectInstanceRepository;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\ProjectInstance\ProjectInstanceResponseDto;
use App\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\State\ProjectInstance\ProjectInstanceProvider;
use App\State\ProjectInstance\ProjectInstanceProcessor;
use App\Traits\TimestampTrait;

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
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectInstanceRepository::class)]
class ProjectInstance
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $statusId = null;

    #[ORM\Column]
    private ?int $priorityId = null;

    #[ORM\Column]
    private ?int $projectTemplateId = null;

    #[ORM\Column]
    private ?int $commentId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $endDate = null;








    public function getId(): ?int
    {
        return $this->id;
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


    public function getPriorityId(): ?int
    {
        return $this->priorityId;
    }



    public function setPriorityId(int $priorityId): static
    {
        $this->priorityId = $priorityId;
        return $this;
    }


    public function getProjectTemplateId(): ?int
    {
        return $this->projectTemplateId;
    }



    public function setProjectTemplateId(int $projectTemplateId): static
    {
        $this->projectTemplateId = $projectTemplateId;
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
}
