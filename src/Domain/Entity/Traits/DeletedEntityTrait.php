<?php

namespace AcademCity\CoreBundleDomain\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * "Стандартное поле" delete для Entity.
 */
trait DeletedEntityTrait
{
    #[ORM\Column(options: ['default' => false])]
    private bool $delete = false;

    public function isDelete(): bool
    {
        return $this->delete;
    }

    public function setDelete(bool $delete): self
    {
        $this->delete = $delete;

        return $this;
    }
}
