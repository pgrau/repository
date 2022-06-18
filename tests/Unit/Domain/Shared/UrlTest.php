<?php

declare(strict_types=1);

namespace Test\Unit\Repository\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Repository\Domain\Shared\Url;
use Repository\Domain\Shared\UrlNotValid;

final class UrlTest extends TestCase
{
    public function testGivenAUrlWhenIsValidThenGetTheUrl()
    {
        $aUrl = 'https://www.php.net';

        $this->assertSame($aUrl, (new Url($aUrl))->get());
    }

    public function testGivenAUrlWhenUrlIsNotValidThenThrowAnError()
    {
        $this->expectException(UrlNotValid::class);

        new Url('URL_NOT_VALID');
    }
}
