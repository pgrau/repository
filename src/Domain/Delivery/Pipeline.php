<?php

declare(strict_types=1);

namespace Repository\Domain\Delivery;

use Repository\Domain\Code\Project;

final class Pipeline
{
    public static function execute(Project $project): void
    {
        //ToDo at the moment we save the project on apcu
        \apcu_store($project->name(), true);
    }
}
