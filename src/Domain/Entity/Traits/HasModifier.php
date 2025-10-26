<?php

declare(strict_types=1);

namespace Slcorp\CoreBundle\Domain\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**Трейт для подключения к сущности и создания полей
 * $user_created и $user_modified
 * */
trait HasModifier
{
    private ?UserInterface $_user = null;

    public function __construct()
    {
    }

    public function setUser(?UserInterface $user): self
    {
        $this->_user = $user;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->_user;
    }

    /**Так не сработает, просто для наглядности, класс подставится в листнере src/Infrastructure/EventListener/DoctrineMetadataListener.php*/
    #[ORM\ManyToOne(targetEntity: '%academ_city_core.user_class%', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'user_created', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?UserInterface $user_created = null;

    /**Так не сработает, просто для наглядности, класс подставится в листнере src/Infrastructure/EventListener/DoctrineMetadataListener.php*/
    #[ORM\ManyToOne(targetEntity: '%academ_city_core.user_class%', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'user_created', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?UserInterface $user_modified = null;


    /**Вызывается в BlamableListener*/
    public function updateModifier(): void
    {
        if (null !== $this->getUser()) {
            $user = $this->getUser();
            if (null === $this->getUserCreated()) {
                $this->setUserCreated($user);
            }

            $this->setUserModified($user);
        }
    }

    public function getUserCreated(): ?UserInterface
    {
        return $this->user_created;
    }

    public function setUserCreated(?UserInterface $user_created): self
    {
        $this->user_created = $user_created;

        return $this;
    }

    public function getUserModified(): ?UserInterface
    {
        return $this->user_modified;
    }

    public function setUserModified(?UserInterface $user_modified): self
    {
        $this->user_modified = $user_modified;

        return $this;
    }
}
