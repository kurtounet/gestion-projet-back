<?php

namespace App\Entity;

use App\Repository\ContextRepository;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContextRepository::class)]
class Context
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $contextLabel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContextLabel(): ?string
    {
        return $this->contextLabel;
    }

    public function setContextLabel(string $contextLabel): static
    {
        $this->contextLabel = $contextLabel;

        return $this;
    }
}
