<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

interface Executor
{
    /**
     * @param array<int, string> $directories
     */
    public function execute(array $directories): void;
}
