<?php

namespace App\Entity;


use App\Repository\FeatureRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Feature\FeatureResponseDto;
use App\Dto\Feature\FeatureUpdateDto;
use App\Dto\Feature\FeatureCreateDto;
use App\State\Feature\FeatureProvider;
use App\State\Feature\FeatureProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: FeatureProvider::class,
    output: FeatureResponseDto::class
)]
#[Get(
    provider: FeatureProvider::class,
    output: FeatureResponseDto::class
)]
#[Post(
    processor: FeatureProcessor::class,
    input: FeatureCreateDto::class
)]
#[Patch(
    processor: FeatureProcessor::class,
    input: FeatureUpdateDto::class
)]
#[Delete()]



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
