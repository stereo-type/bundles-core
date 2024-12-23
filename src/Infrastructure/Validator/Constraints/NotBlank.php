<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundleInfrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraints\NotBlank as CoreNotBlank;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NotBlank extends CoreNotBlank
{
    public string $message = 'Поле "{{ field }}" не может быть пустым';
}
