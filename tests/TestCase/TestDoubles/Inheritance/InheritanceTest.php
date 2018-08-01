<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Inheritance;

use Zalas\PHPUnit\Doubles\TestCase\TestDoubles;

class InheritanceTest extends BaseTestCase
{
    use TestDoubles;
    use PropertyTrait;

    public function test_it_initialises_parent_private_properties()
    {
        $this->assertFalse(\property_exists($this, 'nobby'), 'Private properties are not created dynamically');
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->getNobby(), 'Test doubles are assigned to parent private properties');
    }

    public function test_it_initialises_accessible_parent_properties()
    {
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->fred);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred', $this->fred->reveal());
    }

    public function test_it_initialises_accessible_trait_properties()
    {
        $this->assertInstanceOf('Prophecy\Prophecy\ObjectProphecy', $this->vimes);
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes', $this->vimes->reveal());
    }
}
