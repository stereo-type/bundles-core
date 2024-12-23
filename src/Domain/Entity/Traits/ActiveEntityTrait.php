<?php

namespace CoreBundle\Domain\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * "Стандартное поле" delete для Entity.
 */
trait ActiveEntityTrait
{
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
