<?php

declare(strict_types=1);

namespace Test\Integration\Repository\Infrastructure\Persistence\InMemory\Code;

use PHPUnit\Framework\TestCase;
use Repository\Domain\Code\PackageCollection;
use Repository\Domain\Code\PackageNotFound;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryPackageRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryPackageRepositoryException;

final class InMemoryPackageRepositoryTest extends TestCase
{
    private const PATH_OF_COMPOSER_JSON = __DIR__ . '/../../../../../data/composer.json';
    private const PATH_OF_COMPOSER_JSON_WITHOUT_COMPOSER_LOCK = __DIR__ . '/../../../../../data/composer/composer.json';
    private const PATH_OF_TXT = __DIR__ . '/../../../../../data/hello.txt';

    private InMemoryPackageRepository $sut;

    protected function setUp(): void
    {
        $this->sut = new InMemoryPackageRepository();

        parent::setUp();
    }

    public function testGivenAComposerLockGetAllPackages(): void
    {
        $packages = $this->sut->findByPathOfComposer(self::PATH_OF_COMPOSER_JSON);
        $this->assertInstanceOf(PackageCollection::class, $packages);
        $this->assertSame(9, $packages->count());
    }

    public function testGivenAnInvalidPathOfComposerLockThrowAnError(): void
    {
        $this->expectException(PackageNotFound::class);

        $this->sut->findByPathOfComposer('NOT_EXIST');
    }

    public function testGivenAValidPathOfComposerJsonWhenComposerLockNotExistsThenThrowAnError(): void
    {
        $composerLock = \str_replace('.json', '.lock', self::PATH_OF_COMPOSER_JSON_WITHOUT_COMPOSER_LOCK);
        if (\file_exists($composerLock)) {
            \unlink($composerLock);
        }

        $this->expectException(InMemoryPackageRepositoryException::class);

        $this->sut->findByPathOfComposer(self::PATH_OF_COMPOSER_JSON_WITHOUT_COMPOSER_LOCK);
    }

    public function testGivenAnInvalidComposerLockThrowAnError(): void
    {
        $this->expectException(InMemoryPackageRepositoryException::class);

        $this->sut->findByPathOfComposer(self::PATH_OF_TXT);
    }
}
