<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\TestCase;

use Zalas\PHPUnit\Doubles\Extractor\Extractor;
use Zalas\PHPUnit\Doubles\Extractor\Property;
use Zalas\PHPUnit\Doubles\Injector\Injector;

/**
 * @internal
 */
class Doubler
{
    /**
     * @var Extractor
     */
    private $extractor;

    /**
     * @var Injector
     */
    private $injector;

    /**
     * @var callable
     */
    private $doubleFactory;

    /**
     * @var string
     */
    private $doubleType;

    public function __construct(Extractor $extractor, Injector $injector, callable $doubleFactory, string $doubleType)
    {
        $this->extractor = $extractor;
        $this->injector = $injector;
        $this->doubleFactory = $doubleFactory;
        $this->doubleType = $doubleType;
    }

    public function createDoubles(/*object */$testCase)
    {
        foreach ($this->getTestDoubleProperties($testCase) as $property) {
            $this->injector->inject($testCase, $property->getName(), $this->createTestDouble($property));
        }
    }

    private function createTestDouble(Property $property)
    {
        return ($this->doubleFactory)($property->getTypesFiltered(function (string $type): bool {
            return $type !== $this->doubleType;
        }));
    }

    /**
     * @param object $testCase
     *
     * @return Property[]
     */
    private function getTestDoubleProperties(/*object */$testCase): array
    {
        return $this->extractor->extract($testCase, function (Property $property): bool {
            $doubleTypes = $property->getTypesFiltered(function (string $type): bool {
                return $type === $this->doubleType;
            });

            return \count($doubleTypes) > 0;
        });
    }
}
