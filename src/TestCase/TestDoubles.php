<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\TestCase;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;

trait TestDoubles
{
    abstract public function getMockBuilder(string $className): MockBuilder;

    abstract protected function prophesize(?string $classOrInterface = null): ObjectProphecy;

    /**
     * @before
     */
    protected function initialiseTestDoubles(): void
    {
        $doubler = new Doubler(
            new ReflectionExtractor([TestCase::class, Assert::class]),
            new PropertyAccessInjector(),
            [
                ObjectProphecy::class => function (array $types) {
                    return $this->createTestDoubleWithProphecy($types);
                },
                MockObject::class => function (array $types) {
                    return $this->createTestDoubleWithPhpunit($types);
                },
            ]
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

    private function createTestDoubleWithPhpunit(array $types): MockObject
    {
        $normalisedTypes = \array_shift($types) ?? \stdClass::class;

        return $this->getMockBuilder($normalisedTypes)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disableProxyingToOriginalMethods()
            ->disallowMockingUnknownTypes()
            ->getMock();
    }
}
