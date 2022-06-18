<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

use Repository\Domain\Shared\Url;

final class Commit
{
    public function __construct(
        private readonly Url $url,
        private readonly string $id,
        private readonly string $version
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function url(): string
    {
        return $this->url->get();
    }

    public function version(): string
    {
        return $this->version;
    }
}
