<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

interface ProjectRepository
{
    public function getOneByDirectory(string $directory): Project;
}
