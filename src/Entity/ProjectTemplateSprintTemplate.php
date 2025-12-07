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
use App\Traits\TimestampTrait;

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
