<?php

declare(strict_types=1);

namespace Test\Integration\Repository\UseCase;

use PHPUnit\Framework\TestCase;
use Repository\Domain\Code\Commit;
use Repository\Domain\Shared\Url;
use Repository\Infrastructure\Dependency\Composer\ComposerExecutor;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryPackageRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryScanDir;
use Repository\UseCase\ExecuteContinuousIntegrationByCommit;

final class ExecuteContinuousIntegrationByCommitTest extends TestCase
{
    const FOLDER = __DIR__ . '/../../data/projects';

    private ExecuteContinuousIntegrationByCommit\UseCase $sut;

    protected function setUp(): void
    {
        \apcu_clear_cache();

        $this->sut = new ExecuteContinuousIntegrationByCommit\UseCase(
            new InMemoryScanDir(),
            new ComposerExecutor(),
            new InMemoryPackageRepository()
        );

        parent::setUp();
    }

    public function testGivenANewCommitWhenAffectAProjectThenExecuteHisPipeline()
    {
        $aCommit = new Commit(
            new Url('https://github.com/pgrau/1.git'),
            '8b4a07d791168bd80e777c96340d381a5ab7e8da',
            'main'
        );

        $request = new ExecuteContinuousIntegrationByCommit\Request(
            self::FOLDER,
            $aCommit
        );

        $this->sut->execute($request);

        $iterator = new \APCUIterator();
        $this->assertSame(2, $iterator->getTotalCount());
    }
}
