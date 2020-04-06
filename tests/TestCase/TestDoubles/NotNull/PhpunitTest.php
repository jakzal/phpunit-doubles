<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\NotNull;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\TestCase\PHPUnitTestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;

class PhpunitTest extends TestCase
{
    use PHPUnitTestDoubles;

    /**
     * @var Nobby|MockObject
     */
    private $nobby;

    /**
     * @var Fred|MockObject
     */
    private $fred = 'Fred';

    /**
     * @before
     */
    public function crateNobby()
    {
        $this->nobby = $this->createMock(Copper::class);
    }

    public function test_properties_already_initialised_with_hooks_are_not_overridden()
    {
        $this->assertInstanceOf(MockObject::class, $this->nobby);
        $this->assertInstanceOf(Copper::class, $this->nobby);
        $this->assertNotInstanceOf(Nobby::class, $this->nobby);
    }

    public function test_properties_already_initialised_directly_are_not_overridden()
    {
        $this->assertIsString($this->fred);
        $this->assertSame('Fred', $this->fred);
    }
}
