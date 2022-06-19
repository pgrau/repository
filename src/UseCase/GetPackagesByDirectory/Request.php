<?php

declare(strict_types=1);

namespace Repository\UseCase\GetPackagesByDirectory;

final class Request
{
    public function __construct(
        public readonly string $folder
    ) {
    }
}
