<?php

namespace Zalas\PHPUnit\Doubles\PhpDocumentor;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Context;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;
use phpDocumentor\Reflection\DocBlockFactory;
use Zalas\PHPUnit\Doubles\Extractor\Extractor;
use Zalas\PHPUnit\Doubles\Extractor\Property;

final class ReflectionExtractor implements Extractor
{
    /**
     * @param object   $object
     * @param callable $filter
     *
     * @return Property[]
     */
    public function extract(/*object */$object, callable $filter)/*: array*/
    {
        return $this->extractFromReflection(new \ReflectionClass($object), $filter);
    }

    /**
     * @return Property[]
     */
    private function extractFromReflection(\ReflectionClass $class, callable $filter)/*: array*/
    {
        $properties = $this->mapClassToProperties($class, $filter);
        $parentProperties = $class->getParentClass() ? $this->extractFromReflection($class->getParentClass(), $filter) : [];

        return \array_merge($properties, $parentProperties);
    }

    /**
     * @return Property[]
     */
    private function mapClassToProperties(\ReflectionClass $class, callable $filter)/*: array*/
    {
        $classContext = new Context($class->getName());

        return \array_filter(
            \array_map($this->propertyFactory($class, $classContext), $class->getProperties()),
            $this->buildFilter($filter)
        );
    }

    private function propertyFactory(\ReflectionClass $class, $classContext)/*: callable*/
    {
        return function (\ReflectionProperty $propertyReflection) use ($classContext, $class)/*: ?Property*/ {
            $context = $this->getTraitContextIfExists($propertyReflection);

            $context = $context ? $context : new Context($propertyReflection->getDeclaringClass()->getName());

            if ($propertyReflection->getDeclaringClass()->getName() === $class->getName()) {
                return $this->createProperty($propertyReflection, $context);
            }

            return null;
        };
    }

    private function buildFilter(callable $filter)/*: callable*/
    {
        return function ($property) use ($filter)/*: bool*/ {
            return $property instanceof Property && $filter($property);
        };
    }

    private function getTraitContextIfExists(\ReflectionProperty $propertyReflection)/*: ?Context*/
    {
        foreach ($propertyReflection->getDeclaringClass()->getTraits() as $trait) {
            if ($trait->hasProperty($propertyReflection->getName())) {
                return new Context($trait->getName());
            }
        }

        return null;
    }

    private function createProperty(\ReflectionProperty $propertyReflection/*, DocBlockFactory $docBlockFactory*/, Context $context)/*: ?Property*/
    {
        if ($propertyReflection->getDocComment()) {
            $docBlock = new DocBlock($propertyReflection, $context);
            $var = $this->extractVar($docBlock);

            return null !== $var ? new Property(
                $propertyReflection->getName(),
                \array_map(
                    function ($type) {
                        return \ltrim($type, '\\');
                    },
                    \explode('|', $var)
                )
            ) : null;
        }

        return null;
    }

    private function extractVar(DocBlock $docBlock)/*: ?string*/
    {
        $var = $this->getFirstTag($docBlock, 'var');

        return $var instanceof VarTag ? (string) $var->getType() : null;
    }

    private function getFirstTag(DocBlock $docBlock, /*string */$name)/*: ?Tag*/
    {
        $tags = $docBlock->getTagsByName($name);

        return isset($tags[0]) ? $tags[0] : null;
    }
}
