<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\PhpDocumentor;

use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Extractor\Extractor;
use Zalas\PHPUnit\Doubles\Extractor\Property;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Detritus;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Rincewind;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Troll;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Discworld;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\World;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\World\Elephant;

class ReflectionExtractorTest extends TestCase
{
    /**
     * @var ReflectionExtractor
     */
    private $extractor;

    protected function setUp(): void
    {
        $this->extractor = new ReflectionExtractor([]);
    }

    public function test_it_is_an_extractor()
    {
        $this->assertInstanceOf(Extractor::class, $this->extractor);
    }

    public function test_it_extracts_properties_from_the_given_object()
    {
        $properties = $this->extractor->extract(new Discworld(), function () {
            return true;
        });

        $this->assertContainsOnlyInstancesOf(Property::class, $properties);
        $this->assertCount(6, $properties);
        $this->assertProperty('detritus', [Detritus::class, Troll::class], $properties[0]);
        $this->assertProperty('elephant1', [Elephant::class], $properties[1]);
        $this->assertProperty('elephant2', [Elephant::class], $properties[2]);
        $this->assertProperty('elephant3', [Elephant::class], $properties[3]);
        $this->assertProperty('elephant4', [Elephant::class], $properties[4]);
        $this->assertProperty('rincewind', [Rincewind::class], $properties[5]);
    }

    public function test_it_filters_properties_out()
    {
        $properties = $this->extractor->extract(new Discworld(), function (Property $property) {
            return $property->hasType(Rincewind::class);
        });

        $this->assertContainsOnlyInstancesOf(Property::class, $properties);
        $this->assertCount(1, $properties);
        $this->assertProperty('rincewind', [Rincewind::class], $properties[0]);
    }

    public function test_it_ignores_properties_by_class()
    {
        $this->extractor = new ReflectionExtractor([World::class]);

        $properties = $this->extractor->extract(new Discworld(), function (Property $property) {
            return true;
        });

        $this->assertContainsOnlyInstancesOf(Property::class, $properties);
        $this->assertCount(5, $properties);
    }

    private function assertProperty(string $name, array $types, $property)
    {
        $this->assertSame($name, $property->getName());
        $this->assertSame($types, $property->getTypes());
    }
}
