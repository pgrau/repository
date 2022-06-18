<?php

declare(strict_types=1);

namespace Test\Integration\Repository\Domain\Code;

use PHPUnit\Framework\TestCase;
use Repository\Domain\Code\Commit;
use Repository\Domain\Code\Package;
use Repository\Domain\Code\Project;
use Repository\Domain\Shared\Url;

final class PackageTest extends TestCase
{
    protected function setUp(): void
    {
        \apcu_clear_cache();

        parent::setUp();
    }

    public function testGivenAPackageHasAProjectObserverWhenDetachTheProjectThenNoPipelinesAreExecuted()
    {
        $aProject = new Project('pgrau/1');

        $name = 'pgrau/2';
        $version = '1.1.0';
        $url = new Url('https://github.com/pgrau/1.git');
        $reference = '8b5a07d791168bd80e777c96340d381a5ab7e8da';

        $aPackage = new Package($name, $version, $url, $reference);
        $aPackage->attach($aProject);

        $aCommit = new Commit(
            new Url('https://github.com/pgrau/1.git'),
            '8b4a07d791168bd80e777c96340d381a5ab7e8da',
            'main'
        );

        $aPackage->pushCommit($aCommit);

        $this->assertCount(1, $aProject->changedPackages());
        $this->assertSame($aPackage->name(), $aProject->changedPackages()[0]->name());
        $this->assertTrue(\apcu_exists($aProject->name()));

        \apcu_clear_cache();

        $aPackage->detach($aProject);

        $aPackage->pushCommit($aCommit);

        $this->assertFalse(\apcu_exists($aProject->name()));
    }
}
