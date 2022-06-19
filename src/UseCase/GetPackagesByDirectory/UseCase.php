<?php

declare(strict_types=1);

namespace Repository\UseCase\GetPackagesByDirectory;

use Repository\Domain\Code\PackageRepository;
use Repository\Domain\Code\ProjectRepository;
use Repository\Domain\Code\ScanDir;
use Repository\Domain\Code\Executor;

final class UseCase
{
    public function __construct(
        private ScanDir $scandDir,
        private Executor $composerExecutor,
        private PackageRepository $packageRepository,
        private ProjectRepository $projectRepository
    ) {
    }

    public function execute(Request $request): Response
    {
        $response = new Response();
        $dirs = $this->scandDir->findAll($request->folder);
        $this->composerExecutor->execute($dirs);
        foreach ($dirs as $dir) {
            $project = $this->projectRepository->getOneByDirectory($dir);
            $packages = $this->packageRepository->findByDirectory($dir);
            $response->add($project, $packages);
        }

        return $response;
    }
}
