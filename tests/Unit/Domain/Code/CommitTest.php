<?php

declare(strict_types=1);

namespace Test\Unit\Repository\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Repository\Domain\Code\Commit;
use Repository\Domain\Shared\Url;

final class CommitTest extends TestCase
{
    public function testGivenNewCommitThenGetAllProperties()
    {
        $url = 'https://github.com/pgrau/1.git';
        $reference = '8b4a07d791168bd80e777c96340d381a5ab7e8da';
        $version = 'feature-new-track';

        $aCommit = new Commit(
            new Url($url),
            $reference,
            $version
        );

        $this->assertSame($url, $aCommit->url());
        $this->assertSame($reference, $aCommit->id());
        $this->assertSame($version, $aCommit->version());
    }
}
