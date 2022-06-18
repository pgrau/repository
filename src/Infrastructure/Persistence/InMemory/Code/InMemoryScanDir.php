<?php

declare(strict_types=1);

namespace Repository\Infrastructure\Persistence\InMemory\Code;

use Repository\Domain\Code\ScanDir;

final class InMemoryScanDir implements ScanDir
{
    public function findAll(string $folder): array
    {
        $current = 0;
        $dirs = $this->getFolders($folder);
        $next = $dirs[$current] ?? false;
        while ($next) {
            $subfolders = $this->getFolders($next);
            foreach ($subfolders as $subfolder) {
                $dirs[] = $subfolder;
            }
            $current++;
            $next = $dirs[$current] ?? false;
        }

        return $dirs;
    }

    /**
     * @return array <int, string>
     */
    private function getFolders(string $folder): array
    {
        if (! $folders = \glob($folder . '/*', GLOB_ONLYDIR)) {
            return [];
        }

        return array_filter($folders, function ($k) {
            return ! \preg_match('/\/vendor$/', $k);
        });
    }
}
