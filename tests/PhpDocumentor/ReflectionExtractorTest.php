<?php

namespace Zalas\PHPUnit\Doubles\Tests\PhpDocumentor;

use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Extractor\Property;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Discworld;

class ReflectionExtractorTest extends TestCase
{
    public function test_it_is_an_extractor()
    {
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Extractor\Extractor', new ReflectionExtractor());
    }

    public function test_it_extracts_properties_from_the_given_object()
    {
        $extractor = new ReflectionExtractor();

        $properties = $extractor->extract(new Discworld(), function () {
            return true;
        });

        $this->assertContainsOnlyInstancesOf('Zalas\PHPUnit\Doubles\Extractor\Property', $properties);
        $this->assertCount(2, $properties);
        $this->assertProperty('detritus', array('Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Detritus', 'Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Troll'), $properties[0]);
        $this->assertProperty('rincewind', array('Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Rincewind'), $properties[1]);
    }

    public function test_it_filters_properties_out()
    {
        $extractor = new ReflectionExtractor();

        $properties = $extractor->extract(new Discworld(), function (Property $property) {
            return $property->hasType('Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Rincewind');
        });

        $this->assertContainsOnlyInstancesOf('Zalas\PHPUnit\Doubles\Extractor\Property', $properties);
        $this->assertCount(1, $properties);
        $this->assertProperty('rincewind', array('Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Rincewind'), $properties[0]);
    }

    private function assertProperty(/*string */$name, array $types, $property)
    {
        $this->assertSame($name, $property->getName());
        $this->assertSame($types, $property->getTypes());
    }
}
