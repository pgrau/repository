<?php

declare(strict_types=1);

namespace Repository\UseCase\GetPackagesByDirectory;

use Repository\Domain\Code\PackageCollection;
use Repository\Domain\Code\Project;

final class Dto
{
    public function __construct(public readonly Project $project, public readonly PackageCollection $packages)
    {
    }
}
