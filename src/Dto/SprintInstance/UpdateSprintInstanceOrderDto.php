<?php

namespace App\Dto\SprintInstance;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Serializer\Attribute\Groups as AttributeGroups;

final class UpdateSprintInstanceOrderDto
{
    /**
     * @var list<SprintInstanceOrderItemDto>
     */
    #[Assert\NotBlank]
    #[Assert\Valid]
    #[AttributeGroups(['sprint_order:write'])]
    public array $sprints = [];
}
