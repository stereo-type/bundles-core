<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundle\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Email as CoreEmail;
use Symfony\Component\Validator\Constraints\EmailValidator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Email extends CoreEmail
{
    public string $message = 'Не корректный адрес email';

    public function validatedBy(): string
    {
        return EmailValidator::class;
    }
}
