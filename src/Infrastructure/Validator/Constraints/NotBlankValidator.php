<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace CoreBundle\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotBlankValidator as CoreNotBlankValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotBlankValidator extends CoreNotBlankValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof NotBlank) {
            throw new UnexpectedTypeException($constraint, NotBlank::class);
        }

        if ($constraint->allowNull && null === $value) {
            return;
        }

        if (\is_string($value) && null !== $constraint->normalizer) {
            $value = ($constraint->normalizer)($value);
        }

        if (false === $value || (!$value && '0' != $value)) {
            $this->context->buildViolation(strtr($constraint->message, ['{{ field }}' => $this->context->getPropertyName()]))
                          ->setParameter('{{ value }}', $this->formatValue($value))
                          ->setCode(NotBlank::IS_BLANK_ERROR)
                          ->addViolation();
        }
    }
}
