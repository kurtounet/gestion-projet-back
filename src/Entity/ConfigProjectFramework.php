<?php

namespace App\Entity;

use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\ConfigProjectFrameworkRepository;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCreateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkUpdateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkResponseDto;

use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkProcessor;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkProvider;

#[GetCollection(
    provider: ConfigProjectFrameworkProvider::class,
    output: ConfigProjectFrameworkResponseDto::class
)]

#[Get(
    provider: ConfigProjectFrameworkProvider::class,
    output: ConfigProjectFrameworkResponseDto::class
)]
#[Post(
    processor: ConfigProjectFrameworkProcessor::class,
    input: ConfigProjectFrameworkCreateDto::class
)]
#[Patch(
    processor: ConfigProjectFrameworkProcessor::class,
    input: ConfigProjectFrameworkUpdateDto::class
)]
#[Delete(
    processor: ConfigProjectFrameworkProcessor::class,
    output: false,
    status: 204
)]

#[ApiResource]
#[ORM\Entity(repositoryClass: ConfigProjectFrameworkRepository::class)]
class ConfigProjectFramework
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $configuration = null;

    #[ORM\Column(nullable: true)]
    private ?array $architecture = null;

    #[ORM\Column(nullable: true)]
    private ?array $script = null;

    #[ORM\OneToOne(mappedBy: 'configFramework', cascade: ['persist', 'remove'])]
    private ?ProjectInstance $projectInstance = null;

    #[ORM\ManyToOne(inversedBy: 'configProjectFrameworks')]
    private ?Framework $framework = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArchitecture(): ?array
    {
        return $this->architecture;
    }

    public function setArchitecture(?array $architecture): static
    {
        $this->architecture = $architecture;

        return $this;
    }

    public function getScript(): ?array
    {
        return $this->script;
    }

    public function setScript(?array $script): static
    {
        $this->script = $script;

        return $this;
    }

    public function getProjectInstance(): ?ProjectInstance
    {
        return $this->projectInstance;
    }

    public function setProjectInstance(?ProjectInstance $projectInstance): static
    {
        // unset the owning side of the relation if necessary
        if ($projectInstance === null && $this->projectInstance !== null) {
            $this->projectInstance->setConfigFramework(null);
        }

        // set the owning side of the relation if necessary
        if ($projectInstance !== null && $projectInstance->getConfigFramework() !== $this) {
            $projectInstance->setConfigFramework($this);
        }

        $this->projectInstance = $projectInstance;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getFramework(): ?Framework
    {
        return $this->framework;
    }

    public function setFramework(?Framework $framework): static
    {
        $this->framework = $framework;

        return $this;
    }
}
