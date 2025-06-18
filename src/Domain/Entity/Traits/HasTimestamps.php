<?php

declare(strict_types=1);

namespace AcademCity\CoreBundle\Domain\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

/**Трейт для подключения к сущности и создания полей
 * $time_created и $time_modified
 * */
trait HasTimestamps
{
    #[Groups(['timestamps:read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_created = null;

    #[Groups(['timestamps:read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_modified = null;

    /**Вызывается в TimeModifiedListener*/
    public function updateTimestamps(): void
    {
        if (null === $this->getTimeCreated()) {
            $this->setTimeCreated(new \DateTime());
        }

        $this->setTimeModified(new \DateTime());
    }

    public function getTimeCreated(): ?\DateTimeInterface
    {
        return $this->time_created;
    }

    public function setTimeCreated(\DateTimeInterface $time_created): static
    {
        $this->time_created = $time_created;

        return $this;
    }

    public function getTimeModified(): ?\DateTimeInterface
    {
        return $this->time_modified;
    }

    public function setTimeModified(\DateTimeInterface $time_modified): static
    {
        $this->time_modified = $time_modified;

        return $this;
    }
}
