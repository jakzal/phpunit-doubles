<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Death;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Discworld;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class PhpunitTest extends TestCase
{
    use TestDoubles;

    /**
     * @var Vimes|MockObject
     */
    private $vimes;

    /**
     * @var Nobby|Copper|MockObject
     */
    private $nobby;

    /**
     * @var Fred|Copper|MockObject
     */
    private $fred;

    /**
     * @var Death
     */
    private $death;

    public function test_it_initialises_mock_objects()
    {
        $this->assertInstanceOf('PHPUnit\Framework\MockObject\MockObject', $this->vimes);
        $this->assertInstanceOf('PHPUnit\Framework\MockObject\MockObject', $this->nobby);
        $this->assertInstanceOf('PHPUnit\Framework\MockObject\MockObject', $this->fred);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes', $this->vimes);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby', $this->nobby);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred', $this->fred);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper', $this->nobby);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper', $this->fred);
    }

    public function test_mock_objects_verify_expectations()
    {
        $discworld = new Discworld($this->vimes, [$this->nobby, $this->fred]);

        $this->vimes->expects($this->at(0))->method('recruit')->with($this->nobby);
        $this->vimes->expects($this->at(1))->method('recruit')->with($this->fred);

        $discworld->createNightWatch();
    }

    public function test_non_mock_objects_are_ignored()
    {
        $this->assertNull($this->death);
    }
}
