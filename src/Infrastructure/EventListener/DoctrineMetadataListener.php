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
                if ($mapping['fieldName'] === 'user_modified' || $mapping['fieldName'] === 'user_created') {
                    $association = $metadata->associationMappings[$field];
                    $class = get_class($association);
                    $newMapping = new $class(
                        $association->fieldName,
                        $association->sourceEntity,
                        $this->userClass
                    );
                    $metadata->associationMappings[$field] = $newMapping;

//                    $joinColumns = $association['joinColumns'] ?? [];
//
//                    foreach ($joinColumns as $joinColumn) {
//                        $columnName = $joinColumn['name'] ?? null;
//
//                        if ($columnName) {
//                            // Убедитесь, что индекс связан с колонкой
//                            $metadata->table['indexes']['IDX_' . strtoupper(md5($columnName))] = ['columns' => [$columnName]];
//                        }
//                    }
                }
            }
        }
    }
}