<?php

declare(strict_types=1);

namespace Slcorp\CoreBundle\Domain\Repository\Traits;

use Doctrine\DBAL\LockMode;

interface RepositoryInterface
{
    public function save(object $file, bool $flush = true): ?int;
    public function delete(object $file, bool $flush = true): void;

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): ?object;
    public function get(mixed $id): object;

    public function findOneBy(array $criteria, array|null $orderBy = null): ?object;

    public function findAll(): array;

    public function findBy(array $criteria, array|null $orderBy = null, int|null $limit = null, int|null $offset = null): array;
}