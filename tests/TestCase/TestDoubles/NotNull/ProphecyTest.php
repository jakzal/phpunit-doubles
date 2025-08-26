<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\NotNull;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\ProphecyTestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;

class ProphecyTest extends TestCase
{
    use ProphecyTrait;
    use ProphecyTestDoubles;

    /**
     * @var Nobby|ObjectProphecy
     */
    private $nobby;

    /**
     * @var Fred|ObjectProphecy
     */
    private $fred = 'Fred';

    #[Before]
    public function createNobby()
    {
        $this->nobby = $this->prophesize(Copper::class);
    }

    public function test_properties_already_initialised_with_hooks_are_not_overridden()
    {
        $this->assertInstanceOf(ObjectProphecy::class, $this->nobby);
        $this->assertInstanceOf(Copper::class, $this->nobby->reveal());
        $this->assertNotInstanceOf(Nobby::class, $this->nobby->reveal());
    }

    public function test_properties_already_initialised_directly_are_not_overridden()
    {
        $this->assertIsString($this->fred);
        $this->assertSame('Fred', $this->fred);
    }
}
