<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

interface ScanDir
{
    /**
     * @return array <int, string>
     */
    public function findAll(string $folder): array;
}
