<?php

declare(strict_types=1);

namespace Repository\UseCase\GetProjectByPackageName;

final class Request
{
    public function __construct(
        public readonly string $folder,
        public readonly string $packageName
    ) {
    }
}
