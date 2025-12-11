<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FrameworkRepository;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use App\ApiResource\Dto\Framework\FrameworkUpdateDto;
use App\ApiResource\Dto\Framework\FrameworkResponseDto;


use App\ApiResource\State\Framework\FrameworkProcessor;
use App\ApiResource\State\Framework\FrameworkProvider;

#[GetCollection(
    provider: FrameworkProvider::class,
    output: FrameworkResponseDto::class
)]
#[Get(
    provider: FrameworkProvider::class,
    output: FrameworkResponseDto::class
)]
#[Post(
    processor: FrameworkProcessor::class,
    input: FrameworkCreateDto::class
)]
#[Patch(
    processor: FrameworkProcessor::class,
    input: FrameworkUpdateDto::class
)]
#[Delete(
    processor: FrameworkProcessor::class,
    output: false,
    status: 204
)]

#[ApiResource]
#[ORM\Entity(repositoryClass: FrameworkRepository::class)]
class Framework
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $version = null;

    #[ORM\Column(nullable: true)]
    private ?array $configuration = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $color = null;

    #[ORM\ManyToOne(inversedBy: 'framework', cascade: ['persist', 'remove'])]
    private ?Technology $technology = null;

    /**
     * @var Collection<int, ConfigProjectFramework>
     */
    #[ORM\OneToMany(targetEntity: ConfigProjectFramework::class, mappedBy: 'framework')]
    private Collection $configProjectFrameworks;

    public function __construct()
    {
        $this->configProjectFrameworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): static
    {
        $this->technology = $technology;

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
}
