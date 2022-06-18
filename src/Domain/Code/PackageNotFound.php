<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

final class PackageNotFound extends \RuntimeException
{
    public static function byComposer(string $pathOfComposer): self
    {
        $msg = \sprintf('Path of composer not found: %s', $pathOfComposer);

        return new self($msg);
    }
}
