<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\MissingType;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;

class PhpunitTest extends TestCase
{
    use TestDoubles;

    /**
     * @var MockObject
     */
    private $fred;

    public function test_it_creates_std_class_if_type_is_missing()
    {
        $this->assertInstanceOf(MockObject::class, $this->fred);
        $this->assertInstanceOf(\stdClass::class, $this->fred);
    }
}
