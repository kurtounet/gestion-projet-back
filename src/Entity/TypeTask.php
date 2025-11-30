<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TypeTaskRepository;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\TypeTask\TypeTaskResponseDto;
use App\Dto\TypeTask\TypeTaskUpdateDto;
use App\Dto\TypeTask\TypeTaskCreateDto;


use App\State\TypeTask\TypeTaskProvider;
use App\State\TypeTask\TypeTaskProcessor;

use App\Traits\TimestampTrait;


#[GetCollection(
    provider: TypeTaskProvider::class,
    output: TypeTaskResponseDto::class
)]
#[Get(
    provider: TypeTaskProvider::class,
    output: TypeTaskResponseDto::class
)]
#[Post(
    processor: TypeTaskProcessor::class,
    input: TypeTaskCreateDto::class
)]
#[Patch(
    processor: TypeTaskProcessor::class,
    input: TypeTaskUpdateDto::class
)]
#[Delete()]

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TypeTaskRepository::class)]
class TypeTask
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codeId = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $pathFileScript = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $automatique = null;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getCodeId(): ?int
    {
        return $this->codeId;
    }



    public function setCodeId(int $codeId): static
    {
        $this->codeId = $codeId;
        return $this;
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


    public function getPathFileScript(): ?string
    {
        return $this->pathFileScript;
    }



    public function setPathFileScript(string $pathFileScript): static
    {
        $this->pathFileScript = $pathFileScript;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }



    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }




    public function getAutomatique(): ?bool
    {
        return $this->automatique;
    }



    public function setAutomatique(bool $automatique): static
    {
        $this->automatique = $automatique;
        return $this;
    }
}
