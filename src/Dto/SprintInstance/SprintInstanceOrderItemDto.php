<?php

namespace App\Dto\SprintInstance;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintInstanceOrderItemDto
{
    #[Assert\NotNull]
    #[Groups(['sprint_order:write'])]
    public int $id;

    #[Assert\NotNull]
    #[Groups(['sprint_order:write'])]
    public int $position;
}
