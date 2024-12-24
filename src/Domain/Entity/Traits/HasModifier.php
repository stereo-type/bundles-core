<?php

declare(strict_types=1);

namespace AcademCity\CoreBundle\Domain\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\Security\Core\User\UserInterface;

/**Трейт для подключения к сущности и создания полей
 * $user_created и $user_modified
 * Накладывает ограничение применения - у конструктора сущности,
 * если он есть необходимо передавать пользователя
 * #[ORM\HasLifecycleCallbacks] прописать у класса сущности
 * */
trait HasModifier
{
    private ?UserInterface $user = null;

    public function __construct(?UserInterface $user)
    {
        $this->user = $user;
    }

    /**Так не сработает, просто для наглядности, класс подставится в листнере src/Infrastructure/EventListener/DoctrineMetadataListener.php*/
    #[ORM\ManyToOne(targetEntity: 'AcademCity\RoleModelBundle\Domain\Entity\Use')]
    private ?UserInterface $user_created = null;

    /**Так не сработает, просто для наглядности, класс подставится в листнере src/Infrastructure/EventListener/DoctrineMetadataListener.php*/
    #[ORM\ManyToOne(targetEntity: '%academ_city_core.user_class%')]
    private ?UserInterface $user_modified = null;

    #[PrePersist, PreUpdate]
    public function updateModifier(): void
    {
        if ($this->user) {
            if (!isset($this->user_created)) {
                $this->user_created = $this->user;
            }

            $this->user_modified = $this->user;
        }
    }

    public function getUserCreated(): ?UserInterface
    {
        return $this->user_created;
    }

    public function setUserCreated(?UserInterface $user_created): self
    {
        $this->user = $user_created;
        $this->user_created = $user_created;

        return $this;
    }

    public function getUserModified(): ?UserInterface
    {
        return $this->user_modified;
    }

    public function setUserModified(?UserInterface $user_modified): self
    {
        $this->user = $user_modified;
        $this->user_modified = $user_modified;

        return $this;
    }
}
