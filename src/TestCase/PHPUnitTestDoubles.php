<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\TestCase;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\Injector\PropertyAccessInjector;
use Zalas\PHPUnit\Doubles\PhpDocumentor\ReflectionExtractor;

trait PHPUnitTestDoubles
{
    abstract public function getMockBuilder(string $className): MockBuilder;

    /**
     * @before
     */
    protected function initialisePHPUnitTestDoubles(): void
    {
        $doubler = new Doubler(
            new ReflectionExtractor([TestCase::class, Assert::class]),
            new PropertyAccessInjector(),
            function (array $types) {
                return $this->createTestDoubleWithPhpunit($types);
            },
            MockObject::class
        );
        $doubler->createDoubles($this);
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
