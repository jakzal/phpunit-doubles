<?php

namespace Zalas\PHPUnit\Doubles\Tests\Injector;

use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures\NightWatch;
use Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures\Vimes;

class PropertyAccessInjectorTest extends TestCase
{
    public function test_it_is_an_injector()
    {
        $this->assertInstanceOf('Zalas\PHPUnit\Doubles\Injector\Injector', new PropertyAccessInjector());
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

    public function test_throws_an_exception_if_property_is_not_defined()
    {
        if (\method_exists($this, 'expectException')) {
            $this->expectException('LogicException');
            $this->expectExceptionMessage(\sprintf('The property "%s::nightRecruits" does not exist.', 'Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures\NightWatch'));
        } else {
            $this->setExpectedException('LogicException', \sprintf('The property "%s::nightRecruits" does not exist.', 'Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures\NightWatch'));
        }

        $nightWatch = new NightWatch();

        $injector = new PropertyAccessInjector();
        $injector->inject($nightWatch, 'nightRecruits', new Vimes());
    }

    public function test_it_injects_objects_into_parent_private_properties()
    {
        $nightWatch = new NightWatch();
        $vimes = new Vimes();

        $injector = new PropertyAccessInjector();
        $injector->inject($nightWatch, 'cityRecruits', $vimes);

        $this->assertSame($vimes, $nightWatch->getCityRecruits());
    }
}
