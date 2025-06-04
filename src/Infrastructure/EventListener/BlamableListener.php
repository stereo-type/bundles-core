<?php

namespace AcademCity\CoreBundle\Infrastructure\EventListener;

use AcademCity\CoreBundle\Domain\Entity\Traits\HasModifier;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

class BlamableListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array(HasModifier::class, class_uses($entity), true)) {
            /**@var HasModifier $entity */
            $entity->setUser($this->security->getUser())->updateModifier();
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array(HasModifier::class, class_uses($entity), true)) {
            /**@var HasModifier $entity */
            $entity->setUser($this->security->getUser())->updateModifier();
        }
    }
}
