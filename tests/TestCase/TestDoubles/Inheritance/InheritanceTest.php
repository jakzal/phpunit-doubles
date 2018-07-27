<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Inheritance;

use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

class InheritanceTest extends BaseTestCase
{
    use TestDoubles;
    use PropertyTrait;

    public function test_it_does_not_initialise_inaccessible_properties()
    {
        $this->assertFalse(\property_exists($this, 'nobby'), 'Private properties are not inherited');
        $this->assertNull($this->getNobby(), 'Test doubles are only assigned if accessible');
    }

    public function test_it_initialises_accessible_parent_properties()
    {
        $this->assertInstanceOf(ObjectProphecy::class, $this->fred);
        $this->assertInstanceOf(Fred::class, $this->fred->reveal());
    }

    public function test_it_initialises_accessible_trait_properties()
    {
        $this->assertInstanceOf(ObjectProphecy::class, $this->vimes);
        $this->assertInstanceOf(Vimes::class, $this->vimes->reveal());
    }
}
