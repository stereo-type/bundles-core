<?php

namespace AcademCity\CoreBundle\Domain\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * "Стандартное поле" active для Entity.
 */
trait ActiveEntityTrait
{
    #[Groups(['active:read', 'active:write'])]
    #[ORM\Column(options: ['default' => true])]
    private bool $active = true;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
