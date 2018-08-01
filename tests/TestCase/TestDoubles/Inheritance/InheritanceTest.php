<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Inheritance;

use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class InheritanceTest extends TestDoublesTestCase
{

    /**
     * @var Fred|ObjectProphecy
     */
    protected $fred;
    /**
     * @var Vimes|ObjectProphecy
     */
    private $vimes;

    /**
     * @var Nobby|ObjectProphecy
     */
    private $nobby;

    public function test_it_initialises_current_class_properties()
    {
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->vimes);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes', $this->vimes->reveal());
    }

    public function getNobby()
    {
        return $this->nobby;
    }
}
