<?php

declare(strict_types=1);

namespace Test\Functional\Repository;

use PHPUnit\Framework\TestCase;
use Repository\Infrastructure\Dependency\Composer\ComposerExecutor;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryPackageRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryProjectRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryScanDir;
use Repository\Infrastructure\UI\Console\GetProjectsByPackageNameCommand;
use Repository\UseCase\GetProjectByPackageName\UseCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class GetProjectsByPackageNameCommandTest extends TestCase
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

        $command = new GetProjectsByPackageNameCommand($useCase);

        $app = new Application();
        $app->add($command);

        $this->commandTester = new CommandTester($command);
    }

    public function testGivenAPackageNameThenResponseWithAllProjectsUseThatPackage()
    {
        $this->commandTester->execute(
            [
                'packageName' => 'pgrau/1',
                'folder' => __DIR__ . '/../data/projects',
            ]
        );

        $display = trim($this->commandTester->getDisplay());

        $this->assertStringNotContainsString('pgrau/1', $display);
        $this->assertStringContainsString('pgrau/2', $display);
        $this->assertStringContainsString('pgrau/3', $display);
    }
}
