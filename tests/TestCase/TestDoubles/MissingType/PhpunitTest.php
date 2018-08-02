<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\MissingType;

use PHPUnit\Framework\MockObject\MockObject;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;

class PhpunitTest extends TestDoublesTestCase
{
    /**
     * @var MockObject
     */
    private $fred;

    public function test_it_creates_std_class_if_type_is_missing()
    {
        $this->assertInstanceOf('PHPUnit\Framework\MockObject\MockObject', $this->fred);
        $this->assertInstanceOf('stdClass', $this->fred);
    }
}
