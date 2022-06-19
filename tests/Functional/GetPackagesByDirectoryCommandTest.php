<?php

declare(strict_types=1);

namespace Test\Functional\Repository;

use PHPUnit\Framework\TestCase;
use Repository\Infrastructure\Dependency\Composer\ComposerExecutor;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryPackageRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryProjectRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryScanDir;
use Repository\Infrastructure\UI\Console\GetPackagesByDirectoryCommand;
use Repository\UseCase\GetPackagesByDirectory\UseCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class GetPackagesByDirectoryCommandTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $useCase = new UseCase(
            new InMemoryScanDir(),
            new ComposerExecutor(),
            new InMemoryPackageRepository(),
            new InMemoryProjectRepository()
        );

        $command = new GetPackagesByDirectoryCommand($useCase);

        $app = new Application();
        $app->add($command);

        $this->commandTester = new CommandTester($command);
    }

    public function testGivenAFolderThenResponseWithAllProjectsAndPackages()
    {
        $this->commandTester->execute(
            [
                'folder' => __DIR__ . '/../data/projects',
            ]
        );

        $display = trim($this->commandTester->getDisplay());

        $this->assertStringContainsString('Project pgrau/1', $display);
        $this->assertStringContainsString('Project pgrau/2', $display);
        $this->assertStringContainsString('Project pgrau/3', $display);
    }

    public function testGivenAFolderWhenNotExistsThenHasAnEmptyResponse()
    {
        $this->commandTester->execute(
            [
                'folder' => __DIR__ . '/../data/projects/not-exist',
            ]
        );

        $display = trim($this->commandTester->getDisplay());

        $this->assertSame('', $display);
    }
}
