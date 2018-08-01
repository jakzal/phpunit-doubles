<?php

namespace Zalas\PHPUnit\Doubles\PhpDocumentor;

use PhpDocReader\PhpParser\UseStatementParser;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;
use Zalas\PHPUnit\Doubles\Extractor\Extractor;
use Zalas\PHPUnit\Doubles\Extractor\Property;

final class ReflectionExtractor implements Extractor
{
    private $parsedUseStatements = [];

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
        return \array_filter(
            \array_map($this->propertyFactory($class), $class->getProperties()),
            $this->buildFilter($filter)
        );
    }

    private function propertyFactory(\ReflectionClass $class)/*: callable*/
    {
        return function (\ReflectionProperty $propertyReflection) use ($class)/*: ?Property*/ {
            if ($propertyReflection->getDeclaringClass()->getName() === $class->getName()) {
                return $this->createProperty($propertyReflection);
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

    private function createProperty(\ReflectionProperty $propertyReflection)/*: ?Property*/
    {
        if ($propertyReflection->getDocComment()) {
            $docBlock = new DocBlock($propertyReflection);
            $var = $this->extractVar($docBlock);

            if (\in_array($var, ['bool', 'boolean', 'array', 'string', 'int', 'integer', 'float', 'double', 'mixed', 'null'])) {
                return null;
            }

            return null !== $var ? new Property(
                $propertyReflection->getName(),
                \array_map(
                    function ($type) use ($propertyReflection) {
                        return $this->resolveType($type, $propertyReflection);
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

    private function resolveType($type, \ReflectionProperty $propertyReflection)
    {
        $class = $propertyReflection->getDeclaringClass();
        foreach ($class->getTraits() as $trait) {
            if ($trait->hasProperty($propertyReflection->getName())) {
                $class = $trait;
            }
        }

        $resolvedType = \array_reduce($this->parseUseStatements($class), function ($type, $fqcn) {
            if (\preg_match('#\\\\'.\ltrim(\preg_quote($type, '#'), '\\').'$#', $fqcn)) {
                return $fqcn;
            }

            return $type;
        }, $type);

        if ($resolvedType !== $type) {
            return \ltrim($resolvedType, '\\');
        }

        return $class->getNamespaceName().$type;
    }

    private function parseUseStatements(\ReflectionClass $class)
    {
        if (isset($this->parsedUseStatements[$class->getName()])) {
            return $this->parsedUseStatements[$class->getName()];
        }

        $parser = new UseStatementParser();

        return $this->parsedUseStatements[$class->getName()] = $parser->parseUseStatements($class);
    }
}
