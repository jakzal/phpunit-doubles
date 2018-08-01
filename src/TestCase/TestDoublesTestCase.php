<?php

namespace Zalas\PHPUnit\Doubles\TestCase;

use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;

if (!\class_exists('PHPUnit\Framework\MockObject\MockObject')) {
    \class_alias('PHPUnit_Framework_MockObject_MockObject', 'PHPUnit\Framework\MockObject\MockObject');
}

abstract class TestDoublesTestCase extends TestCase
{
    public function createTestDoubleWithProphecy(array $types)/*: ObjectProphecy*/
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

    public function createTestDoubleWithPhpunit(array $types)/*: MockObject*/
    {
        $normalisedTypes = 1 === \count($types) ? \array_pop($types) : (!empty($types) ? $types : 'stdClass');

        return $this->getMockBuilder($normalisedTypes)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disableProxyingToOriginalMethods()
            ->getMock();
    }

    /**
     * @before
     */
    protected function initialiseTestDoubles()/*: void*/
    {
        $doubler = new Doubler(
            new ReflectionExtractor(),
            new PropertyAccessInjector(),
            array(
                'Prophecy\Prophecy\ObjectProphecy' => array($this, 'createTestDoubleWithProphecy'),
                'PHPUnit\Framework\MockObject\MockObject' => array($this, 'createTestDoubleWithPhpunit'),
            )
        );
        $doubler->createDoubles($this);
    }
}
