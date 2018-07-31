<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Injector;

final class PropertyAccessInjector implements Injector
{
    /**
     * @var string
     */
    private $classContext;

    public function __construct(?string $classContext = null)
    {
        $this->classContext = $classContext;
    }

    public function inject(/*object */$target, string $property, /*object */$object): void
    {
        $this->createInjector($target)($property, $object);
    }

    private function createInjector(/*object */$target): \Closure
    {
        $injector = function (string $property, /*object */$object): void {
            if (\property_exists($this, $property) && null === $this->$property) {
                $this->$property = $object;
            }
        };

        return $injector->bindTo($target, $this->classContext ?? $target);
    }
}
