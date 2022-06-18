<?php

declare(strict_types=1);

namespace Test\Unit\Repository\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Repository\Domain\Code\Package;
use Repository\Domain\Shared\Url;

final class PackageTest extends TestCase
{
    public function testGivenNewCommitThenGetAllProperties()
    {
        $name = 'pgrau/1';
        $version = '1.0.0';
        $url = new Url('https://github.com/pgrau/1.git');
        $reference = '8b4a07d791168bd80e777c96340d381a5ab7e8da';

        $aPackage = new Package($name, $version, $url, $reference);

        $this->assertSame($name, $aPackage->name());
        $this->assertSame($version, $aPackage->version());
        $this->assertSame($url->get(), $aPackage->url()->get());
        $this->assertSame($reference, $aPackage->reference());
    }
}
