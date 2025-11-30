<?php

namespace App\Entity;


use App\Repository\ProjectTemplateSprintTemplateRepository;
/*

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

*/

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateResponseDto;
use App\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;
use App\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateProvider;
use App\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateProcessor;

/*

#[GetCollection(
    provider: ProjectTemplateSprintTemplateProvider::class,
    output: ProjectTemplateSprintTemplateResponseDto::class
)]
#[Get(
    provider: ProjectTemplateSprintTemplateProvider::class,
    output: ProjectTemplateSprintTemplateResponseDto::class
)]
#[Post(
    processor:ProjectTemplateSprintTemplateProcessor::class,
    input: ProjectTemplateSprintTemplateCreateDto::class
)]
#[Patch(
    processor: ProjectTemplateSprintTemplateProcessor::class,
    input: ProjectTemplateSprintTemplateUpdateDto::class
)]
#[Delete()]

*/
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: ProjectTemplateSprintTemplateRepository::class)]
class ProjectTemplateSprintTemplate
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $projectTemplateId = null;

    #[ORM\Column]
    private ?int $sprintTemplateId = null;

    #[ORM\Column]
    private ?int $sprintOrder = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;






    public function getId(): ?int
    {
        return $this->id;
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


    public function getSprintTemplateId(): ?int
    {
        return $this->sprintTemplateId;
    }



    public function setSprintTemplateId(int $sprintTemplateId): static
    {
        $this->sprintTemplateId = $sprintTemplateId;
        return $this;
    }


    public function getSprintOrder(): ?int
    {
        return $this->sprintOrder;
    }



    public function setSprintOrder(int $sprintOrder): static
    {
        $this->sprintOrder = $sprintOrder;
        return $this;
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }



    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }



    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
