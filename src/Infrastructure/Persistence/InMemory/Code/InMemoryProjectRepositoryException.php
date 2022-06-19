<?php

declare(strict_types=1);

namespace Repository\Infrastructure\Persistence\InMemory\Code;

final class InMemoryProjectRepositoryException extends \RuntimeException
{
    public static function byThrowable(\Throwable $throwable): self
    {
        return new self($throwable->getMessage());
    }
}
