<?php

declare(strict_types=1);

namespace Test\Functional\Repository;

use PHPUnit\Framework\TestCase;
use Repository\Infrastructure\Dependency\Composer\ComposerExecutor;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryPackageRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryScanDir;
use Repository\Infrastructure\UI\Console\PushCommitCommand;
use Repository\UseCase\ExecuteContinuousIntegrationByCommit\UseCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class PushCommitCommandTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        \apcu_clear_cache();

        $useCase = new UseCase(
            new InMemoryScanDir(),
            new ComposerExecutor(),
            new InMemoryPackageRepository()
        );

        $command = new class($useCase) extends PushCommitCommand {
            const FOLDER = __DIR__ . '/../data/projects';
        };

        $app = new Application();
        $app->add($command);

        $this->commandTester = new CommandTester($command);
    }

    public function testGivenACommitWhenPackageIsUpdatedThenExecutePipeline()
    {
        $this->commandTester->execute(
            [
                'urlGit' => 'https://github.com/pgrau/1.git',
                'commit' => '12322314235',
                'version' => 'main'
            ]
        );

        $display = trim($this->commandTester->getDisplay());

        $this->assertStringContainsString('pgrau/2', $display);
        $this->assertStringContainsString('pgrau/3', $display);

        $iterator = new \APCUIterator();
        $this->assertSame(2, $iterator->getTotalCount());
    }

    public function testGivenACommitWhenExternalPackageIsUpdatedThenNotExecutePipeline()
    {
        $this->commandTester->execute(
            [
                'urlGit' => 'https://github.com/symfony/console.git',
                'commit' => 'c9646197ef43b0e2ff44af61e7f0571526fd4170',
                'version' => 'v6.1.0'
            ]
        );

        $iterator = new \APCUIterator();
        $this->assertSame(0, $iterator->getTotalCount());
    }
}
