<?php

/**
 * @copyright  2025 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace Slcorp\CoreBundle\Application\Enum;

enum SessionCacheKeys: string
{
    case USER_OPERATIONS_LIST = 'user_operations_list';
}
