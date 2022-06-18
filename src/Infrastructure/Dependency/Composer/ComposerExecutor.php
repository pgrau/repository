<?php

declare(strict_types=1);

namespace Repository\Infrastructure\Dependency\Composer;

use Repository\Domain\Code\Executor;

final class ComposerExecutor implements Executor
{
    /**
     * @param array<int, string> $directories
     */
    public function execute(array $directories): void
    {
        $fiber = new \Fiber(function (array $directories): void {
            foreach ($directories as $dir) {
                $composerLock = $dir . '/composer.lock';
                $composerJson = $dir . '/composer.json';

                if (\file_exists($composerLock) || ! \file_exists($composerJson)) {
                    continue;
                }

                \exec(\sprintf('cd %s && composer install --prefer-dist --no-progress --quiet', $dir));
            }

            \Fiber::suspend($directories);
        });

        $fiber->start($directories);
    }
}
