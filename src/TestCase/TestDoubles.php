<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\TestCase;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Extractor\Property;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;

trait TestDoubles
{
    abstract public function getMockBuilder($className): MockBuilder;

    abstract protected function prophesize($classOrInterface = null): ObjectProphecy;

    /**
     * @before
     */
    protected function initialiseTestDoubles(): void
    {
        foreach ($this->getTestDoubleProperties() as $property) {
            if (\property_exists($this, $property->getName())) {
                $this->{$property->getName()} = $this->createTestDouble($property);
            }
        }
    }

    private function createTestDouble(Property $property)
    {
        if ($property->hasType(ObjectProphecy::class) && $property->hasType(MockObject::class)) {
            throw new \LogicException(\sprintf('Ambiguous test double definition for "%s": "%s".', $property->getName(), \implode('|', $property->getTypes())));
        }

        if ($property->hasType(ObjectProphecy::class)) {
            return $this->createTestDoubleWithProphecy($property->getTypesFiltered(function (string $type) {
                return ObjectProphecy::class !== $type;
            }));
        }

        if ($property->hasType(MockObject::class)) {
            return $this->createTestDoubleWithPhpunit($property->getTypesFiltered(function (string $type) {
                return MockObject::class !== $type;
            }));
        }
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
        $normalisedTypes = 1 === \count($types) ? \array_pop($types) : (!empty($types) ? $types : \stdClass::class);

        return $this->getMockBuilder($normalisedTypes)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disableProxyingToOriginalMethods()
            ->disallowMockingUnknownTypes()
            ->getMock();
    }

    /**
     * @return Property[]
     */
    private function getTestDoubleProperties(): array
    {
        return (new ReflectionExtractor())->extract($this, function (Property $property) {
            return $property->hasType(ObjectProphecy::class) || $property->hasType(MockObject::class);
        });
    }
}
