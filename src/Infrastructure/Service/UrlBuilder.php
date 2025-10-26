<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace Slcorp\CoreBundle\Infrastructure\Service;

class UrlBuilder
{
    private string $path;
    private array $params = [];

    public function __construct(string $path, array $params = [])
    {
        if ($this->isAbsoluteUrl($path) && !str_contains($path, 'https://')) {
            $path = 'https://' . parse_url($path, PHP_URL_HOST) . parse_url($path, PHP_URL_PATH);
        }
        $this->path = $path;
        foreach ($params as $key => $value) {
            $this->addParam((string)$key, (string)$value);
        }
    }

    public static function create(string $path, array $params = []): self
    {
        return new self($path, $params);
    }

    public function addParam(string $key, string $value): self
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function out(bool $encoding = true): string
    {
        if (empty($this->params)) {
            return $this->path;
        }

        if ($encoding) {
            return $this->path.'?'.http_build_query($this->params);
        }

        $query = implode(
            '&',
            array_map(
                static fn ($key, $value) => $key.'='.$value,
                array_keys($this->params),
                array_values($this->params)
            )
        );

        return $this->path.'?'.$query;
    }

    private function isAbsoluteUrl(string $url): bool
    {
        return preg_match('/^(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', $url) || parse_url($url, PHP_URL_HOST);
    }
}
