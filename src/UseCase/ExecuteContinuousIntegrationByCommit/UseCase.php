<?php

declare(strict_types=1);

namespace Repository\UseCase\ExecuteContinuousIntegrationByCommit;

use Repository\Domain\Code\PackageRepository;
use Repository\Domain\Code\ScanDir;
use Repository\Domain\Code\Executor;

final class UseCase
{
    public function __construct(
        private ScanDir $scandDir,
        private Executor $composerExecutor,
        private PackageRepository $packageRepository
    ) {
    }

    public function execute(Request $request): void
    {
        $dirs = $this->scandDir->findAll($request->folder);
        $this->composerExecutor->execute($dirs);
        foreach ($dirs as $dir) {
            $packages = $this->packageRepository->findByDirectory($dir);
            foreach ($packages->get() as $package) {
                $package->pushCommit($request->commit);
            }
        }
    }
}
