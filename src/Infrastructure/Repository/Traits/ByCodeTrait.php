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
trait ByCodeTrait
{
    public function findByCode(string $code): ?object
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function getByCode(string $code): object
    {
        $channel = $this->findByCode($code);
        if (!$channel) {
            throw new EntityNotFoundException('Entity not found with CODE = ' . $code);
        }

        return $channel;
    }
}
