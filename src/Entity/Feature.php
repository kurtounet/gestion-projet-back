<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\FeatureRepository;

use App\Traits\TimestampTrait;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FeatureRepository::class)]
class Feature
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;






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
}
