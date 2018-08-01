<?php

namespace Zalas\PHPUnit\Doubles\TestCase;

use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;

if (!\class_exists('PHPUnit\Framework\MockObject\MockObject')) {
    \class_alias('PHPUnit_Framework_MockObject_MockObject', 'PHPUnit\Framework\MockObject\MockObject');
}

trait TestDoubles
{
    abstract public function getMockBuilder($className)/*: MockBuilder;*/;

    abstract protected function prophesize($classOrInterface = null)/*: ObjectProphecy*/;

    /**
     * @before
     */
    protected function initialiseTestDoubles()/*: void*/
    {
        $doubler = new Doubler(
            new ReflectionExtractor(),
            new PropertyAccessInjector(),
            [
                'Prophecy\Prophecy\ObjectProphecy' => function (array $types) {
                    return $this->createTestDoubleWithProphecy($types);
                },
                'PHPUnit\Framework\MockObject\MockObject' => function (array $types) {
                    return $this->createTestDoubleWithPhpunit($types);
                },
            ]
        );
        $doubler->createDoubles($this);
    }

    private function createTestDoubleWithProphecy(array $types)/*: ObjectProphecy*/
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

    private function createTestDoubleWithPhpunit(array $types)/*: MockObject*/
    {
        $normalisedTypes = 1 === \count($types) ? \array_pop($types) : (!empty($types) ? $types : 'stdClass');

        return $this->getMockBuilder($normalisedTypes)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disableProxyingToOriginalMethods()
            ->getMock();
    }
}
