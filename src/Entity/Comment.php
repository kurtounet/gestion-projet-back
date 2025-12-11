<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;

use App\Traits\TimestampTrait;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use App\ApiResource\Dto\Comment\CommentCreateDto;
use App\ApiResource\Dto\Comment\CommentUpdateDto;
use App\ApiResource\Dto\Comment\CommentResponseDto;

use App\ApiResource\State\Comment\CommentProcessor;
use App\ApiResource\State\Comment\CommentProvider;


#[GetCollection(
    provider: CommentProvider::class,
    output: CommentResponseDto::class
)]
#[Get(
    provider: CommentProvider::class,
    output: CommentResponseDto::class
)]
#[Post(
    processor: CommentProcessor::class,
    input: CommentCreateDto::class
)]
#[Patch(
    processor: CommentProcessor::class,
    input: CommentUpdateDto::class
)]
#[Delete(
    processor: CommentProcessor::class,
    output: false
)]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: TaskInstance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TaskInstance $task = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?TaskInstance
    {
        return $this->task;
    }

    public function setTask(?TaskInstance $task): static
    {
        $this->task = $task;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }


    public function getSubject(): ?string
    {
        return $this->subject;
    }



    public function setSubject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }



    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }
}
