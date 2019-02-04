<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Death;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Discworld;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Human;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class ProphecyTest extends TestCase
{
    use TestDoubles;

    /**
     * @var Vimes|ObjectProphecy
     */
    private $vimes;

    /**
     * @var Nobby|Copper|Human|ObjectProphecy
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
        $this->assertInstanceOf(ObjectProphecy::class, $this->vimes);
        $this->assertInstanceOf(ObjectProphecy::class, $this->nobby);
        $this->assertInstanceOf(ObjectProphecy::class, $this->fred);
        $this->assertInstanceOf(Vimes::class, $this->vimes->reveal());
        $this->assertInstanceOf(Nobby::class, $this->nobby->reveal());
        $this->assertInstanceOf(Fred::class, $this->fred->reveal());
        $this->assertInstanceOf(Copper::class, $this->nobby->reveal());
        $this->assertInstanceOf(Copper::class, $this->fred->reveal());
        $this->assertInstanceOf(Human::class, $this->nobby->reveal(), 'Test doubles can both extend classes and implement interfaces.');
    }

    public function test_object_prophecies_verify_expectations()
    {
        $discworld = new Discworld($this->vimes->reveal(), [$this->nobby->reveal(), $this->fred->reveal()]);

        $discworld->createNightWatch();

        $this->vimes->recruit($this->nobby)->shouldHaveBeenCalled();
        $this->vimes->recruit($this->fred)->shouldHaveBeenCalled();
    }

    public function test_non_object_prophecies_are_ignored()
    {
        $this->assertNull($this->death);
    }
}
