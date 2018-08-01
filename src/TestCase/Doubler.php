<?php

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
     * @var array
     */
    private $doubleFactories;

    public function __construct(Extractor $extractor, Injector $injector, array $doubleFactories)
    {
        $this->extractor = $extractor;
        $this->injector = $injector;
        $this->doubleFactories = $doubleFactories;
    }

    public function createDoubles(/*object */$testCase)
    {
        foreach ($this->getTestDoubleProperties($testCase) as $property) {
            $this->injector->inject($testCase, $property->getName(), $this->createTestDouble($property));
        }
    }

    private function createTestDouble(Property $property)
    {
        $doubleType = $this->getDoubleType($property);
        $allDoubleTypes = \array_keys($this->doubleFactories);

        return $this->doubleFactories[$doubleType]($property->getTypesFiltered(function (/*string */$type) use ($allDoubleTypes)/*: bool*/ {
            return !\in_array($type, $allDoubleTypes);
        }));
    }

    /**
     * @param object $testCase
     *
     * @return Property[]
     */
    private function getTestDoubleProperties(/*object */$testCase)/*: array*/
    {
        $supportedDoubles = \array_keys($this->doubleFactories);

        return $this->extractor->extract($testCase, function (Property $property) use ($supportedDoubles)/*: bool*/ {
            $doubleTypes = $property->getTypesFiltered(function (/*string */$type) use ($supportedDoubles)/*: bool*/ {
                return \in_array($type, $supportedDoubles);
            });

            return \count($doubleTypes) > 0;
        });
    }

    private function getDoubleType(Property $property)/*: string*/
    {
        $supportedDoubles = \array_keys($this->doubleFactories);
        $doubleTypes = $property->getTypesFiltered(function (/*string */$type) use ($supportedDoubles)/*: bool*/ {
            return \in_array($type, $supportedDoubles);
        });

        if (\count($doubleTypes) > 1) {
            throw new \LogicException(\sprintf('Ambiguous test double definition for "%s": "%s".', $property->getName(), \implode('|', $property->getTypes())));
        }

        return \array_shift($doubleTypes);
    }
}
