<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\MissingType;

use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;

class ProphecyTest extends TestDoublesTestCase
{
    /**
     * @var ObjectProphecy
     */
    private $fred;

    public function test_it_creates_std_class_if_type_is_missing()
    {
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->fred);
        $this->assertInstanceOf('stdClass', $this->fred->reveal());
    }
}
