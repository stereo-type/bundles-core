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
                $fieldName = $mapping['fieldName'];
                if ($fieldName === 'user_modified' || $fieldName === 'user_created') {
                    $association = $metadata->associationMappings[$field];
                    $class = get_class($association);
                    $newMapping = new $class(
                        $association->fieldName,
                        $association->sourceEntity,
                        $this->userClass
                    );
                    $metadata->associationMappings[$field] = $newMapping;

                    $joinColumn = [
                        'name' => $fieldName,
                        'referencedColumnName' => 'id',
                        'nullable' => true,
                    ];

                    $metadata->associationMappings[$field]['joinColumns'] = [$joinColumn];
                    $metadata->table['indexes']['IDX_' . strtoupper(md5($entityClass . $fieldName))] = ['columns' => [$fieldName]];
                }
            }
        }
    }
}