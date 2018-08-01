<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles;

use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Discworld;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class ProphecyTest extends TestDoublesTestCase
{
    /**
     * @var Vimes|ObjectProphecy
     */
    private $vimes;

    /**
     * @var Nobby|Copper|ObjectProphecy
     */
    private $nobby;

    /**
     * @var Fred|Copper|ObjectProphecy
     */
    private $fred;

    /**
     * @var Death
     */
    private $death;

    public function test_it_initialises_object_prophecies()
    {
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->vimes);
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->nobby);
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->fred);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes', $this->vimes->reveal());
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby', $this->nobby->reveal());
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred', $this->fred->reveal());
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper', $this->nobby->reveal());
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper', $this->fred->reveal());
    }

    public function test_object_prophecies_verify_expectations()
    {
        $discworld = new Discworld($this->vimes->reveal(), array($this->nobby->reveal(), $this->fred->reveal()));

        $discworld->createNightWatch();

        $this->vimes->recruit($this->nobby)->shouldHaveBeenCalled();
        $this->vimes->recruit($this->fred)->shouldHaveBeenCalled();
    }

    public function test_non_object_prophecies_are_ignored()
    {
        $this->assertNull($this->death);
    }
}
