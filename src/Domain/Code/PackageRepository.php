<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

interface PackageRepository
{
    public function findByPathOfComposer(string $pathOfComposerJson): PackageCollection;

    public function findByDirectory(string $directory): PackageCollection;
}
