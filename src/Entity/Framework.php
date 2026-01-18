<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FrameworkRepository;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FrameworkRepository::class)]
class Framework
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(length: 10)]
    private ?string $type = null;

    #[ORM\Column(length: 10)]
    private ?string $version = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?array $configuration = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $color = null;

    /**
     * @var Collection<int, ConfigProjectFramework>
     */
    #[ORM\OneToMany(targetEntity: ConfigProjectFramework::class, mappedBy: 'framework')]
    private Collection $configProjectFrameworks;

    #[ORM\ManyToOne(inversedBy: 'framework')]
    private ?Technology $technology = null;

    public function __construct()
    {
        $this->configProjectFrameworks = new ArrayCollection();
    }

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
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }

    public function setConfiguration(?array $configuration): static
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }


    /**
     * @return Collection<int, ConfigProjectFramework>
     */
    public function getConfigProjectFrameworks(): Collection
    {
        return $this->configProjectFrameworks;
    }

    public function addConfigProjectFramework(ConfigProjectFramework $configProjectFramework): static
    {
        if (!$this->configProjectFrameworks->contains($configProjectFramework)) {
            $this->configProjectFrameworks->add($configProjectFramework);
            $configProjectFramework->setFramework($this);
        }

        return $this;
    }

    public function removeConfigProjectFramework(ConfigProjectFramework $configProjectFramework): static
    {
        if ($this->configProjectFrameworks->removeElement($configProjectFramework)) {
            // set the owning side to null (unless already changed)
            if ($configProjectFramework->getFramework() === $this) {
                $configProjectFramework->setFramework(null);
            }
        }

        return $this;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): static
    {
        $this->technology = $technology;

        return $this;
    }
}
