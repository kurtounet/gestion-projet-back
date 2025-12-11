<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampTrait;
use App\Repository\ContextRepository;


use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Context\ContextCreateDto;
use App\ApiResource\Dto\Context\ContextResponseDto;
use App\ApiResource\Dto\Context\ContextUpdateDto;

use App\ApiResource\State\Context\ContextProcessor;
use App\ApiResource\State\Context\ContextProvider;



#[GetCollection(
    provider: ContextProvider::class,
    output: ContextResponseDto::class
)]
#[Get(
    provider: ContextProvider::class,
    output: ContextResponseDto::class
)]
#[Post(
    processor: ContextProcessor::class,
    input: ContextCreateDto::class
)]
#[Patch(
    processor: ContextProcessor::class,
    input: ContextUpdateDto::class
)]
#[Delete(
    processor: ContextProcessor::class,
    output: false
)]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContextRepository::class)]
class Context
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $contextLabel = null;








    public function getId(): ?int
    {
        return $this->id;
    }



    public function getContextLabel(): ?string
    {
        return $this->contextLabel;
    }



    public function setContextLabel(string $contextLabel): static
    {
        $this->contextLabel = $contextLabel;
        return $this;
    }
}
