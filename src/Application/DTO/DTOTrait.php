<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace Slcorp\CoreBundle\Application\DTO;

trait DTOTrait
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $data): static
    {
        $dto = new static();

        foreach ($data as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }

    /**
     * @throws \JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}
