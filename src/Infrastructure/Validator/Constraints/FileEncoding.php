<?php

/**
 * @package    FileEncoding.php
 * @copyright  2025 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace AcademCity\CoreBundle\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class FileEncoding extends Constraint
{
    public string $message = 'Файл должен быть в кодировке {{ encoding }}.';
    public string $encoding = 'UTF-8';

    public function __construct(string $encoding = 'UTF-8', ?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        if ($message) {
            $this->message = $message;
        }
        $this->encoding = $encoding;
        parent::__construct(['encoding' => $encoding, 'message' => $this->message] + ($options ?? []), $groups, $payload);
    }
}
