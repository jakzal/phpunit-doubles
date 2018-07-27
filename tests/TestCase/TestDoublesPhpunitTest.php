<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Discworld;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Nobby;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Vimes;

class TestDoublesPhpunitTest extends TestCase
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

    public function test_it_initialises_mock_objects()
    {
        $this->assertInstanceOf(MockObject::class, $this->vimes);
        $this->assertInstanceOf(MockObject::class, $this->nobby);
        $this->assertInstanceOf(MockObject::class, $this->fred);
        $this->assertInstanceOf(Vimes::class, $this->vimes);
        $this->assertInstanceOf(Nobby::class, $this->nobby);
        $this->assertInstanceOf(Fred::class, $this->fred);
        $this->assertInstanceOf(Copper::class, $this->nobby);
        $this->assertInstanceOf(Copper::class, $this->fred);
    }

    public function test_mock_objects_verify_expectations()
    {
        $discworld = new Discworld($this->vimes, [$this->nobby, $this->fred]);

        $this->vimes->expects($this->at(0))->method('recruit')->with($this->nobby);
        $this->vimes->expects($this->at(1))->method('recruit')->with($this->fred);

        $discworld->createNightWatch();
    }
}
