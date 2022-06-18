<?php

declare(strict_types=1);

namespace Repository\Infrastructure\Persistence\InMemory\Code;

use Repository\Domain\Code\Package;
use Repository\Domain\Code\PackageCollection;
use Repository\Domain\Code\PackageNotFound;
use Repository\Domain\Code\PackageRepository;
use Repository\Domain\Code\Project;
use Repository\Domain\Shared\Url;

final class InMemoryPackageRepository implements PackageRepository
{
    public function findByDirectory(string $directory): PackageCollection
    {
        return $this->findByPathOfComposer($directory . '/composer.json');
    }

    public function findByPathOfComposer(string $pathOfComposerJson): PackageCollection
    {
        if (! file_exists($pathOfComposerJson)) {
            throw PackageNotFound::byComposer($pathOfComposerJson);
        }

        try {
            if (! $composerJson = (array) \json_decode((strval(\file_get_contents($pathOfComposerJson))), true)) {
                throw InMemoryPackageRepositoryException::byDecodeComposerJson($pathOfComposerJson);
            }

            $project = new Project(\strval($composerJson['name']));

            $pathOfComposerLock = \str_replace('.json', '.lock', $pathOfComposerJson);

            if (! file_exists($pathOfComposerLock)) {
                throw PackageNotFound::byComposer($pathOfComposerLock);
            }

            $collection = new PackageCollection();
            $data = (array) \json_decode((string) \file_get_contents($pathOfComposerLock), true);
            $packages = $data['packages'] ?? [];

            foreach ((array) $packages as $item) {
                if (is_array($item)) {
                    $package = new Package(
                        \strval($item['name']),
                        \str_replace('dev-', '', \strval($item['version'])),
                        new Url(\strval($item['source']['url'])),
                        \strval($item['source']['reference'])
                    );

                    $package->attach($project);

                    $collection->add($package);
                }
            }

            return $collection;
        } catch (\Throwable $t) {
            throw InMemoryPackageRepositoryException::byThrowable($t);
        }
    }
}
