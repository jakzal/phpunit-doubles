<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\AmbiguousDouble;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class AmbiguousDoubleRunner extends TestCase
{
    use TestDoubles;

    /**
     * @var Vimes|ObjectProphecy|MockObject
     */
    private $vimes;

    public function callInitialiseTestDoubles()
    {
        $this->initialiseTestDoubles();
    }
}
