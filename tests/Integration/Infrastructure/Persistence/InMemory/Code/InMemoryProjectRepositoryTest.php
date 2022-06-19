<?php

declare(strict_types=1);

namespace Test\Integration\Repository\Infrastructure\Persistence\InMemory\Code;

use PHPUnit\Framework\TestCase;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryProjectRepository;
use Repository\Infrastructure\Persistence\InMemory\Code\InMemoryProjectRepositoryException;

final class InMemoryProjectRepositoryTest extends TestCase
{
    private const PATH_OF_INVALID_COMPOSER_JSON = __DIR__ . '/../../../../../data/composer-malformed';

    private InMemoryProjectRepository $sut;

    protected function setUp(): void
    {
        $this->sut = new InMemoryProjectRepository();

        parent::setUp();
    }

    public function testGivenADirectoryWhenDirectoryNotExistsThenThrowAnError(): void
    {
        $this->expectException(InMemoryProjectRepositoryException::class);

        $this->sut->getOneByDirectory('NOT EXIST');
    }

    public function testGivenADirectoryWhenComposerJsonIsNotValidThenThrowAnError(): void
    {
        $this->expectException(InMemoryProjectRepositoryException::class);

        $this->sut->getOneByDirectory(self::PATH_OF_INVALID_COMPOSER_JSON);
    }
}
