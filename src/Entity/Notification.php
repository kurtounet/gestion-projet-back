<?php

namespace App\Entity;


use App\Repository\NotificationRepository;


use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use App\Dto\Notification\NotificationResponseDto;
use App\Dto\Notification\NotificationUpdateDto;
use App\Dto\Notification\NotificationCreateDto;
use App\State\Notification\NotificationProvider;
use App\State\Notification\NotificationProcessor;
use App\Traits\TimestampTrait;

#[GetCollection(
    provider: NotificationProvider::class,
    output: NotificationResponseDto::class
)]
#[Get(
    provider: NotificationProvider::class,
    output: NotificationResponseDto::class
)]
#[Post(
    processor: NotificationProcessor::class,
    input: NotificationCreateDto::class
)]
#[Patch(
    processor: NotificationProcessor::class,
    input: NotificationUpdateDto::class
)]
#[Delete()]


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;






    public function getId(): ?int
    {
        return $this->id;
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


    public function getMessage(): ?string
    {
        return $this->message;
    }



    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }


    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }



    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;
        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }



    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }
}
