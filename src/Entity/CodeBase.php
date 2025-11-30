<?php

namespace App\Entity;


use App\Repository\CodeBaseRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\CodeBase\CodeBaseResponseDto;
use App\Dto\CodeBase\CodeBaseUpdateDto;
use App\Dto\CodeBase\CodeBaseCreateDto;
use App\State\CodeBase\CodeBaseProvider;
use App\State\CodeBase\CodeBaseProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: CodeBaseProvider::class,
    output: CodeBaseResponseDto::class
)]
#[Get(
    provider: CodeBaseProvider::class,
    output: CodeBaseResponseDto::class
)]
#[Post(
    processor: CodeBaseProcessor::class,
    input: CodeBaseCreateDto::class
)]
#[Patch(
    processor: CodeBaseProcessor::class,
    input: CodeBaseUpdateDto::class
)]
#[Delete()]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CodeBaseRepository::class)]
class CodeBase
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $pathFile = null;

    #[ORM\Column(length: 255)]
    private ?string $feature = null;

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


    public function getCode(): ?string
    {
        return $this->code;
    }



    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }


    public function getPathFile(): ?string
    {
        return $this->pathFile;
    }



    public function setPathFile(string $pathFile): static
    {
        $this->pathFile = $pathFile;
        return $this;
    }


    public function getFeature(): ?string
    {
        return $this->feature;
    }



    public function setFeature(string $feature): static
    {
        $this->feature = $feature;
        return $this;
    }
}
