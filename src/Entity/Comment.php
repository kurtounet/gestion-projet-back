<?php

namespace App\Entity;


use App\Repository\CommentRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Comment\CommentResponseDto;
use App\Dto\Comment\CommentUpdateDto;
use App\Dto\Comment\CommentCreateDto;
use App\State\Comment\CommentProvider;
use App\State\Comment\CommentProcessor;
use App\Traits\TimestampTrait;

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
#[Delete()]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $taskId = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $content = null;








    public function getId(): ?int
    {
        return $this->id;
    }



    public function getTaskId(): ?int
    {
        return $this->taskId;
    }



    public function setTaskId(int $taskId): static
    {
        $this->taskId = $taskId;
        return $this;
    }


    public function getUserId(): ?int
    {
        return $this->userId;
    }



    public function setUserId(int $userId): static
    {
        $this->userId = $userId;
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
