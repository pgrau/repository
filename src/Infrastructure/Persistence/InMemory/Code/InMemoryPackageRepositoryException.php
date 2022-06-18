<?php

declare(strict_types=1);

namespace Repository\Infrastructure\Persistence\InMemory\Code;

final class InMemoryPackageRepositoryException extends \RuntimeException
{
    public static function byThrowable(\Throwable $throwable): self
    {
        return new self($throwable->getMessage());
    }

    public static function byDecodeComposerJson(string $path): self
    {
        return new self(\sprintf('Decode composer json failed: %s', $path));
    }
}
