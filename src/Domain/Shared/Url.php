<?php

declare(strict_types=1);

namespace Repository\Domain\Shared;

final class Url
{
    public function __construct(
        private readonly string $url,
    ) {
        if (! \filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw UrlNotValid::by($this->url);
        }
    }

    public function get(): string
    {
        return $this->url;
    }
}
