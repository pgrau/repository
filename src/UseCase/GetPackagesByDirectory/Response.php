<?php

declare(strict_types=1);

namespace Repository\UseCase\GetPackagesByDirectory;

use Repository\Domain\Code\PackageCollection;
use Repository\Domain\Code\Project;

final class Response
{
    /**
     * @var Dto[]
     */
    private array $collection = [];

    public function add(Project $project, PackageCollection $packageCollection): self
    {
        $this->collection[] = new Dto($project, $packageCollection);

        return $this;
    }

    /**
     * @return  Dto[]
     */
    public function get(): array
    {
        return $this->collection;
    }
}
