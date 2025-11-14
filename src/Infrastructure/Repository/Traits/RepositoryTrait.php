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
 * @template T
 */
trait RepositoryTrait
{
    /**
     * @param T $entity
     * @return  T
     */
    public function save(object $entity, bool $flush = true): object
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * @param T $entity
     * @return  T
     */
    public function delete(object $entity, bool $flush = true): bool
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return true;
    }

    /**
     * @return  T
     */
    public function get(mixed $id): object
    {
        $channel = $this->find($id);
        if (!$channel) {
            throw new EntityNotFoundException('Entity not found with id = ' . $id);
        }

        return $channel;
    }
}
