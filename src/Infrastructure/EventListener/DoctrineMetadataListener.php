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

        // Проверяем, использует ли класс трейт HasModifier
        if (in_array(HasModifier::class, class_uses($entityClass), true)) {
            // Обновляем метаданные
            foreach ($metadata->associationMappings as $field => $mapping) {
                if ($mapping['fieldName'] === 'user_modified') {
                    $metadata->associationMappings[$field]['targetEntity'] = $this->userClass;
                }
            }
        }
    }
}