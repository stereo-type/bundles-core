<?php

namespace Slcorp\CoreBundle\Infrastructure\EventListener;

use Slcorp\CoreBundle\Domain\Entity\Traits\HasTimestamps;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TimeModifiedListener
{
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array(HasTimestamps::class, class_uses($entity), true)) {
            /**@var HasTimestamps $entity */
            $entity->updateTimestamps();
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array(HasTimestamps::class, class_uses($entity), true)) {
            /**@var HasTimestamps $entity */
            $entity->updateTimestamps();
        }
    }
}
