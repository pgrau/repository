<?php

declare(strict_types=1);

namespace Repository\UseCase\GetProjectByPackageName;

use Repository\Domain\Code\Project;

final class Response
{
    /**
     * @var Project[]
     */
    private array $collection = [];

    public function __construct(Project ... $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Project[]
     */
    public function get(): array
    {
        return $this->collection;
    }
}
