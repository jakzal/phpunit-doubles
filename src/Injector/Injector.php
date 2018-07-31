<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Injector;

interface Injector
{
    public function inject(/*object */$target, string $property, /*object */$object): void;
}
