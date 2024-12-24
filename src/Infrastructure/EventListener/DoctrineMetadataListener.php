<?php

/**
 * @package    DoctrineMetadataListener.php
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundle\Infrastructure\EventListener;

use AcademCity\CoreBundle\Domain\Entity\Traits\HasModifier;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class DoctrineMetadataListener
{
    private string $userClass;

    public function __construct(string $userClass)
    {
        $this->userClass = $userClass;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
    {
        $metadata = $args->getClassMetadata();
        $entityClass = $metadata->getName();

        if (in_array(HasModifier::class, class_uses($entityClass), true)) {
            foreach ($metadata->associationMappings as $field => $mapping) {
                if ($mapping['fieldName'] === 'user_modified') {
                    $object = $metadata->associationMappings[$field];
                    $class = get_class($object);
                    $newMapping = new $class(
                        $object->fieldName,
                        $object->sourceEntity,
                        $this->userClass
                    );
                    $metadata->associationMappings[$field] = $newMapping;
                }
            }
        }
    }
}