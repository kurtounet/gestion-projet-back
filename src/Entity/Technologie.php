<?php

namespace App\Entity;


use App\Repository\TechnologieRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Technologie\TechnologieResponseDto;
use App\Dto\Technologie\TechnologieUpdateDto;
use App\Dto\Technologie\TechnologieCreateDto;
use App\State\Technologie\TechnologieProvider;
use App\State\Technologie\TechnologieProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: TechnologieProvider::class,
    output: TechnologieResponseDto::class
)]
#[Get(
    provider: TechnologieProvider::class,
    output: TechnologieResponseDto::class
)]
#[Post(
    processor: TechnologieProcessor::class,
    input: TechnologieCreateDto::class
)]
#[Patch(
    processor: TechnologieProcessor::class,
    input: TechnologieUpdateDto::class
)]
#[Delete()]



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TechnologieRepository::class)]
class Technologie
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
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
