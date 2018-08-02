<?php

namespace Zalas\PHPUnit\Doubles\Injector;

final class PropertyAccessInjector implements Injector
{
    public function inject(/*object */$target, /*string */$property, /*object */$object)/*: void*/
    {
        $injector = $this->createInjector($target, $property);
        $injector($object);
    }

    private function createInjector(/*object */$target, /*string */$property)/*: \Closure*/
    {
        $injector = function (/*object */$object) use ($property)/*: void*/ {
            if (null === $this->$property) {
                $this->$property = $object;
            }
        };

        return $injector->bindTo($target, $this->findScope($target, $property));
    }

    /**
     * @param object $target
     * @param string $property
     *
     * @return object|string
     */
    private function findScope(/*object */$target, /*string */$property)
    {
        if (\property_exists($target, $property)) {
            return $target;
        }

        return $this->findParentScope($target, $property);
    }

    private function findParentScope(/*object */$target, /*string */$property)/*: string*/
    {
        $class = \get_parent_class($target);

        while (!\property_exists($class, $property) && $parent = \get_parent_class($class)) {
            $class = $parent;
        }

        if (!\property_exists($class, $property)) {
            throw new \LogicException(\sprintf('The property "%s::%s" does not exist.', \get_class($target), $property));
        }

        return $class;
    }
}
