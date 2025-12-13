<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Repository\TechnologyRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Technology\TechnologyCreateDto;
use App\ApiResource\Dto\Technology\TechnologyUpdateDto;
use App\ApiResource\Dto\Technology\TechnologyResponseDto;

use App\ApiResource\State\Technology\TechnologyProvider;
use App\ApiResource\State\Technology\TechnologyProcessor;

#[GetCollection(
    // provider: TechnologyProvider::class,
    // output: TechnologyResponseDto::class
)]
#[Get(
    // provider: TechnologyProvider::class,
    // output: TechnologyResponseDto::class
)]
#[Post(
    processor: TechnologyProcessor::class,
    input: TechnologyCreateDto::class
)]
#[Patch(
    processor: TechnologyProcessor::class,
    input: TechnologyUpdateDto::class
)]
#[Delete(
    processor: TechnologyProcessor::class,
    output: false,
    status: 204
)]

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TechnologyRepository::class)]
class Technology
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['projectInstance:item', 'list:read', 'item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['projectInstance:item', 'list:read', 'item:read'])]
    private ?string $label = null;

    #[Groups(['projectInstance:item', 'list:read', 'item:read'])]
    #[ORM\OneToMany(mappedBy: 'technology', targetEntity: Framework::class, cascade: ['persist', 'remove'])]
    private ?Framework $framework = null;

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

    public function getFramework(): ?Framework
    {
        return $this->framework;
    }

    public function setFramework(?Framework $framework): static
    {
        // unset the owning side of the relation if necessary
        if ($framework === null && $this->framework !== null) {
            $this->framework->setTechnology(null);
        }

        // set the owning side of the relation if necessary
        if ($framework !== null && $framework->getTechnology() !== $this) {
            $framework->setTechnology($this);
        }

        $this->framework = $framework;

        return $this;
    }
}
