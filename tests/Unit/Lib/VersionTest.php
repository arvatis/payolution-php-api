<?php

namespace ArvPayolutionApi\Unit\Lib;

use ArvPayolutionApi\Lib\Version;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    public function testNonEmptyVersionCanBeRetrieved()
    {
        self::assertTrue((bool)Version::getVersion());
    }
}
