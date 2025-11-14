<?php

/**
 * @copyright  2025 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace Slcorp\CoreBundle\Infrastructure\Repository\Traits;

use Doctrine\Common\Collections\Criteria;

/**
 * Трейт для общих действий к репозиторию {@see ServiceEntityRepository}.
 */
trait SoftDeletingTrait
{
    public function softDelete(object $entity, bool $flush = true): bool
    {
        if (method_exists($entity, 'setDelete')) {
            $entity->setDelete(true);
            $this->getEntityManager()->persist($entity);

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        } else {
            return false;
        }

        return true;
    }

    public function softRestore(object $entity, bool $flush = true): bool
    {
        if (method_exists($entity, 'setDelete')) {
            $entity->setDelete(false);
            $this->getEntityManager()->persist($entity);

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        } else {
            return false;
        }

        return true;
    }

    public function findDeleted(int $id): ?object
    {
        $this->getEntityManager()->getFilters()->disable('soft_delete_filter');
        $entity = $this->find($id);
        $this->getEntityManager()->getFilters()->enable('soft_delete_filter');
        if (!$entity?->isDelete()) {
            return null;
        }

        return $entity;
    }

    public function findDeletedBy(array $criteria): ?object
    {
        $this->getEntityManager()->getFilters()->disable('soft_delete_filter');
        $entities = $this->findBy($criteria);
        foreach ($entities as $entity) {
            if ($entity->isDelete()) {
                /**Коллекция может быть с ленивой загрузкой, по этому после итерации включаем фильтр*/
                $this->getEntityManager()->getFilters()->enable('soft_delete_filter');

                return $entity;
            }
        }
        /**Коллекция может быть с ленивой загрузкой, по этому после итерации включаем фильтр*/
        $this->getEntityManager()->getFilters()->enable('soft_delete_filter');

        return null;
    }

    public function findDeletedList(array $criteria): array
    {
        $result = [];
        $this->getEntityManager()->getFilters()->disable('soft_delete_filter');
        $entities = $this->findBy($criteria);
        foreach ($entities as $entity) {
            if ($entity->isDelete()) {
                $result[] = $entity;
            }
        }
        /**Коллекция может быть с ленивой загрузкой, по этому после итерации включаем фильтр*/
        $this->getEntityManager()->getFilters()->enable('soft_delete_filter');

        return $result;
    }

    public function matchingDeletedBy(Criteria $criteria): ?object
    {
        $this->getEntityManager()->getFilters()->disable('soft_delete_filter');
        $entities = $this->matching($criteria);
        if (0 === $entities->count()) {
            $this->getEntityManager()->getFilters()->enable('soft_delete_filter');
            return null;
        }

        foreach ($entities as $entity) {
            if ($entity->isDelete()) {
                /**Коллекция с ленивой загрузкой, по этому после итерации включаем фильтр*/
                $this->getEntityManager()->getFilters()->enable('soft_delete_filter');

                return $entity;
            }
        }
        /**Коллекция с ленивой загрузкой, по этому после итерации включаем фильтр*/
        $this->getEntityManager()->getFilters()->enable('soft_delete_filter');

        return null;
    }
}
