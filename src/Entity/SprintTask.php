<?php

namespace App\Entity;


use App\Repository\SprintTaskRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\SprintTask\SprintTaskResponseDto;
use App\Dto\SprintTask\SprintTaskUpdateDto;
use App\Dto\SprintTask\SprintTaskCreateDto;
use App\State\SprintTask\SprintTaskProvider;
use App\State\SprintTask\SprintTaskProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    // provider: SprintTaskProvider::class,
    // output: SprintTaskResponseDto::class
)]
#[Get(
    // provider: SprintTaskProvider::class,
    // output: SprintTaskResponseDto::class
)]
#[Post(
    processor: SprintTaskProcessor::class,
    input: SprintTaskCreateDto::class
)]
#[Patch(
    processor: SprintTaskProcessor::class,
    input: SprintTaskUpdateDto::class
)]
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SprintTaskRepository::class)]
class SprintTask
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $taskOrder = null;

    #[ORM\ManyToOne(targetEntity: SprintTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SprintTemplate $sprintTemplate = null;

    #[ORM\ManyToOne(targetEntity: TaskTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TaskTemplate $taskTemplate = null;







    public function getId(): ?int
    {
        return $this->id;
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

    public function getTaskTemplate(): ?TaskTemplate
    {
        return $this->taskTemplate;
    }

    public function setTaskTemplate(?TaskTemplate $taskTemplate): static
    {
        $this->taskTemplate = $taskTemplate;
        return $this;
    }


    public function getTaskOrder(): ?int
    {
        return $this->taskOrder;
    }



    public function setTaskOrder(int $taskOrder): static
    {
        $this->taskOrder = $taskOrder;
        return $this;
    }
}
