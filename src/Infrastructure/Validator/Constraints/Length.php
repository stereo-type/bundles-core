<?php

/**
 * @package    NotBlankWithFieldName.php
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace CoreBundle\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Length as CoreLength;
use Symfony\Component\Validator\Constraints\LengthValidator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Length extends CoreLength
{
    public string $maxMessage = 'Длина строки слишком большая. Максимальная длинна {{ limit }}';
    public string $minMessage = 'Длина строки слишком маленькая. Минимальная длинна {{ limit }}';

    public function validatedBy(): string
    {
        return LengthValidator::class;
    }
}
