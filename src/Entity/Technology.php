<?php

namespace App\Entity;

use App\Repository\TechnologyRepository;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TechnologyRepository::class)]
class Technology
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    /**
     * @var Collection<int, Framework>
     */
    #[ORM\OneToMany(targetEntity: Framework::class, mappedBy: 'technology')]
    private Collection $framework;

    public function __construct()
    {
        $this->framework = new ArrayCollection();
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

    /**
     * @return Collection<int, Framework>
     */
    public function getFramework(): Collection
    {
        return $this->framework;
    }

    public function addFramework(Framework $framework): static
    {
        if (!$this->framework->contains($framework)) {
            $this->framework->add($framework);
            $framework->setTechnology($this);
        }

        return $this;
    }

    public function removeFramework(Framework $framework): static
    {
        if ($this->framework->removeElement($framework)) {
            // set the owning side to null (unless already changed)
            if ($framework->getTechnology() === $this) {
                $framework->setTechnology(null);
            }
        }

        return $this;
    }
}
