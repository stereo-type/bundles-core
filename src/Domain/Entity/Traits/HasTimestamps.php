<?php

declare(strict_types=1);

namespace CoreBundle\Domain\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

/**Трейт для подключения к сущности и создания полей
 * $time_created и $time_modified
 * #[ORM\HasLifecycleCallbacks] прописать у класса сущности
 * */
trait HasTimestamps
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $time_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $time_modified = null;

    #[PrePersist, PreUpdate]
    public function updateTimestamps(): void
    {
        if (!isset($this->time_created)) {
            $this->time_created = new DateTime();
        }

        $this->time_modified = new DateTime();
    }

    public function getTimeCreated(): ?DateTimeInterface
    {
        return $this->time_created;
    }

    public function setTimeCreated(DateTimeInterface $time_created): static
    {
        $this->time_created = $time_created;

        return $this;
    }

    public function getTimeModified(): ?DateTimeInterface
    {
        return $this->time_modified;
    }

    public function setTimeModified(DateTimeInterface $time_modified): static
    {
        $this->time_modified = $time_modified;

        return $this;
    }

}
