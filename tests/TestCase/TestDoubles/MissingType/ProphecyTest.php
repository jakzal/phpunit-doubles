<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\MissingType;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;

class ProphecyTest extends TestCase
{
    use TestDoubles;

    /**
     * @var ObjectProphecy
     */
    private $fred;

    public function test_it_creates_std_class_if_type_is_missing()
    {
        $this->assertInstanceOf(ObjectProphecy::class, $this->fred);
        $this->assertInstanceOf(\stdClass::class, $this->fred->reveal());
    }
}
