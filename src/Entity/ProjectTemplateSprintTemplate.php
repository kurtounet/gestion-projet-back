<?php

namespace App\Entity;

use App\Repository\ProjectTemplateSprintTemplateRepository;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

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
