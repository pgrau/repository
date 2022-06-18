<?php

declare(strict_types=1);

namespace Test\Integration\Repository\Infrastructure\Dependency\Composer;

use PHPUnit\Framework\TestCase;
use Repository\Infrastructure\Dependency\Composer\ComposerExecutor;

final class ComposerExecutorTest extends TestCase
{
    private const DIR_COMPOSER_JSON = __DIR__ . '/../../../../data/composer';

    private ComposerExecutor $sut;

    protected function setUp(): void
    {
        $this->sut = new ComposerExecutor();

        parent::setUp();
    }

    public function testGivenADirectoryWithAComposerJsonThenExecuteItAndGenerateComposerLock()
    {
        $composerLock = self::DIR_COMPOSER_JSON . '/composer.lock';
        if (\file_exists($composerLock)) {
            \unlink($composerLock);
        }

        $this->sut->execute([self::DIR_COMPOSER_JSON]);

        $this->assertTrue(\file_exists($composerLock));
    }
}
