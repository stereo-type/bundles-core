<?php

declare(strict_types=1);

namespace Slcorp\CoreBundle\Domain\Repository;

use Doctrine\DBAL\LockMode;

/**
 * @template T of object
 */
interface RepositoryInterface
{
    /**
     * @param T $entity
     * @return  T
     */
    public function save(object $entity, bool $flush = true): object;

    /**
     * @param T $entity
     * @return  bool
     */
    public function delete(object $entity, bool $flush = true): bool;

    /**
     * @return  T|null
     */
    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): ?object;

    /**
     * @return  T
     */
    public function get(mixed $id): object;

    /**
     * @return  T|null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?object;

    /**
     * @return  T[]
     */
    public function findAll(): array;

    /**
     * @return  T[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, int|null $limit = null, int|null $offset = null): array;
}
