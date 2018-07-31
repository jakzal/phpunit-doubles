<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\Injector;

use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Injector\Injector;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures\NightWatch;
use Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures\Vimes;

class PropertyAccessInjectorTest extends TestCase
{
    public function test_it_is_an_injector()
    {
        $this->assertInstanceOf(Injector::class, new PropertyAccessInjector());
    }

    public function test_it_injects_object_directly_into_a_property()
    {
        $vimes = new Vimes();
        $nightWatch = new NightWatch();

        $injector = new PropertyAccessInjector();
        $injector->inject($nightWatch, 'commander', $vimes);

        $this->assertSame($vimes, $nightWatch->getCommander());
    }

    public function test_it_does_not_inject_anything_if_value_is_already_set()
    {
        $vimes = new Vimes();
        $imposter = new Vimes();
        $nightWatch = new NightWatch($vimes);

        $injector = new PropertyAccessInjector();
        $injector->inject($nightWatch, 'commander', $imposter);

        $this->assertSame($vimes, $nightWatch->getCommander());
    }

    public function test_it_does_not_inject_anything_if_property_is_not_accessible()
    {
        $nightWatch = new NightWatch();

        $injector = new PropertyAccessInjector();
        $injector->inject($nightWatch, 'recruits', new Vimes());

        $this->assertNull($nightWatch->getRecruits());
    }

    public function test_it_injects_object_into_a_parent_private_property_if_class_context_is_changed()
    {
        $vimes = new Vimes();
        $nightWatch = new class extends NightWatch {
        };

        $injector = new PropertyAccessInjector(NightWatch::class);
        $injector->inject($nightWatch, 'commander', $vimes);

        $this->assertSame($vimes, $nightWatch->getCommander());
    }
}
