<?php

namespace Zalas\PHPUnit\Doubles\Tests\Extractor;

use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Extractor\Property;

class PropertyTest extends TestCase
{
    public function test_it_exposes_its_properties()
    {
        $property = new Property('nobby', ['Prophecy\Prophecy\ObjectProphecy']);

        $this->assertSame('nobby', $property->getName());
        $this->assertSame(['Prophecy\Prophecy\ObjectProphecy'], $property->getTypes());
    }

    public function test_it_checks_if_property_is_of_given_type()
    {
        $property = new Property('nobby', ['Prophecy\Prophecy\ObjectProphecy']);

        $this->assertTrue($property->hasType('Prophecy\Prophecy\ObjectProphecy'));
        $this->assertFalse($property->hasType('PHPUnit\Framework\MockObject\MockObject'));
    }

    public function test_it_filters_types()
    {
        $property = new Property('nobby', ['Prophecy\Prophecy\ObjectProphecy', 'PHPUnit\Framework\MockObject\MockObject']);

        $types = $property->getTypesFiltered(function (/*string */$type) {
            return 'PHPUnit\Framework\MockObject\MockObject' !== $type;
        });

        $this->assertSame(['Prophecy\Prophecy\ObjectProphecy'], $types);
    }
}
