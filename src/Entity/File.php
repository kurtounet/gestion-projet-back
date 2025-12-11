<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FileRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\File\FileCreateDto;
use App\ApiResource\Dto\File\FileUpdateDto;
use App\ApiResource\Dto\File\FileResponseDto;

use App\ApiResource\State\File\FileProcessor;
use App\ApiResource\State\File\FileProvider;

#[GetCollection(
    provider: FileProvider::class,
    output: FileResponseDto::class
)]
#[Get(
    provider: FileProvider::class,
    output: FileResponseDto::class
)]
#[Post(
    processor: FileProcessor::class,
    input: FileCreateDto::class
)]
#[Patch(
    processor: FileProcessor::class,
    input: FileUpdateDto::class
)]
#[Delete(
    processor: FileProcessor::class,
    output: false
)]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $keyWord = null;






    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPath(): ?string
    {
        return $this->path;
    }



    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }


    public function getKeyWord(): ?string
    {
        return $this->keyWord;
    }



    public function setKeyWord(string $keyWord): static
    {
        $this->keyWord = $keyWord;
        return $this;
    }
}
