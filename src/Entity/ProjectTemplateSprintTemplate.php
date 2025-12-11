<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\ProjectTemplateSprintTemplateRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateResponseDto;

use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateProvider;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateProcessor;

#[GetCollection(
    provider: ProjectTemplateSprintTemplateProvider::class,
    output: ProjectTemplateSprintTemplateResponseDto::class
)]
#[Get(
    provider: ProjectTemplateSprintTemplateProvider::class,
    output: ProjectTemplateSprintTemplateResponseDto::class
)]
#[Post(
    processor: ProjectTemplateSprintTemplateProcessor::class,
    input: ProjectTemplateSprintTemplateCreateDto::class
)]
#[Patch(
    processor: ProjectTemplateSprintTemplateProcessor::class,
    input: ProjectTemplateSprintTemplateUpdateDto::class
)]
#[Delete(
    processor: ProjectTemplateSprintTemplateProcessor::class,
    output: false,
    status: 204
)]

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectTemplateSprintTemplateRepository::class)]
class ProjectTemplateSprintTemplate
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $sprintOrder = null;

    #[ORM\ManyToOne(targetEntity: ProjectTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectTemplate $projectTemplate = null;

    #[ORM\ManyToOne(targetEntity: SprintTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SprintTemplate $sprintTemplate = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getSprintTemplate(): ?SprintTemplate
    {
        return $this->sprintTemplate;
    }

    public function setSprintTemplate(?SprintTemplate $sprintTemplate): static
    {
        $this->sprintTemplate = $sprintTemplate;
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
}
