<?php

namespace App\Entity;

use App\Repository\PriorityRepository;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PriorityRepository::class)]
class Priority
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['projectInstance:item', 'priority:list:read', 'priority:item:read'])]
    private ?string $label = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['projectInstance:item', 'priority:list:read', 'priority:item:read'])]
    private ?string $color = '#84e712ff';

    #[ORM\Column]
    private ?int $priorityNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPriorityNumber(): ?int
    {
        return $this->priorityNumber;
    }

    public function setPriorityNumber(int $priorityNumber): static
    {
        $this->priorityNumber = $priorityNumber;

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
}
