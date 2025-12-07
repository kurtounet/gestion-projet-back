<?php

namespace App\Entity;


use App\Repository\TechnologyRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Technology\TechnologyResponseDto;
use App\Dto\Technology\TechnologyUpdateDto;
use App\Dto\Technology\TechnologyCreateDto;
use App\State\Technology\TechnologyProvider;
use App\State\Technology\TechnologyProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    // provider: TechnologyProvider::class,
    // output: TechnologyResponseDto::class
)]
#[Get(
    // provider: TechnologyProvider::class,
    // output: TechnologyResponseDto::class
)]
#[Post(
    // processor: TechnologyProcessor::class,
    // input: TechnologyCreateDto::class
)]
#[Patch(
    // processor: TechnologyProcessor::class,
    // input: TechnologyUpdateDto::class
)]
#[Delete()]



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
