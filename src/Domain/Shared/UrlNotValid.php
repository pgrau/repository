<?php

declare(strict_types=1);

namespace Repository\Domain\Shared;

final class UrlNotValid extends \RuntimeException
{
    public static function by(string $url): self
    {
        $msg = \sprintf('Url not valid: %s', $url);

        return new self($msg);
    }
}
