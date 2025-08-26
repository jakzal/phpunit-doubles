<?php declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\TestCase;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;

trait ProphecyTestDoubles
{
    abstract protected function prophesize(?string $classOrInterface = null): ObjectProphecy;

    #[Before]
    protected function initialiseProphecyTestDoubles(): void
    {
        $doubler = new Doubler(
            new ReflectionExtractor([TestCase::class, Assert::class]),
            new PropertyAccessInjector(),
            function (array $types) {
                return $this->createTestDoubleWithProphecy($types);
            },
            ObjectProphecy::class
        );
        $doubler->createDoubles($this);
    }

    private function createTestDoubleWithProphecy(array $types): ObjectProphecy
    {
        $prophecy = $this->prophesize(\array_shift($types));

        foreach ($types as $type) {
            if (\interface_exists($type)) {
                $prophecy->willImplement($type);
            } else {
                $prophecy->willExtend($type);
            }
        }

        return $prophecy;
    }
}
