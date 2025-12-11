<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait UserStampTrait
{
    #[ORM\Column(name: 'created_by_user', type: 'string', length: 180, nullable: true)]
    private ?string $createdByUser = null;

    #[ORM\Column(name: 'updated_by_user', type: 'string', length: 180, nullable: true)]
    private ?string $updatedByUser = null;

    public function getCreatedByUser(): ?string
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(?string $userIdentifier): static
    {
        $this->createdByUser = $userIdentifier;
        return $this;
    }

    public function getUpdatedByUser(): ?string
    {
        return $this->updatedByUser;
    }

    public function setUpdatedByUser(?string $userIdentifier): static
    {
        $this->updatedByUser = $userIdentifier;
        return $this;
    }
}
