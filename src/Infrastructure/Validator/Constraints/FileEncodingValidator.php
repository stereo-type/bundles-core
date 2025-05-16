<?php
/**
 * @package    FileEncodingValidator.php
 * @copyright  2025 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace AcademCity\CoreBundle\Infrastructure\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FileEncodingValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof UploadedFile) {
            return;
        }

        $filePath = $value->getRealPath();

        $content = file_get_contents($filePath);

        $encoding = mb_detect_encoding($content, ['UTF-8', 'Windows-1251', 'ISO-8859-1'], true);

        if ($encoding !== $constraint->encoding) {
            $this->context->buildViolation($constraint->message)
                          ->setParameter('{{ encoding }}', $constraint->encoding)
                          ->addViolation();
        }
    }
}