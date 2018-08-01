<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\NotNull;

use PHPUnit\Framework\MockObject\MockObject;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;

class PhpunitTest extends TestDoublesTestCase
{
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
        if (\method_exists($this, 'createMock')) {
            $this->nobby = $this->createMock('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper');
        } else {
            $this->nobby = $this->getMock('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper');
        }
    }

    public function test_properties_already_initialised_with_hooks_are_not_overridden()
    {
        $this->assertInstanceOf('PHPUnit\Framework\MockObject\MockObject', $this->nobby);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Copper', $this->nobby);
        $this->assertNotInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby', $this->nobby);
    }

    public function test_properties_already_initialised_directly_are_not_overridden()
    {
        $this->assertInternalType('string', $this->fred);
        $this->assertSame('Fred', $this->fred);
    }
}
