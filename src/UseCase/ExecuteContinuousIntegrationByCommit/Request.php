<?php

declare(strict_types=1);

namespace Repository\UseCase\ExecuteContinuousIntegrationByCommit;

use Repository\Domain\Code\Commit;

final class Request
{
    public function __construct(
        public readonly string $folder,
        public readonly Commit $commit,
    ) {
    }
}
