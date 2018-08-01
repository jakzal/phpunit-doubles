<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\AmbiguousDouble;

use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class AmbiguousDoubleRunner extends TestDoublesTestCase
{
    /**
     * @var Vimes|ObjectProphecy|MockObject
     */
    private $vimes;

    public function callInitialiseTestDoubles()
    {
        $this->initialiseTestDoubles();
    }
}
