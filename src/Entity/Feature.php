<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\FeatureRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Feature\FeatureCreateDto;
use App\ApiResource\Dto\Feature\FeatureUpdateDto;
use App\ApiResource\Dto\Feature\FeatureResponseDto;

use App\ApiResource\State\Feature\FeatureProcessor;
use App\ApiResource\State\Feature\FeatureProvider;

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
#[Delete(
    processor: FeatureProcessor::class,
    output: false
)]



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
