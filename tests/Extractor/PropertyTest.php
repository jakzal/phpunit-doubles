<?php

namespace Zalas\PHPUnit\Doubles\Tests\Extractor;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Extractor\Property;

class PropertyTest extends TestCase
{
    public function test_it_exposes_its_properties()
    {
        $property = new Property('nobby', [ObjectProphecy::class]);

        $this->assertSame('nobby', $property->getName());
        $this->assertSame([ObjectProphecy::class], $property->getTypes());
    }

    public function test_it_checks_if_property_is_of_given_type()
    {
        $property = new Property('nobby', [ObjectProphecy::class]);

        $this->assertTrue($property->hasType(ObjectProphecy::class));
        $this->assertFalse($property->hasType(MockObject::class));
    }

    public function test_it_filters_types()
    {
        $property = new Property('nobby', [ObjectProphecy::class, MockObject::class]);

        $types = $property->getTypesFiltered(function (/*string */$type) {
            return MockObject::class !== $type;
        });

        $this->assertSame([ObjectProphecy::class], $types);
    }
}
