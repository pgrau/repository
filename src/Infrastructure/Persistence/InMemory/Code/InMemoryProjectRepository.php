<?php

declare(strict_types=1);

namespace Repository\Infrastructure\Persistence\InMemory\Code;

use Repository\Domain\Code\Project;
use Repository\Domain\Code\ProjectNotFound;
use Repository\Domain\Code\ProjectRepository;

final class InMemoryProjectRepository implements ProjectRepository
{
    public function getOneByDirectory(string $directory): Project
    {
        try {
            $pathOfComposerJson = $directory . '/composer.json';

            if (! file_exists($pathOfComposerJson)) {
                throw ProjectNotFound::byComposer($pathOfComposerJson);
            }

            if (! $composerJson = (array) \json_decode((strval(\file_get_contents($pathOfComposerJson))), true)) {
                throw InMemoryPackageRepositoryException::byDecodeComposerJson($pathOfComposerJson);
            }

            return new Project(\strval($composerJson['name']));
        } catch (\Throwable $t) {
            throw InMemoryProjectRepositoryException::byThrowable($t);
        }
    }
}
