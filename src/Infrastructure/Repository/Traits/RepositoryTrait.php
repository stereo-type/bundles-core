<?php

/**
 * @copyright  2025 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace Slcorp\CoreBundle\Infrastructure\Repository\Traits;

use Doctrine\ORM\EntityNotFoundException;

/**
 * Трейт для общих действий к репозиторию {@see ServiceEntityRepository}.
 */
trait RepositoryTrait
{
    public function save(object $object, bool $flush = true): object
    {
        $this->getEntityManager()->persist($object);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $object;
    }

    public function delete(object $entity, bool $flush = true): bool
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return true;
    }

    public function get(int $id): object
    {
        $channel = $this->find($id);
        if (!$channel) {
            throw new EntityNotFoundException('Entity not found with id = ' . $id);
        }

        return $channel;
    }
}
