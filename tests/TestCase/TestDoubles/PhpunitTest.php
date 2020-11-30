<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\TestCase\PHPUnitTestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Death;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Discworld;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class PhpunitTest extends TestCase
{
    use PHPUnitTestDoubles;

    /**
     * @var Vimes|MockObject
     */
    private $vimes;

    /**
     * @var Copper|MockObject
     */
    private $nobby;

    /**
     * @var Copper|MockObject
     */
    private $fred;

    /**
     * @var Death
     */
    private $death;

    public function test_it_initialises_mock_objects()
    {
        $this->assertInstanceOf(MockObject::class, $this->vimes);
        $this->assertInstanceOf(MockObject::class, $this->nobby);
        $this->assertInstanceOf(MockObject::class, $this->fred);
        $this->assertInstanceOf(Vimes::class, $this->vimes);
        $this->assertInstanceOf(Copper::class, $this->nobby);
        $this->assertInstanceOf(Copper::class, $this->fred);
    }

    public function test_mock_objects_verify_expectations()
    {
        $discworld = new Discworld($this->vimes, [$this->nobby, $this->fred]);

        $this->vimes->expects($this->exactly(2))->method('recruit')->withConsecutive([$this->nobby], [$this->fred]);

        $discworld->createNightWatch();
    }

    public function test_non_mock_objects_are_ignored()
    {
        $this->assertNull($this->death);
    }
}
